<?php

    namespace Vanestarre\Controller;

    use Vanestarre\Exception\DatabaseConnectionException;
    use Vanestarre\Model\AuthDB;
    use Vanestarre\Model\User;
    use Vanestarre\View\PasswordForgottenView;

    /**
     * Class PasswordForgottenController
     *
     * Controller for getting a new password via mail when the previous one is forgotten
     *
     * @author RADJA Samy
     * @package Vanestarre\Controller
     */
    class PasswordForgottenController implements IController
    {
        /**
         * @var PasswordForgottenView View associated with this controller
         */
        private $view;

        /**
         * @var User|null Currently connected user
         */
        private $connected_user;

        /**
         * PasswordForgottenController constructor.
         */
        public function __construct() {
            $this->view = new PasswordForgottenView();

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
            if (isset($this->connected_user)) {
                // User is already logged in
                http_response_code(401);
                header('Location: /account');
                return;
            }

            // Output the view contents
            $this->view->set_show_confirmation(isset($_GET['confirm']));
            $this->view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Mot de passe oublié';
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
    }
?>