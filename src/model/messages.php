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
     * @var array $stored_messages will store messages from the database
     */
    private $stored_messages = array();

    /**
     * Connect to the database
     */
    public function db_connection(){
        $mysqli = new mysqli('mysql-vanestarreiutinfo.alwaysdata.net', '222072', '0fQ12HhzmevY', 'vanestarreiutinfo_maindb');
        if (mysqli_connect_errno()) {
            echo "Echec lors de la connexion à la base de données : " . mysqli_connect_error();
        }
    }

    /**
     * Store all messages from the database in $stored_messages
     */
    public function get_all_messages(){
        $allMessages = mysqli_fetch_all();
    }

}

?>