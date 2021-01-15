<?php
    require_once __DIR__ . '/icontroller.inc.php';

    /**
     * Class PostMessageController
     *
     * Controller for the message posting
     *
     * @author SOLLIER Alexandre
     */
    class PostMessageController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
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