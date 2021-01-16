<?php
    namespace Vanestarre\View;

    /**
     * Class SearchView
     *
     * View for the search page
     *
     * @author DEUDON Eugénie
     * @package Vanestarre\View
     */
    class SearchView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo '        <h1>Recherche Vanéstarre — ' . filter_input(INPUT_GET, 'query', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . '</h1>' . PHP_EOL;
        }
    }

?>