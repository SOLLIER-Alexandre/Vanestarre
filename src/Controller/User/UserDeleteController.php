<?php

    namespace Vanestarre\Controller\User;

    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseDeleteException;
    use Vanestarre\Model\AuthDB;

    /**
     * Class UserDeleteController
     *
     * Controller for deleting the connected user
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\User
     */
    class UserDeleteController implements IController
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

            $redirect_route = '/';

            try {
                // Try to delete and disconnect the current user
                $auth_db->delete_user($connected_user->get_id());
                unset($_SESSION['current_user']);
            } catch (DatabaseDeleteException $e) {
                // Couldn't delete the user
                $redirect_route = '/account?status=30';
                http_response_code(400);
            }

            header('Location: ' . $redirect_route);
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Delete user';
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