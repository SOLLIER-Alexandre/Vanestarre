<?php
    require_once __DIR__ . '/icontroller.inc.php';
    require_once __DIR__ . '/../view/home_view.php';

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
         * @var HomeView View associated with this controller
         */
        private $view;

        /**
         * AccountController constructor.
         */
        public function __construct() {
            $this->view = new HomeView(0);
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Add the messages to the view
            $this->view->add_message(new Message('eske vou konéssé twitch prim xDDDDDDDD', 10, 'https://materializecss.com/images/sample-1.jpg'));
            $this->view->add_message(new Message('yo lé besta g lancé le rézo cmt ça va xoxoxo', 0));

            // Output the view contents
            $this->view->echo_contents();
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
            return ['/scripts/home.js'];
        }

        /**
         * @inheritDoc
         */
        public function needs_standard_layout(): bool {
            return true;
        }
    }

?>