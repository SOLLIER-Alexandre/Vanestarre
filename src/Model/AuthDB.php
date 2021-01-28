<?php
    namespace Vanestarre\Model;

    use DateTimeImmutable;
    use Exception;
    use mysqli;
    use mysqli_stmt;
    use Vanestarre\Exception\DatabaseConnectionException;
    use Vanestarre\Exception\DatabaseDeleteException;
    use Vanestarre\Exception\DatabaseInsertException;
    use Vanestarre\Exception\DatabaseSelectException;
    use Vanestarre\Exception\DatabaseUpdateException;

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
         * AuthDB constructor. Connects AuthDB to the database.
         * @throws DatabaseConnectionException
         */
        public function __construct() {
            // Create a mysqli connection to the database
            $this->mysqli = new mysqli('mysql-vanestarreiutinfo.alwaysdata.net', '222072',
                '0fQ12HhzmevY', 'vanestarreiutinfo_maindb');

            // Throws a DatabaseConnectionException if there is an error when establishing the connection
            if ($this->mysqli->connect_errno) {
                throw new DatabaseConnectionException("Echec lors de la connexion à la base de données : "
                    . $this->mysqli->connect_error);
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
         * @throws DatabaseInsertException
         */
        public function add_user(string $username, string $email, string $password): int {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('INSERT INTO USERS(registration_date, email, password, username) ' . 
                                                    'VALUES (NOW(),?,?,?)');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('sss', $email, $password, $username);

            // Execute the query, and throws a DatabaseInsertException if an error occurred
            if (!$prepared_query->execute()) {
                throw new DatabaseInsertException();
            }

            // Return the ID of the new user
            return $prepared_query->insert_id;
        }

        /**
         * Delete a user in the database.
         * @param int $id ID of the user to delete
         * @throws DatabaseDeleteException
         */
        public function delete_user(int $id): void {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('DELETE FROM USERS WHERE user_id = ?');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('i', $id);

            // Execute the query, and throws a DatabaseDeleteException if an error occurred
            if (!$prepared_query->execute()) {
                throw new DatabaseDeleteException();
            }
        }

        /**
         * Gets user data from a prepared query.
         * @param mysqli_stmt $prepared_query The prepared query
         * @return User Data about the user
         * @throws DatabaseSelectException
         */
        private function get_user_data(mysqli_stmt $prepared_query): User {
            // Execute the query given as parameter
            $prepared_query->execute();
            // Store the result of the query (result of a SELECT query)
            $result = $prepared_query->get_result();

            // If the query returned something...
            if ($result) {
                // Stores the query result as an array called "$user_data"
                $user_data = $result->fetch_assoc();
                try{
                    // If $user_data isn't empty, create a new User object and return it
                    if (isset($user_data)) {
                        return new User($user_data['user_id'], $user_data['username'],
                            $user_data['email'], $user_data['password'],
                            new DateTimeImmutable($user_data['registration_date']));
                    }
                // If DateTimeImmutable throws an exception, throws a DatabaseSelectException
                } catch (Exception $exception){
                    throw new DatabaseSelectException();
                }

            }

            // If the query returned nothing or $user_data is empty...
            throw new DatabaseSelectException();
        }

        /**
         * Return user's data as an User object.
         * @param string $username Username of the user to fetch
         * @return User Data about the user
         * @throws DatabaseSelectException
         */
        public function get_user_data_by_username(string $username): User {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('SELECT * FROM USERS WHERE username = ?');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('s', $username);

            // Return a User object created with get_user_data()
            return $this->get_user_data($prepared_query);
        }

        /**
         * Return user's data as an User object.
         * @param int $user_id ID of the user to fetch
         * @return User Data about the user
         * @throws DatabaseSelectException
         */
        public function get_user_data_by_id(int $user_id): User {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('SELECT * FROM USERS WHERE user_id = ?');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('i', $user_id);

            // Return a User object created with get_user_data()
            return $this->get_user_data($prepared_query);
        }

        /**
         * Gets the currently logged in user
         * Warning: Session must be started before calling this function
         *
         * @return User|null Currently logged in user
         */
        public function get_logged_in_user(): ?User {
            if (!is_int($_SESSION['current_user'])) {
                // No one's logged in
                return null;
            }

            try {
                // Return the logged in user data
                return $this->get_user_data_by_id($_SESSION['current_user']);
            } catch (DatabaseSelectException $e) {
                // Stored logged in user is invalid, fix this
                unset($_SESSION['current_user']);
                return null;
            }
        }

        /**
         * Change the password of the user from an user_id
         * @param int $user_id ID of the user
         * @param string $new_password New password for the user
         * @throws DatabaseUpdateException
         */
        public function change_password(int $user_id, string $new_password): void {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('UPDATE USERS SET password = ? WHERE user_id = ?');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('si', $new_password, $user_id);

            // Execute the query, and throws a DatabaseUpdateException if an error occurred
            if (!$prepared_query->execute()) {
                throw new DatabaseUpdateException();
            }
        }

        /**
         * Change the username of the user from an user_id
         * @param int $user_id ID of the user
         * @param string $new_username New username for the user
         * @param string $new_email New email for the user
         * @throws DatabaseUpdateException
         */
        public function change_username_and_email(int $user_id, string $new_username, string $new_email): void {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('UPDATE USERS SET username = ?, email = ? WHERE user_id = ?');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('ssi', $new_username, $new_email, $user_id);

            // Execute the query, and throws a DatabaseUpdateException if an error occurred
            if (!$prepared_query->execute()) {
                throw new DatabaseUpdateException();
            }
        }

        /**
         * Return the id of an user from the database with an email
         * @param ?string $email Email of the user
         * @return int ID of the user
         * @throws DatabaseSelectException
         */
        public function get_id_from_email(?string $email): ?string {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('SELECT user_id FROM USERS WHERE email = ?');
            // Bind parameters to the query's template : create a real query and executes it
            $prepared_query->bind_param('s', $email);
            $prepared_query->execute();

            // Stores the query's result
            $result = $prepared_query->get_result();

            // If it's empty, throws a DatabaseSelectException
            if (!$result) {
                throw new DatabaseSelectException();
            } else {
                // Returns the user's ID
                $row = $result->fetch_assoc();
                return $row['user_id'];
            }
        }

        /**
         * Return an array with all users from the database
         * @return array Array of users
         * @throws DatabaseSelectException
         */
        public function get_all_users(): array {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('SELECT * FROM USERS');
            // Bind parameters to the query's template : create a real query and executes it
            $prepared_query->execute();

            // Stores the query's result
            $result = $prepared_query->get_result();

            // If it's empty, throws a DatabaseSelectException
            if(!$result){
                throw new DatabaseSelectException();
            } else {
                // Fills an array with User objects
                $user_list = array();
                try {
                    while($row = $result->fetch_assoc()){
                        array_push($user_list, new User($row['user_id'],
                            $row['username'], $row['email'],
                            $row['password'], new DateTimeImmutable($row['registration_date'])));
                    }
                // If DateTimeImmutable throws an exception, throws a DatabaseSelectException
                } catch(Exception $exception) {
                    throw new DatabaseSelectException();
                }

                return $user_list;
            }
        }

    }
?>