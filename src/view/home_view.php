<?php
    require_once __DIR__ . '/iview.inc.php';

    /**
     * Class HomeView
     *
     * View for the home page (website index)
     */
    class HomeView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo '        <h1>Accueil Vanéstarre</h1>' . PHP_EOL;
        }
    }

?>