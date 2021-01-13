<?php
    require_once __DIR__ . '/iview.inc.php';

    /**
     * Class LoginView
     *
     * View for the login page
     *
     * @author RADJA Samy
     */
    class LoginView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo '        <h1>Template Vanéstarre</h1>' . PHP_EOL;
        }
    }
?>