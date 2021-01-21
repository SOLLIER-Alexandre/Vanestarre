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
    class MessagesDB
    {
        /**
         * @var mysqli $mysqli A mysqli connection to the database.
         */
        private $mysqli;

        /**
         * MessagesDB constructor. Connects MessagesDB to the database.
         */
        public function __construct(){
            $this->mysqli = new mysqli('mysql-vanestarreiutinfo.alwaysdata.net', '222072', '0fQ12HhzmevY', 'vanestarreiutinfo_maindb');
            if (mysqli_connect_errno()) {
                throw new Error("Echec lors de la connexion à la base de données : " . mysqli_connect_error());
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
         * @throws Exception
         */
        public function get_n_last_messages(int $n, int $offset): array {
            $prepared_query = $this->mysqli->prepare('SELECT message_id, date, content, image_link FROM MESSAGES ORDER BY date DESC LIMIT ? OFFSET ?');
            $prepared_query->bind_param('ii', $n, $offset);
            $prepared_query->execute();
            $result = $prepared_query->get_result();
            if ($result == false) {
                throw new Exception("This query result is empty (function get_n_last_messages()).");
            } else {
                $messages_list = array();
                while ($row = $result->fetch_assoc()) {
                    $message_reactions = new MessageReactions();
                    $this->get_message_reaction_count($row['message_id'], $message_reactions);
                    array_push($messages_list, new Message($row['message_id'], $row['content'], new DateTimeImmutable($row['date']), $message_reactions, $row['image_link']));
                }
                return $messages_list;
            }
        }

        /**
         * Gets the count of reactions from a message.
         * @param int $message_id ID of the message to check reactions from
         * @param MessageReactions $reactions The reaction counts
         * @throws Exception
         */
        private function get_message_reaction_count(int $message_id, MessageReactions $reactions): void {
            $prepared_query = $this->mysqli->prepare('SELECT reaction_type, COUNT(reaction_type) FROM REACTIONS WHERE message_id = ? GROUP BY reaction_type;');
            $prepared_query->bind_param('i', $message_id);
            $prepared_query->execute();
            $result = $prepared_query->get_result();
            if ($result == false) {
                throw new Exception("This query result is empty (function message_reactions()).");
            } else {
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
         * Check if the user has reacted on the message.
         * @param string $username Username of the user to check reactions from
         * @param int $message_id ID of the message to check reactions from
         * @return bool
         */
        public function has_reacted(string $username, int $message_id): boolean {
            $prepared_query = $this->mysqli->prepare('SELECT reaction_type FROM REACTIONS WHERE message_id = ? AND username = ?');
            $prepared_query->bind_param('is', $message_id, $username);
            $prepared_query->execute();
            $result = $prepared_query->get_result();
            if ($result == false) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * Adds a reaction to the message.
         * @param int $message_id ID of the message to react to
         * @param string $reaction_type Type of the reaction
         * @param string $username Username of the user that reacted
         * @throws Exception
         */
        public function add_reaction(int $message_id, string $reaction_type, string $username): void {
            $prepared_query = $this->mysqli->prepare('INSERT INTO REACTIONS(message_id, reaction_type, username) VALUES(?, ?, ?)');
            $prepared_query->bind_param('iss', $message_id, $reaction_type, $username);
            $prepared_query->execute();
            if ($prepared_query == false) {
                throw new Exception("Error when adding the reaction.");
            }
        }

        /**
         * Adds a message in the database
         * @param string $content Content of the message to add
         * @param string|null $image URL of the image to join to the message, pass null for no image
         * @throws Exception
         */
        public function add_message(string $content, ?string $image): void {
            $prepared_query = $this->mysqli->prepare('INSERT INTO MESSAGES(content, date, image_link) VALUES(?, NOW(), ?)');
            $prepared_query->bind_param('ss', $content, $image);
            $prepared_query->execute();
            if ($prepared_query == false) {
                throw new Exception("Error with the message creation.");
            }
        }


        /**
         * Updates the content of a message.
         * @param int $message_id ID of the message to update
         * @param string $new_content New content
         * @throws Exception
         */
        public function edit_message(int $message_id, string $new_content): void {
            $prepared_query = $this->mysqli->prepare('UPDATE MESSAGES SET content = ? WHERE message_id = ?');
            $prepared_query->bind_param('si', $new_content, $message_id);
            $prepared_query->execute();
            if($prepared_query == false){
                throw new Exception("Error with the message update.");
            }
        }

        /**
         * Deletes a message from the database.
         * @param int $message_id ID of the message to delete
         * @throws Exception
         */
        public function delete_message(int $message_id): void {
            $prepared_query = $this->mysqli->prepare('DELETE FROM MESSAGES WHERE message_id = ?');
            $prepared_query->bind_param('i', $message_id);
            $prepared_query->execute();
            if ($prepared_query == false) {
                throw new Exception("Error with the message deletion.");
            }
        }

        /**
         * Counts the number of messages in the database.
         * @return int The number of messages
         * @throws Exception
         */
        public function count_messages(): int {
            $prepared_query = $this->mysqli->prepare('SELECT count(*) FROM MESSAGES');
            $prepared_query->execute();
            $result = $prepared_query->get_result();
            if ($result == false) {
                throw new Exception("This query result is empty (function message_reactions()).");
            } else {
                $row = $result->fetch_assoc();
                return $row['count(*)'];
            }
        }
    }

?>