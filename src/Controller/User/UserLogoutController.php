<?php

    namespace Vanestarre\Controller\User;

    use Vanestarre\Controller\IController;

    /**
     * Class UserLogoutController
     *
     * Controller for logging out the user
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\User
     */
    class UserLogoutController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            // Unset the current user in the session
            session_start();
            unset($_SESSION['current_user']);

            header('Location: /');
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Logout';
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
            return false;
        }
    }

    ?>