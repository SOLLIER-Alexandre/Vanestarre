<?php

    namespace Vanestarre\Controller\Message\Reaction;

    use Vanestarre\Controller\IController;
    use Vanestarre\Model\AuthDB;

    /**
     * Class MessageReactionSetController
     *
     * Controller for adding a user reaction to a message
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\Message\Reaction
     */
    class MessageReactionSetController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            // Grab the currently connected user
            session_start();
            $auth_db = new AuthDB();
            $connected_user = $auth_db->get_logged_in_user();

            // Make sure it's not null
            if (!isset($connected_user)) {
                // User is not logged in
                http_response_code(401);
                return;
            }
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Remove a reaction';
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