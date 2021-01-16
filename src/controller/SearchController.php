<?php
    require __DIR__ . '/IController.php';
    require __DIR__ . '/../view/SearchView.php';

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
         * @var SearchView View associated with this controller
         */
        private $view;

        /**
         * AccountController constructor.
         */
        public function __construct() {
            $this->view = new SearchView();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Output the view contents
            $this->view->echo_contents();
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