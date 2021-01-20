<?php

    namespace Vanestarre\Controller;

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
            if (is_numeric($_POST['messageId'])) {
                $messagesDB = new MessagesDB();
                $messagesDB->delete_message(intval($_POST['messageId']));
            }

            header('Location: /');
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