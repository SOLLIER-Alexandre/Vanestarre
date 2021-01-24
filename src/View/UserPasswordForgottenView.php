<?php
    namespace Vanestarre\View;

    /**
     * Class UserPasswordForgottenView
     *
     * View for for getting a new password via mail when the previous one is forgotten
     *
     * @author RADJA Samy
     * @package Vanestarre\View
     */
    class UserPasswordForgottenView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo '        <h1>Template Vanéstarre</h1>' . PHP_EOL;
        }
    }
?>