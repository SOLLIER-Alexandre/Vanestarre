<?php
    require __DIR__ . '/IController.php';
    require __DIR__ . '/../view/PNFView.php';

    /**
     * Class PNFController
     *
     * Controller for the HTTP 404 error page
     *
     * @author SOLLIER Alexandre
     */
    class PNFController implements IController
    {
        /**
         * @var PNFView View associated with this controller
         */
        private $view;

        /**
         * AccountController constructor.
         */
        public function __construct() {
            $this->view = new PNFView();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Set the HTTP response code to 404
            http_response_code(404);

            // Output the view contents
            $this->view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Erreur 404';
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