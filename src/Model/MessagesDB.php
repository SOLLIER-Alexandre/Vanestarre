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
            $prepared_query = $this->mysqli->prepare('SELECT message_id, date, content, image_link FROM MESSAGES ORDER BY date LIMIT ? OFFSET ?');
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
        private function message_reactions($message_id){
            $prepared_query = $this->mysqli->prepare('SELECT count(*) FROM REACTIONS WHERE message_id=? GROUP BY reaction_type');
            $prepared_query->bind_param('i', $messages_id);
            $prepared_query->execute();
            $result = $prepared_query->get_result();
            if ($result == false) {
                throw new Exception("This query result is empty (function message_reactions()).");
            } else {
                $message_reactions = new MessageReactions();
                while($row = $result->fetch_assoc()){
                    $message_reactions->set_cute_reaction($row['cute_reactions']);
                    $message_reactions->set_love_reaction($row['love_reactions']);
                    $message_reactions->set_style_reaction($row['style_reactions']);
                    $message_reactions->set_swag_reaction($row['swag_reactions']);
                }
                return $message_reactions;
            }
        }

        /**
         * @param $username
         * @param $message_id
         * @return bool
         */
        public function has_reacted($username, $message_id) : boolean{
            //todo
        }

    }

?>