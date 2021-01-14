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
         * @var int $page_count The number of pages to show
         */
        private $page_count;

        /**
         * @var array $messages Array of messages this view has
         */
        private $messages;

        /**
         * HomeView constructor.
         * @param int $page_count The number of pages to show
         */
        public function __construct(int $page_count) {
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
        }

        /**
         * Outputs the form for writing a message
         */
        private function echo_message_writer() {
            echo <<<'HTML'
                    <div class="card">
                        <textarea placeholder="Postez un message"></textarea>
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