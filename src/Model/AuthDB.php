<?php
    namespace Vanestarre\Model;

    use Error;
    use Exception;
    use mysqli;

    /**
    * Class Messages
    *
    * Access the table MESSAGES from the database
    *
    * @author DEUDON Eugénie
    * @package Vanestarre\Model
    */

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

        /**
         * @param string $pseudo
         * @param string $email
         * @param string $mot_de_passe
         * Create a new user in the database.
         */
        public function add_user(string $pseudo, string $email, string $mot_de_passe): void {
            $connection = $this->mysqli;
            $prepared_query = $connection->prepare('INSERT INTO UTILISATEURS(date_inscription, email, mot_de_passe, pseudo) VALUES (NOW(),?,?,?)');
            $prepared_query->bind_param('sss', $email, $mot_de_passe, $pseudo);
            $prepared_query->execute();
            $result = $prepared_query->get_result();
            if ($result == false) {
                throw new Exception("The user couldn't be inserted in the table.");
            }
        }
    }

?>