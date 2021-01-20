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
         * @var DateTimeImmutable $creation_date Timestamp of the creation of the user
         */
        private $creation_date;

        /**
         * Constructs a new user
         * @param string $username User's name
         * @param string $email User's email
         * @param string $password User's password
         * @param DateTimeImmutable $creation_date Timestamp of the creation of the user
         */
         public function __construct(string $username, string $email, string $password, DateTimeImmutable $creation_date) {
             $this->username = $username;
             $this->email = $email;
             $this->password = $password;
             $this->creation_date = $creation_date;
         }

        /**
         * @return string
         */
        public function get_username(): string
        {
            return $this->username;
        }

        /**
         * @return string
         */
        public function get_email(): string
        {
            return $this->email;
        }

        /**
         * @param string $email
         */
        public function set_email(string $email): void
        {
            $this->email = $email;
        }

        /**
         * @return string
         */
        public function get_password(): string
        {
            return $this->password;
        }

        /**
         * @param string $password
         */
        public function set_password(string $password): void
        {
            $this->password = $password;
        }

        /**
         * @return DateTimeImmutable
         */
        public function get_creation_date(): DateTimeImmutable
        {
            return $this->creation_date;
        }

        /**
         * @param DateTimeImmutable $creation_date
         */
        public function set_creation_date(DateTimeImmutable $creation_date): void
        {
            $this->creation_date = $creation_date;
        }

    }

?>