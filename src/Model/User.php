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
         * @var DateTimeImmutable $creation_date Timestamp of the creation of the message
         */
        private $creation_date;



    }