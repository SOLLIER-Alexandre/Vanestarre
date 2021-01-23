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
         * Create a new user in the database.
         * @param string $username Username of the new user
         * @param string $email Email of the new user
         * @param string $password Hashed password of the new user
         * @return int New user ID
         * @throws Exception
         */
        public function add_user(string $username, string $email, string $password): int {
            $prepared_query = $this->mysqli->prepare('INSERT INTO USERS(registration_date, email, password, username) VALUES (NOW(),?,?,?)');
            $prepared_query->bind_param('sss', $email, $password, $username);

            if (!$prepared_query->execute()) {
                throw new Exception("Error with the new user insertion.");
            }

            return $prepared_query->insert_id;
        }

        /**
         * Delete a user in the database.
         * @param string $username Username of the user to delete
         * @throws Exception
         */
        public function delete_user(string $username): void {
            $prepared_query = $this->mysqli->prepare('DELETE FROM USERS WHERE username = ?');
            $prepared_query->bind_param('s', $username);

            if (!$prepared_query->execute()) {
                throw new Exception("Error with the user deletion.");
            }
        }

        /**
         * Return user's data as an User object.
         * @param string $username Username of the user to fetch
         * @return User Data about the user
         * @throws Exception
         */
        public function get_user_data(string $username): User {
            $prepared_query = $this->mysqli->prepare('SELECT * FROM USERS WHERE username = ?');
            $prepared_query->bind_param('s', $username);

            $prepared_query->execute();
            $result = $prepared_query->get_result();

            if ($result) {
                $user_data = $result->fetch_assoc();
                if (isset($user_data)) {
                    return new User($user_data['user_id'], $user_data['username'], $user_data['email'], $user_data['password'], new DateTimeImmutable($user_data['registration_date']));
                }
            }

            throw new Exception("Couldn't get data associated to the user.");
        }
    }
?>