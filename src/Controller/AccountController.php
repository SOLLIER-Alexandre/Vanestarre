<?php

    namespace Vanestarre\Controller;

    use Vanestarre\Exception\DatabaseConnectionException;
    use Vanestarre\Model\AuthDB;
    use Vanestarre\Model\User;
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
         * @var User|null Currently connected user
         */
        private $connected_user;

        /**
         * AccountController constructor.
         */
        public function __construct() {
            $this->view = new AccountView();

            // Get the currently connected user
            session_start();
            try {
                $auth_db = new AuthDB();
                $this->connected_user = $auth_db->get_logged_in_user();
            } catch (DatabaseConnectionException $e) {
                // Let the connected user be null
                $this->connected_user = null;
            }
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Make sure it's not null
            if (!isset($this->connected_user)) {
                // User is not logged in
                http_response_code(401);
                header('Location: /login');
                return;
            }

            // Set the username and email to the view
            $this->view->set_username($this->connected_user->get_username());
            $this->view->set_email($this->connected_user->get_email());

            if ($this->connected_user->get_id() === 0) {
                // Show a link to the config page if the connected user is the admin
                $this->view->set_is_author(true);
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
            return ['/styles/common_modal.css', '/styles/account.css'];
        }

        /**
         * @inheritDoc
         */
        public function get_scripts(): array {
            return ['/scripts/account.js', 'https://unpkg.com/micromodal/dist/micromodal.min.js'];
        }

        /**
         * @inheritDoc
         */
        public function needs_standard_layout(): bool {
            return isset($this->connected_user);
        }
    }
?>