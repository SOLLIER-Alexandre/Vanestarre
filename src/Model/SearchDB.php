<?php

    namespace Vanestarre\Model;

    use DateTimeImmutable;
    use Exception;
    use mysqli;
    use Vanestarre\Exception\DatabaseConnectionException;
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
         * @throws DatabaseConnectionException
         */
        public function __construct(){
            $this->mysqli = new mysqli('mysql-vanestarreiutinfo.alwaysdata.net', '222072',
                '0fQ12HhzmevY', 'vanestarreiutinfo_maindb');
            if ($this->mysqli->connect_errno) {
                throw new DatabaseConnectionException("Echec lors de la connexion à la base de données : "
                    . $this->mysqli->connect_error);
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
         * @param int $limit Number max of messages to return
         * @param int $offset Offset of the query
         * @return array Messages with the tag
         * @throws DatabaseSelectException
         */
        public function get_messages_from_search(string $tag, int $limit, int $offset): array {
            try {
                $message_db = new MessagesDB();
            } catch (DatabaseConnectionException $e) {
                // Couldn't connect to the database
                throw new DatabaseSelectException();
            }

            $first_part_of_query_param = '%β';
            $end_of_query_param = '%';
            $query_param = $first_part_of_query_param . $tag . $end_of_query_param;

            $prepared_query = $this->mysqli->prepare('SELECT message_id, date, content, reactions_for_donations, image_link ' .
                'FROM MESSAGES WHERE content LIKE ? ORDER BY date DESC LIMIT ? OFFSET ?');
            $prepared_query->bind_param('sii', $query_param, $limit, $offset);
            $prepared_query->execute();

            $result = $prepared_query->get_result();

            if (!$result) {
                throw new DatabaseSelectException();
            } else {
                $messages_list = array();

                while ($row = $result->fetch_assoc()) {
                    $message_reactions = new MessageReactions();
                    $message_db->get_message_reaction_count($row['message_id'], $message_reactions);

                    try {
                        array_push($messages_list, new Message($row['message_id'], $row['content'],
                            new DateTimeImmutable($row['date']), $row['reactions_for_donations'],
                            $message_reactions, $row['image_link']));
                    } catch (Exception $exception) {
                        throw new DatabaseSelectException();
                    }
                }

                return $messages_list;
            }

        }

        /**
         * Count messages with the tag in parameters
         * @param string $tag The keyword used for search
         * @return int Number of messages with the tag
         * @throws DatabaseSelectException
         */
        public function count_messages_with_tag(string $tag): int{
            $first_part_of_query_param = '%β';
            $end_of_query_param = '%';
            $query_param = $first_part_of_query_param . $tag . $end_of_query_param;
            $prepared_query = $this->mysqli->prepare('SELECT count(*) FROM MESSAGES WHERE content LIKE ? ');
            $prepared_query->bind_param('s', $query_param);
            $prepared_query->execute();
            $result = $prepared_query->get_result();

            if (!$result) {
                throw new DatabaseSelectException();
            } else {
                $row = $result->fetch_assoc();
                return $row['count(*)'];
            }
        }
    }
?>