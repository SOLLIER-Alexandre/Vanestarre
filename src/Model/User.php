<?php

    namespace Vanestarre\Model;

    use DateTimeImmutable;

    /**
     * Class User
     *
     * Holds properties of a user
     *
     * @author RADJA Samy
     * @package Vanestarre\Model
     */
    class User
    {
        /**
         * @var int $id User's ID
         */
        private $id;

        /**
         * @var string $username User's name
         */
        private $username;

        /**
         * @var string $email User's email
         */
        private $email;

        /**
         * @var string $password User's password
         */
        private $password;

        /**
         * @var DateTimeImmutable $creation_date Time of the creation of the user
         */
        private $creation_date;

        /**
         * Constructs a new user
         * @param int $id User's ID
         * @param string $username User's name
         * @param string $email User's email
         * @param string $password User's password
         * @param DateTimeImmutable $creation_date Time of the creation of the user
         */
        public function __construct(int $id, string $username, string $email, string $password, DateTimeImmutable $creation_date) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->creation_date = $creation_date;
        }

        /**
         * @return int The user's ID
         */
        public function get_id(): int {
            return $this->id;
        }

        /**
         * @return string The user's username
         */
        public function get_username(): string {
            return $this->username;
        }

        /**
         * @return string The user's email
         */
        public function get_email(): string
        {
            return $this->email;
        }

        /**
         * @return string The user's hashed password
         */
        public function get_password(): string
        {
            return $this->password;
        }

        /**
         * @return DateTimeImmutable The time of the creation of the user
         */
        public function get_creation_date(): DateTimeImmutable
        {
            return $this->creation_date;
        }
    }
?>