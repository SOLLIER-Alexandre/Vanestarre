<?php

    namespace Vanestarre\View\Error;

    use Vanestarre\View\IView;

    /**
     * Class PNFView
     *
     * View for the HTTP 404 error page
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\View\Error
     */
    class PageNotFoundView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<HTML
                    <h2>Erreur 404 - Page non trouvée</h2>
                    <p>Vous avez essayé d'accéder a une page non existante de Vanéstarre, le meilleur site internet des interwebs.</p>
                    <p>For science. You monster.</p>

            HTML;
        }
    }

?>