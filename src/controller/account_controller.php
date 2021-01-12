<?php
    require_once __DIR__ . '/icontroller.inc.php';

    /**
     * Class AccountController
     *
     * Controller for the account management page
     */
    class AccountController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            require_once __DIR__ . '/../view/account_view.php';
        }

        /**
         * @inheritDoc
         */
        public function getTitle() {
            return 'Compte';
        }
    }

?>