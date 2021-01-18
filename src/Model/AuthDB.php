<?php
    class AuthDB{
        /**
         * @var mysqli $mysqli A mysqli connection to the database.
         */
        private $mysqli;

        /**
         * MessagesDB constructor. Connects AuthDB to the database.
         */
        public function __construct(){
            $this->mysqli = new mysqli('mysql-vanestarreiutinfo.alwaysdata.net', '222072', '0fQ12HhzmevY', 'vanestarreiutinfo_maindb');
            if (mysqli_connect_errno()) {
                throw new Error("Echec lors de la connexion à la base de données : " . mysqli_connect_error());
            }
        }

        /**
         * AuthDB destructor. Closes the mysqli connection to the database.
         */
        public function __destruct(){
            $this->mysqli->close();
        }
    }

?>