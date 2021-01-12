<?php
    require_once __DIR__ . '/icontroller.inc.php';

    /**
     * Class HomeController
     *
     * Controller for the home page (website index)
     */
    class HomeController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            require_once __DIR__ . '/../view/home_view.php';
        }

        /**
         * @inheritDoc
         */
        public function getTitle() {
            return 'Accueil';
        }
    }

?>