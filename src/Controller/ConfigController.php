<?php
    namespace Vanestarre\Controller;

    use Vanestarre\Exception\DatabaseConnectionException;
    use Vanestarre\Exception\DatabaseSelectException;
    use Vanestarre\Model\AuthDB;
    use Vanestarre\Model\User;
    use Vanestarre\Model\VanestarreConfig;
    use Vanestarre\View\ConfigView;

    /**
     * Class ConfigController
     *
     * Controller for the ConfigView page
     *
     * @author CHATEAUX Adrien
     * @package Vanestarre\Controller
     */
    class ConfigController implements IController
    {
        /**
         * @var ConfigView View associated with this controller
         */
        private $view;

        /**
         * @var User|null Currently connected user
         */
        private $connected_user;

        /**
         * ConfigController constructor.
         */
        public function __construct() {
            $config = new VanestarreConfig();
            $this->view = new ConfigView($config->get_nbr_messages_par_page(), $config->get_love_lim_inf(), $config->get_love_lim_sup());

            // Get the currently connected user
            session_start();
            try {
                $auth_db = new AuthDB();
                $this->connected_user = $auth_db->get_logged_in_user();
            } catch (DatabaseConnectionException $e) {
                // Let the connected user be null
                $this->connected_user = null;
            }
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            if (!isset($this->connected_user) || $this->connected_user->get_id() !== 0) {
                // User is not authorized
                http_response_code(401);
                header('Location: /unauthorized');
                return;
            }

            try {
                $auth_db = new AuthDB();
                $this->view->set_users($auth_db->get_all_users());
            } catch (DatabaseConnectionException | DatabaseSelectException $e) {
                // We should have been redirected to the /unauthorized location by now anyway
            }

            // Set the error to the view if there is one
            $this->view->set_show_error(isset($_GET['err']));

            // Output the view contents
            $this->view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string {
            return 'Vanestarre Config';
        }

        /**
         * @inheritDoc
         */
        public function get_stylesheets(): array {
            return ['/styles/config.css'];
        }

        /**
         * @inheritDoc
         */
        public function get_scripts(): array {
            return ['/scripts/config.js'];
        }

        /**
         * @inheritDoc
         */
        public function needs_standard_layout(): bool {
            if (isset($this->connected_user)) {
                return $this->connected_user->get_id() === 0;
            }

            return false;
        }
    }
?>