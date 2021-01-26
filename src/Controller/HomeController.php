<?php

    namespace Vanestarre\Controller;

    use Vanestarre\Exception\DatabaseSelectException;
    use Vanestarre\Model\AuthDB;
    use Vanestarre\Model\Message;
    use Vanestarre\Model\MessagesDB;
    use Vanestarre\Model\SearchDB;
    use Vanestarre\Model\User;
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
         * @var User|null Currently connected user
         */
        private $connected_user;

        /**
         * AccountController constructor.
         */
        public function __construct() {
            $this->view = new HomeView();

            // Get the currently connected user
            session_start();
            $auth_db = new AuthDB();
            $this->connected_user = $auth_db->get_logged_in_user();
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            // Check if the user is an author
            if (isset($this->connected_user)) {
                $this->view->set_is_connected(true);
                $this->view->set_has_authoring_tools($this->connected_user->get_id() === 0);
            }

            if (isset($_GET['query'])) {
                // User is searching for something
                $this->show_search_results();
            } else {
                // Show the feed
                $this->show_last_messages();
            }

            // Output the View contents
            $this->view->echo_contents();
        }

        /**
         * Sets the error ID (from $_GET['err']) to the view
         */
        private function set_error_to_view(): void {
            if (is_numeric($_GET['err'])) {
                $this->view->set_error(intval($_GET['err']));
            }
        }

        /**
         * Sets page count and current page number to the view
         * @param int $message_count Total number of messages there is
         * @param int $msg_per_page Returned number of messages per page
         * @param int $message_offset Returned offset for the message query
         */
        private function set_page_to_view(int $message_count, int &$msg_per_page, int &$message_offset): void {
            // Get the number of messages per page
            $config = new VanestarreConfig();
            $msg_per_page = $config->get_nbr_messages_par_page();

            // Set the page count
            $this->view->set_page_count(intval(ceil($message_count / $msg_per_page)));

            if (is_numeric($_GET['page'])) {
                // Set the current page number
                $page = intval($_GET['page']);

                if ($page >= 1 && $page <= $this->view->get_page_count()) {
                    $this->view->set_current_page($page);
                }
            }

            // Compute the offset
            $message_offset = $msg_per_page * ($this->view->get_current_page() - 1);
        }

        /**
         * Sets the messages to the view, and the reactions from the currently connected user if there is one
         * @param MessagesDB $message_db Database to get reactions from
         * @param array $messages Array of messages to feed to the view
         * @throws DatabaseSelectException
         */
        private function set_messages_to_view(MessagesDB $message_db, array $messages): void {
            // Set messages to the view
            $this->view->set_messages($messages);

            if (isset($this->connected_user)) {
                // There is a connected user, get its reactions
                $message_ids = array_map(function (Message $item) {
                    return $item->get_id();
                }, $messages);

                $this->view->set_user_reactions($message_db->get_reactions($this->connected_user->get_id(), $message_ids));
            }
        }

        /**
         * Shows the n last messages to the user
         */
        private function show_last_messages(): void {
            // Grab the messages from the database
            $message_db = new MessagesDB();

            $total_message_count = 0;
            $messages_to_fetch = 0;
            $message_offset = 0;

            // Set page data
            try {
                $total_message_count = $message_db->count_messages();
            } catch (DatabaseSelectException $e) {
                // Don't do anything, let the message count at 0
            }
            $this->set_page_to_view($total_message_count, $messages_to_fetch, $message_offset);

            // Set the error to the view if there is one
            $this->set_error_to_view();

            // Try to set the messages to the view
            try {
                $messages = $message_db->get_n_last_messages($messages_to_fetch, $message_offset);
                $this->set_messages_to_view($message_db, $messages);
            } catch (DatabaseSelectException $e) {
                // If there was an error, we'll show it to the user
                $this->view->set_error_fetching_messages(true);
            }
        }

        /**
         * Shows search results to the user
         */
        private function show_search_results(): void {
            // Grab the search results from the database
            $message_db = new MessagesDB();
            $search_db = new SearchDB();

            // Set the search query to the view
            $this->view->set_search_query($_GET['query']);

            $total_message_count = 0;
            $messages_to_fetch = 0;
            $message_offset = 0;

            // Set page data
            try {
                $total_message_count = $search_db->count_messages_with_tag($_GET['query']);
            } catch (DatabaseSelectException $e) {
                // Don't do anything, let the message count at 0
            }
            $this->set_page_to_view($total_message_count, $messages_to_fetch, $message_offset);

            // Set the error to the view if there is one
            $this->set_error_to_view();

            // Try to set the messages to the view
            try {
                $messages = $search_db->get_messages_from_search($_GET['query'], $messages_to_fetch, $message_offset);
                $this->set_messages_to_view($message_db, $messages);
            } catch (DatabaseSelectException $e) {
                // If there was an error, we'll show it to the user
                $this->view->set_error_fetching_messages(true);
            }
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