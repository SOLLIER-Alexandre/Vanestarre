<?php

    namespace Vanestarre\User\Controller;

    use Vanestarre\Controller\IController;

    /**
     * Class UserPasswordForgottenController
     *
     * Controller for getting a new password via mail when the previous one is forgotten
     *
     * @author RADJA Samy
     * @package Vanestarre\Controller\User
     */
    class UserPasswordForgottenController implements IController
    {
        /**
         * @var UserPasswordForgottenView View associated with this controller
         */
        private $view;

        /**
         * TemplateController constructor.
         */
        public function __construct() {
            $this->view = new UserPasswordForgottenView();
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
            return 'Template';
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