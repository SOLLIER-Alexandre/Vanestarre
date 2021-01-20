<?php
    namespace Vanestarre\Model;

    use DateTimeImmutable;
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
         * @param string $username
         * @param string $email
         * @param string $password
         * Create a new user in the database.
         */
        public function add_user(string $username, string $email, string $password): void {
            $prepared_query = $this->mysqli->prepare('INSERT INTO USERS(registration_date, email, password, username) VALUES (NOW(),?,?,?)');
            $prepared_query->bind_param('sss', $email, $password, $username);
            $prepared_query->execute();
            if($prepared_query == false){
                throw new Exception("Error with the new user insertion.");
            }
        }

        /**
         * @param string $username
         * @throws Exception
         * Delete a user in the database.
         */
        public function delete_user(string $username): void {
            $prepared_query = $this->mysqli->prepare('DELETE FROM USERS WHERE username = ?');
            $prepared_query->bind_param('s', $username);
            $prepared_query->execute();
            if($prepared_query == false){
                throw new Exception("Error with the user deletion.");
            }
        }

        /**
         * @param string $username
         * @return User
         * @throws Exception
         * Return user's data as an User object.
         */
        public function get_user_data(string $username): User {
            $prepared_query = $this->mysqli->prepare('SELECT * FROM USERS WHERE username = ?');
            $prepared_query->bind_param('s', $username);
            $prepared_query->execute();
            $result = $prepared_query->get_result();
            if ($result == false) {
                throw new Exception("Couldn't get data associated to the user.");
            } else {
                $user_data = $result->fetch_row();
                //return new User($user_data['username'], $user_data['email'], $user_data['password'], $user_data['registration_date']);
                return new User("Billy", "truc@mail.fr", '$2y$10$A2Tpm2iN6spCC', new DateTimeImmutable());
            }
        }

    }

?>