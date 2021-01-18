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
         * Connect to the database
         * @return mysqli A mysqli connection to the database
         */
        public function db_connection(): mysqli {
            $mysqli = new mysqli('mysql-vanestarreiutinfo.alwaysdata.net', '222072', '0fQ12HhzmevY', 'vanestarreiutinfo_maindb');
            if (mysqli_connect_errno()) {
                throw new Error("Echec lors de la connexion à la base de données : " . mysqli_connect_error());
            }
            return $mysqli;
        }

        /**
         * Get last n messages with an offset
         * @param int $n Number of messages
         * @param int $offset Offset of the query
         * @return array A list with the last n messages
         */
        public function get_n_last_messages(int $n, int $offset): array {
            $connection = $this->db_connection();
            $prepared_query = $connection->prepare('SELECT message_id, date, content, image_link FROM MESSAGES LIMIT ? OFFSET ?');
            $prepared_query->bind_param('ii', $n, $offset);
            $prepared_query->execute();
            $result = $prepared_query->get_result();
            if ($result == false) {
                throw new Exception("This query result is empty.");
            } else {
                $messages_list = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($messages_list, new Message($row['message_id'], $row['content'], $row['date'], new MessageReactions(), $row['image_link']));
                }
                return $messages_list;
            }

        }

    }

?>