<?php

    namespace Vanestarre\Controller\User;

    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseUpdateException;
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

            $redirect_route = '/account?status=2';

            // Grab posted values
            $username = $_POST['username'];
            $email = $_POST['email'];

            // Check posted values
            if (isset($username) && isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL) &&
                mb_strlen($username) <= 64 && mb_strlen($email) <= 64) {
                $auth_db = new AuthDB();

                // Check if the target is not the connected user (only for an author)
                $target_user_id = $connected_user->get_id();
                if ($connected_user->get_id() === 0 && is_numeric($_POST['userId'])) {
                    // Change details for another user than the connected one
                    $target_user_id = intval($_POST['userId']);
                    $redirect_route = '/config';
                }

                try {
                    $auth_db->change_username_and_email($target_user_id, $username, $email);
                } catch (DatabaseUpdateException $exception) {
                    // Couldn't change user details
                    $redirect_route = '/account?status=21';
                    http_response_code(400);
                }
            } else {
                // One of the parameter was malformed
                $redirect_route = '/account?status=20';
                http_response_code(400);
            }

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