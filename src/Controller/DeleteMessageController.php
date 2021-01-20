<?php

    namespace Vanestarre\Controller;

    use Exception;
    use Vanestarre\Model\MessagesDB;

    /**
     * Class DeleteMessageController
     *
     * Controller for message deleting
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller
     */
    class DeleteMessageController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            // Check that we have the message ID in the POSTed parameters
            // TODO: Check authenticated user
            $redirect_route = '/';

            if (is_numeric($_POST['messageId'])) {
                $messagesDB = new MessagesDB();
                try {
                    $messagesDB->delete_message(intval($_POST['messageId']));
                } catch (Exception $e) {
                    // The message couldn't be deleted
                    $redirect_route = '/home?err=11';
                    http_response_code(401);
                }
            } else {
                // The message ID was null/malformed
                $redirect_route = '/home?err=10';
                http_response_code(401);
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