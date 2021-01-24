<?php

    namespace Vanestarre\Controller\Message\Reaction;

    use Vanestarre\Controller\IController;
    use Vanestarre\Exception\DatabaseInsertException;
    use Vanestarre\Model\AuthDB;
    use Vanestarre\Model\MessagesDB;

    /**
     * Class MessageReactionSetController
     *
     * Controller for adding a user reaction to a message
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\Controller\Message\Reaction
     */
    class MessageReactionSetController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            // Prepare the response
            $response = ['success' => false, 'donate' => false];

            // Grab the currently connected user
            session_start();
            $auth_db = new AuthDB();
            $connected_user = $auth_db->get_logged_in_user();

            // Make sure it's not null
            if (!isset($connected_user)) {
                // User is not logged in
                http_response_code(401);
                echo json_encode($response);
                return;
            }

            // Check posted values
            if (is_numeric($_POST['messageId']) && isset($_POST['reaction'])) {
                // Add the reaction to the database
                // TODO: Check if user must donate
                $message_db = new MessagesDB();

                try {
                    $message_db->add_reaction(intval($_POST['messageId']), $_POST['reaction'], $connected_user->get_id());
                    $response['success'] = true;
                } catch (DatabaseInsertException $e) {
                    // Reaction insertion failed
                    http_response_code(400);
                    $response['error_code'] = 2;
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
            return 'Add a reaction';
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