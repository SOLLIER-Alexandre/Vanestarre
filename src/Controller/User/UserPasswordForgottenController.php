<?php
    namespace Vanestarre\Controller\User;

    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseConnectionException;
    use Vanestarre\Exception\DatabaseSelectException;
    use Vanestarre\Exception\DatabaseUpdateException;
    use Vanestarre\Model\AuthDB;

    /**
     * Class UserPasswordForgottenController
     *
     * Controller for the confirmation of the password sent to reset the previous forgotten one
     *
     * @author RADJA Samy
     * @package Vanestarre\Controller
     */
    class UserPasswordForgottenController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            session_start();
            try {
                $auth_db = new AuthDB();
            } catch (DatabaseConnectionException $e) {
                // Authentication is down, we'll redirect the user to /passwordForgotten
                header('Location: /passwordForgotten?confirm=');
                return;
            }

            $connected_user = $auth_db->get_logged_in_user();
            if (isset($connected_user)) {
                // User is already logged in
                http_response_code(401);
                header('Location: /account');
                return;
            }

            // Output the view contents
            $id = NULL;
            $email = $_POST['mail'];

            try {
                $id = $auth_db->get_id_from_email($email);
            } catch (DatabaseSelectException $exception) {
                // Couldn't get the id
            }

            //create a temporary password
            $temporary_password = $this->create_password();
            $hashed_password = password_hash($temporary_password, PASSWORD_DEFAULT);

            if (isset($id)) {
                try {
                    $auth_db->change_password($id, $hashed_password);
                    mail($email,
                        'Password forgotten',
                        'Forgot your password ? No problem ! We are giving you a new one. Right after you log in, go to your account page and change your password immediatly.' . PHP_EOL .
                        'Here is your temporary password : ' . $temporary_password);
                } catch (DatabaseUpdateException $exception2) {
                    // Couldn't change the password
                }
            }

            header('Location: /passwordForgotten?confirm=');
        }

        /**
         * Function to create a random password
         *
         * @return string The clear random password
         */
        private function create_password(): string {
            static $baseAlphaMaj = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            static $baseAlphaMin = 'abcdefghijklmnopqrstuvwxyz';
            static $baseNumber = '0123456789';
            static $baseSpecial = '%#:$*';

            $password = '';
            $passwordLength = rand(8, 12);

            for ($i = 0; $i < $passwordLength; $i++) {
                switch (rand(1, 4)) {
                    case 1 :
                        $password .= $baseAlphaMaj[rand(0, strlen($baseAlphaMaj))];
                        break;
                    case 2 :
                        $password .= $baseAlphaMin[rand(0, strlen($baseAlphaMin))];
                        break;
                    case 3 :
                        $password .= $baseNumber[rand(0, strlen($baseNumber))];
                        break;
                    case 4 :
                        $password .= $baseSpecial[rand(0, strlen($baseSpecial))];
                        break;
                }
            }
            return $password;
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Mail sent!';
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