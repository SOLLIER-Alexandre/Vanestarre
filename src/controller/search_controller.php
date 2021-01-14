<?php
    require_once __DIR__ . '/icontroller.inc.php';

    /**
     * Class SearchController
     *
     * Controller for the search page
     *
     * @author DEUDON Eugénie
     */
    class SearchController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            require_once __DIR__ . '/../view/search_view.php';

            $view = new SearchView();

            // Output the view contents
            $view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Recherche';
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