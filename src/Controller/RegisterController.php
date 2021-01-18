<?php
    namespace Vanestarre\Controller;

    /**
     * Class RegisterController
     *
     * Controller for the treatment of user data
     *
     * @author RADJA Samy
     * @package Vanestarre\Controller
     */

    class RegisterController implements IController
    {

        /**
         * RegisterController constructor.
         */
        public function __construct() {
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            $password = $_POST['mdp'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $algo = PASSWORD_DEFAULT;

            if (filter_var($email, FILTER_VALIDATE_EMAIL) and (strlen($password)<=20) and (strlen($username)<=15)) {
                password_hash($password, $algo);
                header('Location: /');
            }

            else {
                header('Location: /login');
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