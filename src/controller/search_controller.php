<?php
    require_once __DIR__ . '/icontroller.inc.php';

    /**
     * Class SearchController
     *
     * Controller for the search page
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
        public function getTitle() {
            return 'Recherche';
        }
    }

?>