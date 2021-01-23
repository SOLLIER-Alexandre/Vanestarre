<?php

    namespace Vanestarre\Controller\Message;

    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseUpdateException;
    use Vanestarre\Model\MessagesDB;

    /**
     * Class RemoveImageController
     *
     * Controller for removing a message image
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\Message
     */
    class MessageRemoveImageController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            session_start();
            if ($_SESSION['current_user'] !== 0) {
                // User is not authorized
                http_response_code(401);
                header('Location: /unauthorized');
                return;
            }

            $redirect_route = '/';

            if (is_numeric($_POST['messageId'])) {
                $message_db = new MessagesDB();

                try {
                    $message_db->remove_message_image(intval($_POST['messageId']));
                } catch (DatabaseUpdateException $e) {
                    // Couldn't remove the image from this message
                    $redirect_route = '/home?err=21';
                    http_response_code(400);
                }
            } else {
                // The parameter was malformed
                $redirect_route = '/home?err=21';
                http_response_code(400);
            }

            header('Location: ' . $redirect_route);
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Remove image';
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