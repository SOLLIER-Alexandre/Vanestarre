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
        public function getTitle() {
            return 'Accueil';
        }
    }

?>