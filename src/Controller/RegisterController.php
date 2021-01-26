<?php

    namespace Vanestarre\Controller;

    use Vanestarre\Model\AuthDB;
    use Vanestarre\Model\User;
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
         * @var User|null Currently connected user
         */
        private $connected_user;

        /**
         * RegisterController constructor.
         */
        public function __construct() {
            $this->view = new RegisterView();

            // Get the currently connected user
            session_start();
            $auth_db = new AuthDB();
            $this->connected_user = $auth_db->get_logged_in_user();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            if (isset($this->connected_user)) {
                // User is already logged in
                http_response_code(401);
                header('Location: /account');
                return;
            }

            // Check for err code in the get parameters
            if (is_numeric($_GET['err'])) {
                $this->view->set_err_id(intval($_GET['err']));
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
            return !isset($this->connected_user);
        }
    }
?>