<?php

    namespace Vanestarre\Model;

    /**
     * Class SearchDB
     *
     * Model for the search page
     *
     * @author DEUDON Eugénie
     * @package Vanestarre\Model
     */

    class SearchDB{
        public function get_messages_from_search(string $tag): array {
            $prepared_query = $this->mysqli->prepare('SELECT ?');
            //SELECT message_id, date, content, image_link FROM MESSAGES WHERE content LIKE bruuuuh
        }
    }
?>