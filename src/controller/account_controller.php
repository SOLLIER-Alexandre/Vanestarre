<?php
    require_once __DIR__ . '/icontroller.inc.php';
    require_once __DIR__ . '/../view/account_view.php';

    /**
     * Class AccountController
     *
     * Controller for the account management page
     *
     * @author CHATEAUX Adrien
     */
    class AccountController implements IController
    {
        /**
         * @var AccountView View associated with this controller
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
            // Output the view contents
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