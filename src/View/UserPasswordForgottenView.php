<?php
    namespace Vanestarre\View;

    /**
     * Class UserPasswordForgottenView
     *
     * Controller for the confirmation of the password sent to reset the previous forgotten one
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