<?php
    require __DIR__ . '/IView.php';
    require __DIR__ . '/../model/Message.php';

    /**
     * Class HomeView
     *
     * View for the home page (website index)
     *
     * @author SOLLIER Alexandre
     */
    class HomeView implements IView
    {
        /**
         * @var int $current_page The current page number
         */
        private $current_page;

        /**
         * @var int $page_count The number of pages to show
         */
        private $page_count;

        /**
         * @var array $messages Array of messages this view has
         */
        private $messages;

        /**
         * HomeView constructor.
         */
        public function __construct() {
            $this->current_page = 1;
            $this->page_count = 1;
            $this->messages = array();
        }

        /**
         * @inheritDoc
         */
        public function echo_contents() {
            // TODO: Only echo this when the connected account is Vanéstarre
            $this->echo_message_writer();

            // Echo every message
            foreach ($this->messages as $message) {
                $this->echo_message($message);
            }

            // Echo page selector
            $this->echo_pager();
        }

        /**
         * Outputs the form for writing a message
         */
        private function echo_message_writer() {
            echo <<<'HTML'
                    <div class="card">
                        <form id="send-message-form" action="/postMessage" method="post">
                            <textarea id="send-message-text" placeholder="Postez un message" name="message"></textarea>
                            <div id="send-message-buttons">
                                <div></div>
                                <div>
                                    <span id="message-length-counter">50</span>
                                    <input id="send-message-button" type="submit" value="Post">
                                </div>
                            </div>
                        </form>
                    </div>

            HTML;
        }

        /**
         * Outputs a single message to the page
         * @param Message $message Message to output
         */
        private function echo_message(Message $message) {
            // Begin the message card
            echo '        <article class="card">' . PHP_EOL;

            // Output message date and content
            echo '            <p class="post-title">Vanéstarre • Posté le ' . $message->get_creation_date() . '</p>' . PHP_EOL;
            echo '            <p class="post-message">' . $message->get_message() . '</p>' . PHP_EOL;

            // Output the image if there is one
            if (!is_null($message->get_image())) {
                echo '            <img src="' . $message->get_image() . '" alt="Image du post de Vanéstarre">' . PHP_EOL;
            }

            // End the message card
            echo '        </article>' . PHP_EOL;
        }

        /**
         * Outputs the page selector
         */
        private function echo_pager() {
            // Begin the pager
            echo '        <div id="pager">' . PHP_EOL;

            // Output every page number
            for ($i = 1; $i <= $this->page_count; ++$i) {
                $this->echo_pager_element($i, $i === $this->current_page);
            }

            // End the pager
            echo '        </div>' . PHP_EOL;
        }

        /**
         * Outputs a single element from the page selector
         * @param int $page_number Page number to show
         * @param bool $is_selected Is this element the current one?
         */
        private function echo_pager_element(int $page_number, bool $is_selected) {
            $classList = 'text-button';
            if ($is_selected) {
                $classList .= ' selected';
            }

            echo '            <a class="' . $classList . '" href="/home?page=' . $page_number . '">' . $page_number . '</a>' . PHP_EOL;
        }

        /**
         * @return int The page count
         */
        public function get_page_count(): int {
            return $this->page_count;
        }

        /**
         * @param int $page_count New page count
         */
        public function set_page_count(int $page_count): void {
            $this->page_count = $page_count;
        }

        /**
         * @return int The current page number
         */
        public function get_current_page(): int {
            return $this->current_page;
        }

        /**
         * @param int $current_page New current page number
         */
        public function set_current_page(int $current_page): void {
            $this->current_page = $current_page;
        }

        /**
         * Adds a new message to the message list
         * @param Message $message Message to add
         */
        public function add_message(Message $message): void {
            array_push($this->messages, $message);
        }
    }

?>