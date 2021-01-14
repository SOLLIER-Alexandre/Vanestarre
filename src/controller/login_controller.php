<?php
    require_once __DIR__ . '/icontroller.inc.php';

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
         * @inheritDoc
         */
        public function execute() {
            require_once __DIR__ . '/../view/login_view.php';

            $view = new LoginView();

            // Output the view contents
            $view->echo_contents();
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
    }

?>