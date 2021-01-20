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
                    $message_reactions = $this->message_reactions($row['message_id']);
                    array_push($messages_list, new Message($row['message_id'], $row['content'], new \DateTimeImmutable($row['date']), $message_reactions, $row['image_link']));
                }
                return $messages_list;
            }
        }

        /**
         * @param $message_id
         * @return MessageReactions
         * @throws Exception
         * Instantiate a MessageReactions object.
         */
        private function message_reactions(int $message_id): MessageReactions {
            $prepared_query = $this->mysqli->prepare('SELECT count(*) FROM REACTIONS WHERE message_id=? GROUP BY reaction_type');
            $prepared_query->bind_param('i', $messages_id);
            $prepared_query->execute();
            $result = $prepared_query->get_result();
            if ($result == false) {
                throw new Exception("This query result is empty (function message_reactions()).");
            } else {
                $message_reactions = new MessageReactions();
                while($row = $result->fetch_assoc()){
                    $message_reactions->set_cute_reaction($row['cute']);
                    $message_reactions->set_love_reaction($row['love']);
                    $message_reactions->set_style_reaction($row['style']);
                    $message_reactions->set_swag_reaction($row['swag']);
                }
                return $message_reactions;
            }
        }

        /**
         * @param $username
         * @param $message_id
         * @return bool
         * Check if the user has reacted on the message.
         */
        public function has_reacted(string $username, Message $message_object): boolean {
            //todo
        }

        /**
         * @param $message_object
         * @throws Exception
         * Add a new message in the database.
         */
        public function add_message(Message $message_object): void {
            $prepared_query = $this->mysqli->prepare('INSERT INTO MESSAGES(content, date, image_link) VALUES(?, NOW(), ?)');
            $message = $message_object->get_message();
            $image = $message_object->get_image();
            $prepared_query->bind_param('ss', $message, $image);
            $prepared_query->execute();
            if($prepared_query == false){
                throw new Exception("Error with the message creation.");
            }
        }

        /**
         * @param $message_object
         * @throws Exception
         * Edit a message from the database.
         */
        public function edit_message(Message $message_object): void {
            $prepared_query = $this->mysqli->prepare('UPDATE MESSAGES SET content = ? WHERE message_id = ?');
            $message = $message_object->get_message();
            $id = $message_object->get_id();
            $prepared_query->bind_param('si', $message, $id);
            $prepared_query->execute();
            if($prepared_query == false){
                throw new Exception("Error with the message update.");
            }
        }

        /**
         * @param $message_object
         * @throws Exception
         * Delete a message in the database.
         */
        public function delete_message($message_object): void {
            $prepared_query = $this->mysqli->prepare('DELETE FROM MESSAGES WHERE message_id = ?');
            $id = $message_object->get_id();
            $prepared_query->bind_param('i', $id);
            $prepared_query->execute();
            if($prepared_query == false){
                throw new Exception("Error with the message deletion.");
            }
        }
    }

?>