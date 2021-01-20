<?php
    namespace Vanestarre\Controller;

    use Exception;
    use Vanestarre\Model\MessagesDB;

    /**
     * Class PostMessageController
     *
     * Controller for the message posting
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller
     */
    class PostMessageController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            // TODO: Check authenticated user
            // TODO: Add image uploading
            $redirect_route = '/';

            if (isset($_POST['message']) && strlen($_POST['message']) > 0 && strlen($_POST['message']) <= 50) {
                $messageDB = new MessagesDB();

                // Filter the message to prevent XSS
                $filtered_message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

                try {
                    if (is_numeric($_POST['messageId'])) {
                        $messageDB->edit_message(intval($_POST['messageId']), $filtered_message);
                    } else {
                        $messageDB->add_message($filtered_message, null);
                    }
                } catch (Exception $e) {
                    // There was an error while trying to add/edit the message
                    $redirect_route = '/home?err=2';
                    http_response_code(401);
                }
            } else {
                // One of the parameter was malformed
                $redirect_route = '/home?err=1';
                http_response_code(401);
            }

            header('Location: ' . $redirect_route);
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