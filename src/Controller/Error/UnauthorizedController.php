<?php

    namespace Vanestarre\Controller\Error;

    use Vanestarre\Controller\IController;
    use Vanestarre\View\Error\UnauthorizedView;

    /**
     * Class UnauthorizedController
     *
     * Controller for the HTTP 401 error page
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\Error
     */
    class UnauthorizedController implements IController
    {
        /**
         * @var UnauthorizedView View associated with this controller
         */
        private $view;

        /**
         * UnauthorizedController constructor.
         */
        public function __construct() {
            $this->view = new UnauthorizedView();
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
            return 'Non autorisé';
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