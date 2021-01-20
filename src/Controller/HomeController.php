<?php

    namespace Vanestarre\Controller;

    use Exception;
    use Vanestarre\Model\MessagesDB;
    use Vanestarre\View\HomeView;

    /**
     * Class HomeController
     *
     * Controller for the home page (website index)
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller
     */
    class HomeController implements IController
    {
        /**
         * @var HomeView View associated with this Controller
         */
        private $view;

        /**
         * AccountController constructor.
         */
        public function __construct() {
            $this->view = new HomeView();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Set page data
            // TODO: Get the real page count
            $this->view->set_page_count(5);

            if (is_numeric($_GET['page'])) {
                // We got a page number in the request, check it and set it if it's good
                $page = intval($_GET['page']);
                if ($page >= 1 && $page <= $this->view->get_page_count()) {
                    $this->view->set_current_page($page);
                }
            }

            // Set the error to the view if there is one
            if (is_numeric($_GET['err'])) {
                $this->view->set_error(intval($_GET['err']));
            }

            // Grab the messages from the database
            $messageDB = new MessagesDB();

            try {
                $this->view->set_messages($messageDB->get_n_last_messages(2, 0));
            } catch (Exception $e) {
                $this->view->set_error_fetching_messages(true);
            }

            // Output the View contents
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
            return ['/scripts/home.js', 'https://unpkg.com/micromodal/dist/micromodal.min.js'];
        }

        /**
         * @inheritDoc
         */
        public function needs_standard_layout(): bool {
            return true;
        }
    }

    ?>