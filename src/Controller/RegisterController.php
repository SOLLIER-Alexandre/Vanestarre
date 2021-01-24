<?php

    namespace Vanestarre\Controller;

    use Vanestarre\View\RegisterView;

    /**
     * Class RegisterController
     *
     * Controller for the register page
     *
     * @author RADJA Samy
     * @package Vanestarre\Controller
     */
    class RegisterController implements IController
    {
        /**
         * @var RegisterView View associated with this Controller
         */
        private $view;

        /**
         * RegisterController constructor.
         */
        public function __construct() {
            $this->view = new RegisterView();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            if (isset($_SESSION['current_user'])) {
                // User is already logged in
                http_response_code(401);
                header('Location: /account');
                return;
            }

            // Output the View contents
            // TODO: Handle errors
            $this->view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Create account';
        }

        /**
         * @inheritDoc
         */
        public function get_stylesheets(): array {
            return ['/styles/register.css'];
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
            session_start();
            return !isset($_SESSION['current_user']);
        }
    }
?>