<?php

    namespace Vanestarre\Controller\Message\Reaction;

    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseConnectionException;
    use Vanestarre\Exception\DatabaseDeleteException;
    use Vanestarre\Model\AuthDB;
    use Vanestarre\Model\MessagesDB;

    /**
     * Class MessageReactionUnsetController
     *
     * Controller for removing a user reaction from a message
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\Message\Reaction
     */
    class MessageReactionUnsetController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            // Prepare the response
            $response = ['success' => false];
            header('Content-type: application/json');

            // Grab the currently connected user
            session_start();
            try {
                $auth_db = new AuthDB();
                $connected_user = $auth_db->get_logged_in_user();
            } catch (DatabaseConnectionException $e) {
                // Authentication is down, we'll throw an error at the user
                $connected_user = null;
            }

            // Make sure it's not null
            if (!isset($connected_user)) {
                // User is not logged in
                http_response_code(401);
                echo json_encode($response);
                return;
            }

            // Check posted values
            if (is_numeric($_POST['messageId'])) {
                try {
                    // Remove the reaction from the database
                    $message_db = new MessagesDB();

                    $message_db->delete_reaction(intval($_POST['messageId']), $connected_user->get_id());
                    $response['success'] = true;
                } catch (DatabaseDeleteException $e) {
                    // Reaction deletion failed
                    http_response_code(400);
                    $response['error_code'] = 2;
                } catch (DatabaseConnectionException $e) {
                    // Couldn't connect to the database
                    http_response_code(400);
                    $response['error_code'] = 3;
                }
            } else {
                // One of the parameter was malformed
                http_response_code(400);
                $response['error_code'] = 1;
            }

            // Echo the response
            echo json_encode($response);
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Remove a reaction';
        }

        /**
         * @inheritDoc
         */
        public function get_stylesheets(): array {
            return [];
        }

        /**
         * @inheritDoc
         */
        public function get_scripts(): array {
            return [];
        }

        /**
         * @inheritDoc
         */
        public function needs_standard_layout(): bool {
            return false;
        }
    }

?>