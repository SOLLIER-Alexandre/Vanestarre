<?php
    namespace Vanestarre\Controller\User;

    use Vanestarre\Controller\IController;
    use Vanestarre\View\UserPasswordForgottenView;

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
         * @var UserPasswordForgottenView View associated with this controller
         */
        private $view;

        /**
         * UserPasswordForgottenController constructor.
         */
        public function __construct() {
            $this->view = new UserPasswordForgottenView();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Output the view contents
            $email = $_POST['mail'];
            $temporary_password = $this->create_password();
            mail($email,
                "Password forgotten",
                "Heeeeey dude ! Looks like you messed up with that tiny memory of yours huh ? Here you go, a new password : $temporary_password",
                "Reset your password");
            $this->view->echo_contents();
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
            return ['/styles/password_forgotten.css'];
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
            return true;
        }

        public function create_password(): string {
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
    }
?>