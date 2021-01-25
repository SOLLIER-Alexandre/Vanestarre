<?php

    namespace Vanestarre\Controller;

    use Vanestarre\View\PasswordForgottenView;

    /**
     * Class PasswordForgottenController
     *
     * Controller for getting a new password via mail when the previous one is forgotten
     *
     * @author RADJA Samy
     * @package Vanestarre\Controller
     */
    class PasswordForgottenController implements IController
    {
        /**
         * @var PasswordForgottenView View associated with this controller
         */
        private $view;

        /**
         * PasswordForgottenController constructor.
         */
        public function __construct() {
            $this->view = new PasswordForgottenView();
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
            return 'password forgotten';
        }

        /**
         * @inheritDoc
         */
        public function get_stylesheets(): array {
            return ['/styles/password_forgotten.css'];
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