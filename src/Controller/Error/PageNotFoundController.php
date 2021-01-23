<?php

    namespace Vanestarre\Controller\Error;

    use Vanestarre\Controller\IController;
    use Vanestarre\View\PageNotFoundView;

    /**
     * Class PageNotFoundController
     *
     * Controller for the HTTP 404 error page
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\Error
     */
    class PageNotFoundController implements IController
    {
        /**
         * @var PageNotFoundView View associated with this Controller
         */
        private $view;

        /**
         * AccountController constructor.
         */
        public function __construct() {
            $this->view = new PageNotFoundView();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Set the HTTP response code to 404
            http_response_code(404);

            // Output the View contents
            $this->view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Page non trouvée';
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