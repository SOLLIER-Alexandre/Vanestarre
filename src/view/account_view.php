<?php
    require_once __DIR__ . '/iview.inc.php';

    /**
     * Class AccountView
     *
     * View for the account management page
     *
     * @author CHATEAUX Adrien
     */
    class AccountView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo '        <h1>Compte Vanéstarre</h1>' . PHP_EOL;
        }
    }

?>