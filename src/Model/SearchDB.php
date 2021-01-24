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
        public function get_messages_from_search(string $tag, $limit, $offset): array {
            $messDB = new MessagesDB();
            $first_part_of_query_param = '%β';
            $end_of_query_param = '%';
            $query_param = $first_part_of_query_param . $tag . $end_of_query_param;
            $prepared_query = $this->mysqli->prepare('SELECT message_id, date, content, reactions_for_donations, image_link FROM MESSAGES WHERE content LIKE ? ORDER BY date LIMIT ? OFFSET ?');
            $prepared_query->bind_param('sii', $query_param, $limit, $offset);
            $prepared_query->execute();
            $result = $prepared_query->get_result();

            if (!$result) {
                throw new DatabaseSelectException();
            } else {
                $messages_list = array();
                while ($row = $result->fetch_assoc()) {
                    $message_reactions = new MessageReactions();
                    $messDB->get_message_reaction_count($row['message_id'], $message_reactions);
                    array_push($messages_list, new Message($row['message_id'], $row['content'], new DateTimeImmutable($row['date']), $row['reactions_for_donations'], $message_reactions, $row['image_link']));
                }
                return $messages_list;
            }

        }
    }
?>