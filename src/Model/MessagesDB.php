<?php

    namespace Vanestarre\Model;

    use DateTimeImmutable;
    use Exception;
    use mysqli;
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
    class MessagesDB
    {
        /**
         * @var mysqli $mysqli A mysqli connection to the database.
         */
        private $mysqli;

        /**
         * MessagesDB constructor. Connects MessagesDB to the database.
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
         * MessagesDB destructor. Closes the mysqli connection to the database.
         */
        public function __destruct(){
            $this->mysqli->close();
        }

        /**
         * Get last n messages with an offset
         * @param int $n Number of messages
         * @param int $offset Offset of the query
         * @return array A list with the last n messages
         * @throws DatabaseSelectException
         */
        public function get_n_last_messages(int $n, int $offset): array {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('SELECT message_id, date, content, image_link, reactions_for_donations ' .
                                                    'FROM MESSAGES ORDER BY date DESC LIMIT ? OFFSET ?');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('ii', $n, $offset);

            $prepared_query->execute();
            // Stores the query result
            $result = $prepared_query->get_result();

            // If the query result is empty
            if (!$result) {
                throw new DatabaseSelectException();
            } else {
                // Create an array to store Message objects
                $messages_list = array();

                while ($row = $result->fetch_assoc()) {
                    // Get the number of reactions per type on this message
                    $message_reactions = new MessageReactions();
                    $this->get_message_reaction_count($row['message_id'], $message_reactions);

                    // Fills the array with Message objects
                    try{
                        array_push($messages_list, new Message($row['message_id'], $row['content'],
                            new DateTimeImmutable($row['date']), $row['reactions_for_donations'],
                            $message_reactions, $row['image_link']));
                    } catch(Exception $exception) {
                        throw new DatabaseSelectException();
                    }
                }

                return $messages_list;
            }
        }

        /**
         * Gets the count of reactions from a message.
         * @param int $message_id ID of the message to check reactions from
         * @param MessageReactions $reactions The reaction counts
         * @throws DatabaseSelectException
         */
        public function get_message_reaction_count(int $message_id, MessageReactions $reactions): void {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('SELECT reaction_type, COUNT(reaction_type) ' .
                                                    'FROM REACTIONS WHERE message_id = ? GROUP BY reaction_type;');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('i', $message_id);

            $prepared_query->execute();
            // Stores the query result
            $result = $prepared_query->get_result();

            // If the query result is empty
            if (!$result) {
                throw new DatabaseSelectException();
            } else {
                // For each row in the query result, updates the MessageReactions object given in parameter
                while ($row = $result->fetch_assoc()) {
                    switch ($row['reaction_type']) {
                        case 'cute':
                            $reactions->set_cute_reaction($row['COUNT(reaction_type)']);
                            break;

                        case 'love':
                            $reactions->set_love_reaction($row['COUNT(reaction_type)']);
                            break;

                        case 'style':
                            $reactions->set_style_reaction($row['COUNT(reaction_type)']);
                            break;

                        case 'swag':
                            $reactions->set_swag_reaction($row['COUNT(reaction_type)']);
                            break;
                    }
                }
            }
        }

        /**
         * Return reactions from a user on multiple messages.
         * @param int $user_id ID of the user to check reactions from
         * @param array $message_ids IDs of the messages to check reactions from
         * @return array Array associating message IDs with their reaction
         * @throws DatabaseSelectException
         */
        public function get_reactions(int $user_id, array $message_ids): array {
            // Check the ID count
            if (count($message_ids) === 0) {
                return [];
            }

            $reactions = [];

            // Put as much param marker as there are IDs in the $message_ids array
            $ids_param = str_repeat('?, ', count($message_ids) - 1) . '?';
            $prepared_query = $this->mysqli->prepare('SELECT message_id, reaction_type FROM REACTIONS ' .
                                                    'WHERE user_id = ? AND message_id IN (' . $ids_param . ')');

            // Bind all the params, unpack the message IDs array
            $prepared_query->bind_param('i' . str_repeat('i', count($message_ids)), $user_id, ...$message_ids);
            $prepared_query->execute();

            // Stores the query result
            $result = $prepared_query->get_result();
            // If it's empty
            if (!$result) {
                throw new DatabaseSelectException();
            }

            // Store reactions in the array
            while ($row = $result->fetch_assoc()) {
                $reactions[$row['message_id']] = $row['reaction_type'];
            }

            return $reactions;
        }

        /**
         * Adds a reaction to the message.
         * @param int $message_id ID of the message to react to
         * @param string $reaction_type Type of the reaction
         * @param int $user_id ID of the user that reacted
         * @throws DatabaseInsertException
         */
        public function add_reaction(int $message_id, string $reaction_type, int $user_id): void {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('REPLACE INTO REACTIONS(message_id, reaction_type, user_id) ' .
                                                    'VALUES(?, ?, ?)');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('isi', $message_id, $reaction_type, $user_id);

            // Execute the query and throws a DatabaseInsertException if an error occurred
            if (!$prepared_query->execute()) {
                throw new DatabaseInsertException();
            }
        }

        /**
         * Delete a reaction from a user on a message.
         * @param int $message_id ID of the message to delete the reaction from
         * @param int $user_id ID of the user
         * @throws DatabaseDeleteException
         */
        public function delete_reaction(int $message_id, int $user_id): void {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('DELETE FROM REACTIONS WHERE message_id = ? AND user_id = ?');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('ii', $message_id, $user_id);

            // Execute the query and throws a DatabaseDeleteException if an error occurred
            if (!$prepared_query->execute()) {
                throw new DatabaseDeleteException();
            }
        }

        /**
         * Checks if the number of "love" reactions is equal to the number of "love" reaction required to donate for a message
         * @param int $message_id ID of the message to check
         * @return bool True if the number of "love" reactions is equal to the number of "love" reaction required to donate, false otherwise
         * @throws DatabaseSelectException
         */
        public function has_message_reached_reactions(int $message_id): bool {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('SELECT COUNT(*), reactions_for_donations ' .
                                                    'FROM REACTIONS JOIN MESSAGES M ON REACTIONS.message_id = M.message_id ' . 
                                                    'WHERE REACTIONS.message_id = ? AND reaction_type = \'love\'');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('i', $message_id);

            // Execute the query and stores the result
            $prepared_query->execute();
            $result = $prepared_query->get_result();

            // If the query result is empty
            if (!$result) {
                throw new DatabaseSelectException();
            } else {
                $row = $result->fetch_assoc();

                // Return true if the number of reactions has reached the number set by Vanestarre
                if (isset($row)) {
                    return $row['COUNT(*)'] === $row['reactions_for_donations'];
                } else {
                    throw new DatabaseSelectException();
                }
            }
        }

        /**
         * Adds a message in the database
         * @param string $content Content of the message to add
         * @param string|null $image URL of the image to join to the message, pass null for no image
         * @param int $reactions_for_donations The number of reactions before asking for a donation
         * @throws DatabaseInsertException
         */
        public function add_message(string $content, ?string $image, int $reactions_for_donations): void {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('INSERT INTO MESSAGES(content, date, image_link, reactions_for_donations) ' .
                                                    'VALUES(?, NOW(), ?, ?)');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('ssi', $content, $image, $reactions_for_donations);

            // Execute the query and throws a DatabaseInsertException if an error occurred
            if (!$prepared_query->execute()) {
                throw new DatabaseInsertException();
            }
        }


        /**
         * Modify message contents and set a new image
         * @param int $message_id ID of the message to update
         * @param string $new_content New content
         * @param string|null $new_image New image link, pass null to not update this column
         * @throws DatabaseUpdateException
         */
        public function edit_message(int $message_id, string $new_content, ?string $new_image): void {
            if (isset($new_image)) {
                // Modify message contents and image
                // Prepare the template for the SQL query
                $prepared_query = $this->mysqli->prepare('UPDATE MESSAGES SET content = ?, image_link = ? ' .
                                                        'WHERE message_id = ?');
                // Bind parameters to the query's template : create a real query
                $prepared_query->bind_param('ssi', $new_content, $new_image, $message_id);

                // Execute the query and throws a DatabaseUpdateException if an error occurred
                if (!$prepared_query->execute()) {
                    throw new DatabaseUpdateException();
                }
            // If there was no error during executions
            } else {
                // Only modify message contents
                // Prepare the template for the SQL query
                $prepared_query = $this->mysqli->prepare('UPDATE MESSAGES SET content = ? WHERE message_id = ?');
                // Bind parameters to the query's template : create a real query
                $prepared_query->bind_param('si', $new_content, $message_id);

                // Execute the query and throws a DatabaseUpdateException if an error occurred
                if (!$prepared_query->execute()) {
                    throw new DatabaseUpdateException();
                }
            }
        }

        /**
         * Deletes a message from the database.
         * @param int $message_id ID of the message to delete
         * @throws DatabaseDeleteException
         */
        public function delete_message(int $message_id): void {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('DELETE FROM MESSAGES WHERE message_id = ?');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('i', $message_id);

            // Execute the query and throws a DatabaseDeleteException if an error occurred
            if (!$prepared_query->execute()) {
                throw new DatabaseDeleteException();
            }
        }

        /**
         * Removes an image from a message
         * @param int $message_id ID of the message to delete an image for
         * @throws DatabaseUpdateException
         */
        public function remove_message_image(int $message_id): void {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('UPDATE MESSAGES SET image_link = null WHERE message_id = ?');
            // Bind parameters to the query's template : create a real query
            $prepared_query->bind_param('i', $message_id);

            // Execute the query and throws a DatabaseUpdateException if an error occurred
            if (!$prepared_query->execute()) {
                throw new DatabaseUpdateException();
            }
        }

        /**
         * Counts the number of messages in the database.
         * @return int The number of messages
         * @throws DatabaseSelectException
         */
        public function count_messages(): int {
            // Prepare the template for the SQL query
            $prepared_query = $this->mysqli->prepare('SELECT count(*) FROM MESSAGES');

            $prepared_query->execute();
            // Stores the query result
            $result = $prepared_query->get_result();

            // If the query result is empty
            if (!$result) {
                throw new DatabaseSelectException();
            } else {
                // Returns the number of messages
                $row = $result->fetch_assoc();
                return $row['count(*)'];
            }
        }
    }

?>