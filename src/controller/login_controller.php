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
        public function getTitle(): string {
            return 'Login';
        }

        /**
         * @inheritDoc
         */
        public function getStylesheets(): array {
            return [];
        }

        /**
         * @inheritDoc
         */
        public function getScripts(): array {
            return [];
        }
    }

?>