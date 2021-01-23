<?php

    namespace Vanestarre\View;

    /**
     * Class UnauthorizedView
     *
     * View for the HTTP 401 error page
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\View
     */
    class UnauthorizedView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<HTML
                    <h2>Erreur 401 - Non autorisé</h2>
                    <p>Vous avez essayé d'accéder a une page dont vous n'avez pas accès sur Vanéstarre.</p>
                    <p>So Nvidia, Fuck you!</p>

            HTML;
        }
    }

    ?>