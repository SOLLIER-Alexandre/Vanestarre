<?php
    require_once __DIR__ . '/icontroller.inc.php';
    require_once __DIR__ . '/../view/login_view.php';

    /**
     * Class LoginController
     *
     * Controller for the login page
     *
     * @author RADJA Samy
     */
    class LoginController implements IController
    {
        /**
         * @var LoginView View associated with this controller
         */
        private $view;

        /**
         * AccountController constructor.
         */
        public function __construct() {
            $this->view = new LoginView();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Output the view contents
            $this->view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Login';
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
            return true;
        }
    }

?>