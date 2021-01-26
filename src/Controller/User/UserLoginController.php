<?php

    namespace Vanestarre\Controller\User;

    use Exception;
    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseSelectException;
    use Vanestarre\Exception\IncorrectPasswordException;
    use Vanestarre\Exception\UnknownUsernameException;
    use Vanestarre\Model\AuthDB;

    /**
     * Class UserLoginController
     *
     * Controller for the login of the user
     *
     * @author RADJA Samy
     * @package Vanestarre\Controller\User
     */
    class UserLoginController implements IController
    {
        /**
         * @inheritDoc
         * @throws Exception
         */
        public function execute(): void {
            session_start();
            $auth_db = new AuthDB();
            $connected_user = $auth_db->get_logged_in_user();

            if (isset($connected_user)) {
                // User is already logged in
                http_response_code(401);
                header('Location: /account');
                return;
            }

            $redirect_route = '/';

            // Grab posted username and password
            $username = $_POST['username'];
            $password = $_POST['mdp'];

            // Check posted values
            if (isset($username) && isset($password)) {
                try {
                    $this->authenticate_user($username, $password);
                } catch (UnknownUsernameException | IncorrectPasswordException $e) {
                    // Username or password is incorrect
                    $redirect_route = '/login?err=2';
                    http_response_code(400);
                }
            } else {
                // One of the parameter was malformed
                $redirect_route = '/login?err=1';
                http_response_code(400);
            }

            header('Location: ' . $redirect_route);
        }

        /**
         * Logs in a user
         * @param string $username Username to authenticate
         * @param string $password Clear password of the user
         * @throws UnknownUsernameException
         * @throws IncorrectPasswordException
         */
        private function authenticate_user(string $username, string $password): void {
            $login = new AuthDB();

            // Grab user hashed password
            try {
                $user_info = $login->get_user_data_by_username($username);
            } catch (DatabaseSelectException $e) {
                throw new UnknownUsernameException();
            }

            $hashed_password = $user_info->get_password();
            if (password_verify($password, $hashed_password)) {
                // The password is correct, user is authenticated
                $_SESSION["current_user"] = $user_info->get_id();
            } else {
                // Incorrect password
                throw new IncorrectPasswordException();
            }
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return '';
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