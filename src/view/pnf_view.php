<?php
    require __DIR__ . '/iview.inc.php';

    /**
     * Class PNFView
     *
     * View for the HTTP 404 error page
     *
     * @author SOLLIER Alexandre
     */
    class PNFView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<HTML
                    <h1>Erreur 404</h1>
                    <p>Vous avez essayé d'accéder a une page non existante de Vanéstarre, le meilleur site internet des interwebs.</p>
                    <p>For science. You monster.</p>

            HTML;
        }
    }

?>