<?php

    namespace Vanestarre\Controller\Message;

    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseDeleteException;
    use Vanestarre\Model\AuthDB;
    use Vanestarre\Model\MessagesDB;

    /**
     * Class DeleteMessageController
     *
     * Controller for message deleting
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\Message
     */
    class MessageDeleteController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            session_start();
            $auth_db = new AuthDB();
            $connected_user = $auth_db->get_logged_in_user();

            if (!isset($connected_user) || $connected_user->get_id() !== 0) {
                // User is not authorized
                http_response_code(401);
                header('Location: /unauthorized');
                return;
            }

            // Check that we have the message ID in the POSTed parameters
            $redirect_route = '/';

            if (is_numeric($_POST['messageId'])) {
                $messages_db = new MessagesDB();
                try {
                    $messages_db->delete_message(intval($_POST['messageId']));
                } catch (DatabaseDeleteException $e) {
                    // The message couldn't be deleted
                    $redirect_route = '/home?err=11';
                    http_response_code(400);
                }
            } else {
                // The message ID was null/malformed
                $redirect_route = '/home?err=10';
                http_response_code(400);
            }

            header('Location: ' . $redirect_route);
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Delete message';
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