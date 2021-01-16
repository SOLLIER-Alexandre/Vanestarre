<?php
    require_once __DIR__ . '/iview.inc.php';
    require_once __DIR__ . '/../model/message.php';

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
         * @param int $current_page The current page number
         * @param int $page_count The number of pages to show
         */
        public function __construct(int $current_page, int $page_count) {
            $this->current_page = $current_page;
            $this->page_count = $page_count;
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

            // Output every page number from 1 to the current page
            for ($i = 1; $i < $this->current_page; ++$i) {
                echo '<span class="text-button">' . $i . '</span>' . PHP_EOL;
            }

            // Output the current page with a special class
            echo '<span class="text-button selected">' . $i . '</span>' . PHP_EOL;
            ++$i;

            // Output the rest of the pages
            for (; $i <= $this->page_count; ++$i) {
                echo '<span class="text-button">' . $i . '</span>' . PHP_EOL;
            }

            // End the pager
            echo '        </div>' . PHP_EOL;
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
         * Adds a new message to the message list
         * @param Message $message Message to add
         */
        public function add_message(Message $message): void {
            array_push($this->messages, $message);
        }
    }

?>