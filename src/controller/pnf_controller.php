<?php
    require_once __DIR__ . '/icontroller.inc.php';

    /**
     * Class PNFController
     *
     * Controller for the HTTP 404 error page
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
        }

        /**
         * @inheritDoc
         */
        public function getTitle() {
            return 'Erreur 404';
        }
    }

?>