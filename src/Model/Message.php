<?php

    namespace Vanestarre\Model;

    use DateTimeImmutable;

    /**
     * Class Message
     *
     * Holds properties of a message
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Model
     */
    class Message
    {
        /**
         * @var int $id Message ID
         */
        private $id;

        /**
         * @var string $message Message contents
         */
        private $message;

        /**
         * @var DateTimeImmutable $creation_date Timestamp of the creation of the message
         */
        private $creation_date;

        /**
         * @var MessageReactions $reactions Reactions this message has
         */
        private $reactions;

        /**
         * @var string|null $image URL to an image, if any
         */
        private $image;

        /**
         * Constructs a new message
         * @param int $id Message ID
         * @param string $message Message contents
         * @param DateTimeImmutable $creation_date Timestamp of the creation of the message
         * @param MessageReactions $reactions Reactions this message has
         * @param string|null $image URL to an image, if any
         */
        public function __construct(int $id, string $message, DateTimeImmutable $creation_date, MessageReactions $reactions, ?string $image = null) {
            $this->id = $id;
            $this->message = $message;
            $this->creation_date = $creation_date;
            $this->reactions = $reactions;
            $this->image = $image;
        }

        /**
         * @return int The message ID
         */
        public function get_id(): int {
            return $this->id;
        }

        /**
         * @return string The message contents
         */
        public function get_message(): string {
            return $this->message;
        }

        /**
         * @return DateTimeImmutable The creation date
         */
        public function get_creation_date(): DateTimeImmutable {
            return $this->creation_date;
        }

        /**
         * @return MessageReactions The reactions
         */
        public function get_reactions(): MessageReactions {
            return $this->reactions;
        }

        /**
         * @return string|null The image URL
         */
        public function get_image(): ?string {
            return $this->image;
        }
    }

    ?>