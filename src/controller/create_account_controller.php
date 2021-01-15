<?php
    require_once __DIR__ . '/icontroller.inc.php';
    require_once __DIR__ . '/../view/create_account_view.php';

    /**
     * Class CreateAccountController
     *
     * Controller for the create account page
     *
     * @author RADJA Samy
     */
    class CreateAccountController implements IController
    {
        /**
         * @var CreateAccountView View associated with this controller
         */
        private $view;

        /**
         * TemplateController constructor.
         */
        public function __construct() {
            $this->view = new CreateAccountView();
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
            return 'Create account';
        }

        /**
         * @inheritDoc
         */
        public function get_stylesheets(): array {
            return ['/styles/create_account.css'];
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