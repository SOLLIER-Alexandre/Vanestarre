<?php
    require_once __DIR__ . '/icontroller.inc.php';

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
         * @inheritDoc
         */
        public function execute() {
            // Set the HTTP response code to 404
            http_response_code(404);

            require_once __DIR__ . '/../view/pnf_view.php';

            $view = new PNFView();

            // Output the view contents
            $view->echo_contents();
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