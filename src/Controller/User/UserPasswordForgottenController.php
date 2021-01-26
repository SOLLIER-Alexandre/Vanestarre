<?php
    namespace Vanestarre\Controller\User;

    use Vanestarre\Controller\IController;
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
            $auth_db = new AuthDB();
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
            $auth_DB = new AuthDB();

            try {
                $id = $auth_DB->get_id_from_email($email);
            } catch (DatabaseSelectException $exception) {
                // Couldn't get the id
                http_response_code(400);
            }

            //create a temporary password
            $temporary_password = $this->create_password();
            $hashed_password = password_hash($temporary_password, PASSWORD_DEFAULT);

            if (isset($id)) {
                try {
                    $auth_DB->change_password($id, $hashed_password);
                    mail($email,
                        'Password forgotten',
                        'Heeeeey dude ! Looks like you messed up with that tiny memory of yours huh ?' . PHP_EOL .
                        'Here you go, a new password : ' . $temporary_password);
                } catch (DatabaseUpdateException $exception2) {
                    // Couldn't change the password
                    http_response_code(400);
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
            static $baseAlphaMaj = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            static $baseAlphaMin = "abcdefghijklmnopqrstuvwxyz";
            static $baseNumber = "0123456789";
            static $baseSpecial = "%#:$*";

            $password = "";
            $lenghtPassword = rand(8,12);
            for ($i = 0; $i < $lenghtPassword; $i++) {
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