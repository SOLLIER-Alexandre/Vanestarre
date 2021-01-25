<?php

    namespace Vanestarre\Controller;

    use Vanestarre\Model\AuthDB;
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
            $this->view = new AccountView();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Grab the currently connected user
            $auth_db = new AuthDB();
            $connected_user = $auth_db->get_logged_in_user();

            // Make sure it's not null
            if (!isset($connected_user)) {
                // User is not logged in
                http_response_code(401);
                header('Location: /login');
                return;
            }

            // Set the username and email to the view
            $this->view->set_username($connected_user->get_username());
            $this->view->set_email($connected_user->get_email());

            if ($connected_user->get_id() === 0) {
                // Show a link to the config page if the connected user is the admin
                $this->view->set_show_config_link(true);
            }

            // Check for status code in the get parameters
            if (is_numeric($_GET['status'])) {
                $this->view->set_status_id(intval($_GET['status']));
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
            return [];
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