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
        public function getTitle() {
            return 'Erreur 404';
        }
    }

?>