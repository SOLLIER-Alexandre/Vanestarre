<?php
    namespace Vanestarre\Controller\Message;

    use CURLFile;
    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseConnectionException;
    use Vanestarre\Exception\DatabaseInsertException;
    use Vanestarre\Exception\DatabaseUpdateException;
    use Vanestarre\Exception\ImageUploadException;
    use Vanestarre\Exception\MessageEditionException;
    use Vanestarre\Exception\MessageInsertionException;
    use Vanestarre\Model\AuthDB;
    use Vanestarre\Model\MessagesDB;
    use Vanestarre\Model\VanestarreConfig;

    /**
     * Class PostMessageController
     *
     * Controller for the message posting
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\Message
     */
    class MessagePostController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            session_start();
            try {
                $auth_db = new AuthDB();
                $connected_user = $auth_db->get_logged_in_user();
            } catch (DatabaseConnectionException $e) {
                // Authentication is down, we'll redirect the user to /unauthorized
                $connected_user = null;
            }

            if (!isset($connected_user) || $connected_user->get_id() !== 0) {
                // User is not authorized
                http_response_code(401);
                header('Location: /unauthorized');
                return;
            }

            $redirect_route = '/';

            // Check if there was a message ID sent
            $message_id = null;
            if (is_numeric($_POST['messageId'])) {
                $message_id = intval($_POST['messageId']);
            }

            // Check that all values are correct
            if (isset($_POST['message']) && mb_strlen($_POST['message']) > 0 && mb_strlen($_POST['message']) <= 50) {
                // Check if there was an image uploaded
                $image_path = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image_path = $_FILES['image']['tmp_name'];
                }

                // Try to post the message
                try {
                    $this->post_message($_POST['message'], $image_path, $message_id);
                } catch (MessageInsertionException $e) {
                    // Message couldn't be inserted
                    $redirect_route = '/home?err=2';
                    http_response_code(400);
                } catch (MessageEditionException $e) {
                    // Message couldn't be edited
                    $redirect_route = '/home?err=10';
                    http_response_code(400);
                } catch (ImageUploadException $e) {
                    // Attached image couldn't be uploaded
                    $redirect_route = '/home?err=20';
                    http_response_code(400);
                } catch (DatabaseConnectionException $e) {
                    // Couldn't connect to the database
                    $redirect_route = '/home?err=1';
                    http_response_code(400);
                }
            } else {
                // One of the parameter was malformed
                $redirect_route = '/home?err=1';
                http_response_code(400);
            }

            header('Location: ' . $redirect_route);
        }

        /**
         * Uploads an image to Imgur
         * @param string $filepath Path of the image to upload
         * @return string The Imgur link to the uploaded image
         * @throws ImageUploadException
         */
        private function upload_image_to_imgur(string $filepath): string {
            // Send the image to Imgur
            $curl = curl_init();
            $curl_file = new CURLFile($filepath);

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.imgur.com/3/image',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('image' => $curl_file),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Client-ID 7ea23f3e8e27f15'
                ),
            ));

            // Get the response
            $response = curl_exec($curl);
            curl_close($curl);

            // Check that everything happened as expected
            $decoded_response = json_decode($response, true);
            if (!$decoded_response['success']) {
                // The image failed to upload
                throw new ImageUploadException();
            }

            return $decoded_response['data']['link'];
        }

        /**
         * Add a new/Edit an existing message in the database
         * @param string $message Message contents
         * @param string|null $image_path Path of the image to upload in the local filesystem, pass null for none
         * @param int|null $message_id ID of the message to edit, pass null to add a new one
         * @throws DatabaseConnectionException
         * @throws ImageUploadException
         * @throws MessageEditionException
         * @throws MessageInsertionException
         */
        private function post_message(string $message, ?string $image_path, ?int $message_id): void {
            $message_db = new MessagesDB();

            // Check if there is an image, and upload it to Imgur if so
            $image_link = null;
            if (isset($image_path)) {
                $image_link = $this->upload_image_to_imgur($image_path);
            }

            if (isset($message_id)) {
                // We've got a message ID, we have to edit an existing message
                try {
                    $message_db->edit_message(intval($_POST['messageId']), $message, $image_link);
                } catch (DatabaseUpdateException $e) {
                    // There was an error while trying to edit the message
                    throw new MessageEditionException();
                }
            } else {
                // Draw a random number for the donation """feature"""
                $config = new VanestarreConfig();
                $reaction_count = rand($config->get_love_lim_inf(), $config->get_love_lim_sup());

                // Add a new message
                try {
                    $message_db->add_message($message, $image_link, $reaction_count);
                } catch (DatabaseInsertException $e) {
                    // There was an error while trying to add the message
                    throw new MessageInsertionException();
                }
            }
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Post message';
        }

        /**
         * @inheritDoc
         */
        public function get_stylesheets(): array {
            return [];
        }

        /**
         * @inheritDoc
         */
        public function get_scripts(): array {
            return [];
        }

        /**
         * @inheritDoc
         */
        public function needs_standard_layout(): bool {
            return false;
        }
    }

?>