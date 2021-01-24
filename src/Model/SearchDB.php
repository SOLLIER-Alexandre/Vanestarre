<?php

    namespace Vanestarre\Model;

    use DateTimeImmutable;
    use mysqli;
    use mysqli_stmt;
    use Vanestarre\Exception\DatabaseDeleteException;
    use Vanestarre\Exception\DatabaseInsertException;
    use Vanestarre\Exception\DatabaseSelectException;

    /**
     * Class SearchDB
     *
     * Model for the search page
     *
     * @author DEUDON Eugénie
     * @package Vanestarre\Model
     */

    class SearchDB{
        /**
         * @var mysqli $mysqli A mysqli connection to the database.
         */
        private $mysqli;

        /**
         * SearchDB constructor. Connects SearchDB to the database.
         */
        public function __construct(){
            $this->mysqli = new mysqli('mysql-vanestarreiutinfo.alwaysdata.net', '222072', '0fQ12HhzmevY', 'vanestarreiutinfo_maindb');
            if (mysqli_connect_errno()) {
                throw new Error("Echec lors de la connexion à la base de données : " . mysqli_connect_error());
            }
        }

        /**
         * SearchDB destructor. Closes the mysqli connection to the database.
         */
        public function __destruct(){
            $this->mysqli->close();
        }


        /**
         * Get messages with a specific tag
         * @param string $tag The tag (a word after β symbol) to find
         * @return array Messages with the tag
         * @throws DatabaseSelectException
         */
        public function get_messages_from_search(string $tag): array {
            $messDB = new MessagesDB();
            $prepared_query = $this->mysqli->prepare("SELECT message_id, date, content, image_link FROM MESSAGES WHERE content LIKE '%β?%'");
            $prepared_query->bind_param('s', $tag);
            $prepared_query->execute();
            $result = $prepared_query->get_result();

            if (!$result) {
                throw new DatabaseSelectException();
            } else {
                $messages_list = array();
                while ($row = $result->fetch_assoc()) {
                    $message_reactions = new MessageReactions();
                    $messDB->get_message_reaction_count($row['message_id'], $message_reactions);
                    array_push($messages_list, new Message($row['message_id'], $row['content'], new DateTimeImmutable($row['date']), $message_reactions, $row['image_link']));
                }
                return $messages_list;
            }

        }
    }
?>