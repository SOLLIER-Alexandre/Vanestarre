<?php

    namespace Vanestarre\Controller\User;

    use Vanestarre\Controller\IController;
    use Vanestarre\Model\AuthDB;

    /**
     * Class UserDetailsUpdateController
     *
     * Controller for changing the connected user details
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\User
     */
    class UserDetailsUpdateController implements IController
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
                header('Location: /');
                return;
            }

            $redirect_route = '/account?confirm=';

            // TODO: Do this

            header('Location: ' . $redirect_route);
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Change password';
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