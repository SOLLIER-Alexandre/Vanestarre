<?php
    require_once __DIR__ . '/icontroller.inc.php';

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
         * @inheritDoc
         */
        public function execute() {
            require_once __DIR__ . '/../view/account_view.php';

            $view = new AccountView();

            // Output the view contents
            $view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function getTitle(): string {
            return 'Compte';
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