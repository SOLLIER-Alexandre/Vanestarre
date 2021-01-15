<?php
/**
 * Class Messages
 *
 * Access the table MESSAGES from the database
 *
 * @author DEUDON Eugénie
 */

class Messages
{
    /**
     * Connect to the database
     * @return mysqli A mysqli connection to the database
     */
    public function db_connection() : mysqli{
        $mysqli = new mysqli('mysql-vanestarreiutinfo.alwaysdata.net', '222072', '0fQ12HhzmevY', 'vanestarreiutinfo_maindb');
        if (mysqli_connect_errno()) {
            throw new Error("Echec lors de la connexion à la base de données : " . mysqli_connect_error());
        }
        return $mysqli;
    }

    /**
     * Get last n messages with an offset
     * @return array A list with the last n messages
     * @param int $n Number of messages
     * @param int $offset Offset of the query
     */
    public function get_n_last_messages(int $n, int $offset) : array{
        $preparedQuery = $this->db_connection()->prepare('SELECT date, content, image_link FROM MESSAGES LIMIT ? OFFSET ?');
        $preparedQuery->bind_param('ii', $n, $offset);
        $preparedQuery->execute();
        return $preparedQuery->get_result()->fetch_assoc();
    }

}

?>