<?php

    namespace Vanestarre\Model;

    /**
     * Class Message
     *
     * Holds properties of a message
     *
     * @author SOLLIER Alexandre
     */
    class Message
    {
        /**
         * @var string $message Message contents
         */
        private $message;

        /**
         * @var int $creation_date Timestamp of the creation of the message
         */
        private $creation_date;

        /**
         * @var string|null $image URL to an image, if any
         */
        private $image;

        /**
         * Constructs a new message
         * @param string $message Message contents
         * @param int $creation_date Timestamp of the creation of the message
         * @param string|null $image URL to an image, if any
         */
        public function __construct(string $message, int $creation_date, ?string $image = null) {
            $this->message = $message;
            $this->creation_date = $creation_date;
            $this->image = $image;
        }

        /**
         * @return string The message contents
         */
        public function get_message(): string {
            return $this->message;
        }

        /**
         * @param string $message New message contents
         */
        public function set_message(string $message): void {
            $this->message = $message;
        }

        /**
         * @return int The creation date
         */
        public function get_creation_date(): int {
            return $this->creation_date;
        }

        /**
         * @param int $creation_date New creation date
         */
        public function set_creation_date(int $creation_date): void {
            $this->creation_date = $creation_date;
        }

        /**
         * @return string|null The image URL
         */
        public function get_image(): ?string {
            return $this->image;
        }

        /**
         * @param string|null $image New image URL
         */
        public function set_image(?string $image): void {
            $this->image = $image;
        }
    }

    ?>