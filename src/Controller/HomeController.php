<?php

    namespace Vanestarre\Controller;

    use Exception;
    use Vanestarre\Model\MessagesDB;
    use Vanestarre\Model\VanestarreConfig;
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
            // Grab the messages from the database
            $messageDB = new MessagesDB();

            // Grab the number of messages per page
            $config = new VanestarreConfig();
            $msg_per_page = $config->get_nbr_messages_par_page();
            $message_count = 0;

            // Set page data
            try {
                $message_count = $messageDB->count_messages();
            } catch (Exception $e) {
                // Don't do anything, let the message count at 0
            }
            $this->view->set_page_count(intval(ceil($message_count / $msg_per_page)));

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

            // Try to set the messages to the view
            try {
                $message_offset = $msg_per_page * ($this->view->get_current_page() - 1);
                $this->view->set_messages($messageDB->get_n_last_messages($msg_per_page, $message_offset));
            } catch (Exception $e) {
                // If there was an error, we'll show it to the user
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