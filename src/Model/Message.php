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
         * @var int $reactions_for_donations The number of reactions before asking for a donation
         */
        private $reactions_for_donations;

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
         * @param int $reactions_for_donations
         * @param MessageReactions $reactions Reactions this message has
         * @param string|null $image URL to an image, if any
         */
        public function __construct(int $id, string $message, DateTimeImmutable $creation_date, int $reactions_for_donations, MessageReactions $reactions, ?string $image = null) {
            $this->id = $id;
            $this->message = $message;
            $this->creation_date = $creation_date;
            $this->reactions = $reactions;
            $this->image = $image;
            $this->reactions_for_donations = $reactions_for_donations;
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

        /**
         * @return int The number of "love" reactions for requiring a donation
         */
        public function get_reactions_for_donations(): int {
            return $this->reactions_for_donations;
        }
    }

    ?>