<?php
    namespace Vanestarre\Controller\User;

    use Exception;
    use Vanestarre\Controller\IController;
    use Vanestarre\Model\AuthDB;

    /**
     * Class UserRegisterController
     *
     * Controller for the treatment of user data
     *
     * @author RADJA Samy
     * @package Vanestarre\Controller\User
     */

    class UserRegisterController implements IController
    {

        /**
         * RegisterController constructor.
         */
        public function __construct() {
        }

        /**
         * @inheritDoc
         * @throws Exception
         */
        public function execute() {
            session_start();
            if (isset($_SESSION['current_user'])) {
                // User is already logged in
                http_response_code(401);
                header('Location: /account');
                return;
            }

            $redirect_route = '/';

            // Grab posted values
            $username = $_POST['username'];
            $password = $_POST['mdp'];
            $email = $_POST['email'];

            // Check posted values
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($username) <= 64 && strlen($password) <= 128 && strlen($email) <= 64) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $auth_db = new AuthDB();

                try {
                    $user_id = $auth_db->add_user($username, $email, $hashed_password);
                    $_SESSION["current_user"] = $user_id;
                } catch (Exception $exception) {
                    // Couldn't register the user
                    $redirect_route = '/register?err=2';
                    http_response_code(400);
                }
            } else {
                // One of the parameter was malformed
                $redirect_route = '/register?err=1';
                http_response_code(400);
            }

            header('Location: ' . $redirect_route);
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