<?php

    namespace Vanestarre\Controller\Message;

    use Exception;
    use Vanestarre\Controller\IController;
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
            // Check that we have the message ID in the POSTed parameters
            // TODO: Check authenticated user
            $redirect_route = '/';

            if (is_numeric($_POST['messageId'])) {
                $messages_db = new MessagesDB();
                try {
                    $messages_db->delete_message(intval($_POST['messageId']));
                } catch (Exception $e) {
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