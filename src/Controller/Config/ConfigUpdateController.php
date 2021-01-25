<?php
    namespace Vanestarre\Controller\Config;

    use Vanestarre\Controller\IController;
    use Vanestarre\Model\VanestarreConfig;

    /**
     * Class ConfigUpdateController
     *
     * Used to change the json config file
     *
     * @author CHATEAUX Adrien
     * @package Vanestarre\Controller\Config
     */
    class ConfigUpdateController implements IController
    {
        /**
         * @inheritDoc
         */
        public function execute() {
            session_start();
            if ($_SESSION['current_user'] !== 0) {
                // User is not authorized
                http_response_code(401);
                header('Location: /unauthorized');
                return;
            }

            $redirect_route = '/config';

            // Grab posted values
            $nbr_messages_par_page = $_GET['nbr_messages_par_page'];
            $nbr_min_react_pour_event = $_GET['nbr_min_react_pour_event'];
            $nbr_max_react_pour_event = $_GET['nbr_max_react_pour_event'];

            // Check posted values
            if (is_numeric($nbr_messages_par_page) && is_numeric($nbr_min_react_pour_event) && is_numeric($nbr_max_react_pour_event)) {
                // Convert values to int
                $nbr_messages_par_page = intval($nbr_messages_par_page);
                $nbr_min_react_pour_event = intval($nbr_min_react_pour_event);
                $nbr_max_react_pour_event = intval($nbr_max_react_pour_event);

                // Check posted values bounds
                $nbr_messages_par_page = max($nbr_messages_par_page, 1);
                $nbr_min_react_pour_event = max($nbr_min_react_pour_event, 1);
                $nbr_max_react_pour_event = max($nbr_max_react_pour_event, 1);

                if ($nbr_min_react_pour_event > $nbr_max_react_pour_event) {
                    // Min is greater than max, swap those two
                    $temp = $nbr_min_react_pour_event;
                    $nbr_min_react_pour_event = $nbr_max_react_pour_event;
                    $nbr_max_react_pour_event = $temp;
                }

                // Save the new config
                $config = new VanestarreConfig();

                $config->set_nbr_messages_par_page($nbr_messages_par_page);
                $config->set_love_lim_inf($nbr_min_react_pour_event);
                $config->set_love_lim_sup($nbr_max_react_pour_event);

                $config->save_config();
            } else {
                // One of the parameter was malformed
                // TODO: Show this error in the view
                $redirect_route = '/config?err=1';
                http_response_code(400);
            }

            header('Location: ' . $redirect_route);
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Modif Config';
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