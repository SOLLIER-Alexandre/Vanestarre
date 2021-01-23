<?php

    namespace Vanestarre\Controller;

    use Vanestarre\View\AccountView;

    /**
     * Class AccountController
     *
     * Controller for the account management page
     *
     * @author CHATEAUX Adrien
     * @package Vanestarre\Controller
     */
    class AccountController implements IController
    {
        /**
         * @var AccountView View associated with this Controller
         */
        private $view;

        /**
         * AccountController constructor.
         */
        public function __construct() {
            $this->view = new AccountView("Username", "User@hotmail.com");
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            if (!isset($_SESSION['current_user'])) {
                // User is not logged in
                http_response_code(401);
                header('Location: /login');
                return;
            }

            // Output the View contents
            $this->view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Compte';
        }

        /**
         * @inheritDoc
         */
        public function get_stylesheets(): array {
            return ['/styles/account.css'];
        }

        /**
         * @inheritDoc
         */
        public function get_scripts(): array {
            return ['/scripts/account.js'];
        }

        /**
         * @inheritDoc
         */
        public function needs_standard_layout(): bool {
            session_start();
            return isset($_SESSION['current_user']);
        }
    }
?>