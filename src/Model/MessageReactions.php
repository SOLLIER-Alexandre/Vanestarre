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
         * MessageReactions constructor.
         * @param int $love_reaction Count of "love" reaction
         * @param int $cute_reaction Count of "cute" reaction
         * @param int $style_reaction Count of "much style" reaction
         * @param int $swag_reaction Count of "swag" reaction
         */
        public function __construct(int $love_reaction = 0, int $cute_reaction = 0, int $style_reaction = 0, int $swag_reaction = 0) {
            $this->love_reaction = $love_reaction;
            $this->cute_reaction = $cute_reaction;
            $this->style_reaction = $style_reaction;
            $this->swag_reaction = $swag_reaction;
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
    }

    ?>