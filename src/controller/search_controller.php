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
        }

        /**
         * @inheritDoc
         */
        public function getTitle() {
            return 'Recherche';
        }
    }

?>