<?php
    require_once __DIR__ . '/icontroller.inc.php';

    /**
     * Class HomeController
     *
     * Controller for the home page (website index)
     *
     * @author SOLLIER Alexandre
     */
    class HomeController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            require_once __DIR__ . '/../view/home_view.php';

            $view = new HomeView();

            // Output the view contents
            $view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Accueil';
        }

        /**
         * @inheritDoc
         */
        public function get_stylesheets(): array {
            return ['/styles/home.css'];
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