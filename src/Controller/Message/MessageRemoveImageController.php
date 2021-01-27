<?php

    namespace Vanestarre\Controller\Message;

    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseConnectionException;
    use Vanestarre\Exception\DatabaseUpdateException;
    use Vanestarre\Model\AuthDB;
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

            if (is_numeric($_POST['messageId'])) {
                try {
                    $message_db = new MessagesDB();
                    $message_db->remove_message_image(intval($_POST['messageId']));
                } catch (DatabaseConnectionException | DatabaseUpdateException $e) {
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