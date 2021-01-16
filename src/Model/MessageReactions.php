<?php

    namespace Vanestarre\Model;

    /**
     * Class MessageReactions
     *
     * Reactions of a message
     *
     * @author SOLLIER Alexandre
     */
    class MessageReactions
    {
        /**
         * @var int $love_reaction Count of "love" reaction of a message
         */
        private $love_reaction;

        /**
         * @var int $cute_reaction Count of "cute" reaction of a message
         */
        private $cute_reaction;

        /**
         * @var int $style_reaction Count of "much style" reaction of a message
         */
        private $style_reaction;

        /**
         * @var int $swag_reaction Count of "swag" reaction of a message
         */
        private $swag_reaction;

        /**
         * @var boolean $love_reacted True if the message was reacted with "love", false otherwise
         */
        private $love_reacted;

        /**
         * @var boolean $love_reacted True if the message was reacted with "cute", false otherwise
         */
        private $cute_reacted;

        /**
         * @var boolean $love_reacted True if the message was reacted with "much style", false otherwise
         */
        private $style_reacted;

        /**
         * @var boolean $love_reacted True if the message was reacted with "swag", false otherwise
         */
        private $swag_reacted;

        /**
         * MessageReactions constructor.
         */
        public function __construct() {
            $this->love_reaction = 0;
            $this->cute_reaction = 0;
            $this->style_reaction = 0;
            $this->swag_reaction = 0;

            $this->love_reacted = false;
            $this->cute_reacted = false;
            $this->style_reacted = false;
            $this->swag_reacted = false;
        }

        /**
         * @return int Count of "love" reaction
         */
        public function get_love_reaction(): int {
            return $this->love_reaction;
        }

        /**
         * @param int $love_reaction New count of "love" reaction
         */
        public function set_love_reaction(int $love_reaction): void {
            $this->love_reaction = $love_reaction;
        }

        /**
         * @return int Count of "cute" reaction
         */
        public function get_cute_reaction(): int {
            return $this->cute_reaction;
        }

        /**
         * @param int $cute_reaction New count of "cute" reaction
         */
        public function set_cute_reaction(int $cute_reaction): void {
            $this->cute_reaction = $cute_reaction;
        }

        /**
         * @return int Count of "much style" reaction
         */
        public function get_style_reaction(): int {
            return $this->style_reaction;
        }

        /**
         * @param int $style_reaction New count of "much style" reaction
         */
        public function set_style_reaction(int $style_reaction): void {
            $this->style_reaction = $style_reaction;
        }

        /**
         * @return int Count of "swag" reaction
         */
        public function get_swag_reaction(): int {
            return $this->swag_reaction;
        }

        /**
         * @param int $swag_reaction New count of "swag" reaction
         */
        public function set_swag_reaction(int $swag_reaction): void {
            $this->swag_reaction = $swag_reaction;
        }

        /**
         * @return bool True if the message was reacted with "love", false otherwise
         */
        public function is_love_reacted(): bool {
            return $this->love_reacted;
        }

        /**
         * @param bool $love_reacted New reaction state for "love"
         */
        public function set_love_reacted(bool $love_reacted): void {
            $this->love_reacted = $love_reacted;
        }

        /**
         * @return bool True if the message was reacted with "cute", false otherwise
         */
        public function is_cute_reacted(): bool {
            return $this->cute_reacted;
        }

        /**
         * @param bool $cute_reacted New reaction state for "cute"
         */
        public function set_cute_reacted(bool $cute_reacted): void {
            $this->cute_reacted = $cute_reacted;
        }

        /**
         * @return bool True if the message was reacted with "much style", false otherwise
         */
        public function is_style_reacted(): bool {
            return $this->style_reacted;
        }

        /**
         * @param bool $style_reacted New reaction state for "much style"
         */
        public function set_style_reacted(bool $style_reacted): void {
            $this->style_reacted = $style_reacted;
        }

        /**
         * @return bool True if the message was reacted with "swag", false otherwise
         */
        public function is_swag_reacted(): bool {
            return $this->swag_reacted;
        }

        /**
         * @param bool $swag_reacted New reaction state for "swag"
         */
        public function set_swag_reacted(bool $swag_reacted): void {
            $this->swag_reacted = $swag_reacted;
        }
    }

    ?>