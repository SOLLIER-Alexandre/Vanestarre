<?php
    namespace Vanestarre\Controller;

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
            // TODO: Add possibility to modify message using the MessagesDB model
            // TODO: Check authenticated user
            // TODO: Add image uploading
            if (isset($_POST['message']) && strlen($_POST['message']) > 0 && strlen($_POST['message']) <= 50) {
                $messageDB = new MessagesDB();
                $filtered_message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $messageDB->add_message($filtered_message, null);
            } else {
                // One of the parameter was malformed
                // TODO: Show error message
                http_response_code(401);
            }

            header('Location: /');
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