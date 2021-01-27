<?php

    namespace Vanestarre\Controller\User;

    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseUpdateException;
    use Vanestarre\Model\AuthDB;

    /**
     * Class UserPasswordUpdateController
     *
     * Controller for changing the connected user password
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\User
     */
    class UserPasswordUpdateController implements IController
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

            $redirect_route = '/account?status=1';

            if (mb_strlen($_POST['newPassword']) < 5) {
                // The password is too short
                $redirect_route = '/account?status=14';
            } else if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) &&
                mb_strlen($_POST['oldPassword']) <= 128 && mb_strlen($_POST['newPassword']) <= 128) {
                if ($_POST['newPassword'] === $_POST['newPasswordConfirmation']) {
                    if (password_verify($_POST['oldPassword'], $connected_user->get_password())) {
                        // Hash the new password and set it
                        $hashed_password = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

                        try {
                            $auth_db->change_password($connected_user->get_id(), $hashed_password);
                        } catch (DatabaseUpdateException $e) {
                            // The password couldn't be changed
                            $redirect_route = '/account?status=13';
                            http_response_code(400);
                        }
                    } else {
                        // The actual password verification failed
                        $redirect_route = '/account?status=12';
                        http_response_code(400);
                    }
                } else {
                    // The new password and its confirmation doesn't match
                    $redirect_route = '/account?status=11';
                    http_response_code(400);
                }
            } else {
                // One of the parameter was malformed
                $redirect_route = '/account?status=10';
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