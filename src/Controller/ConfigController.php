<?php
    namespace Vanestarre\Controller;

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
         * ConfigController constructor.
         */
        public function __construct() {
            $config = new VanestarreConfig();
            $this->view = new ConfigView($config->get_nbr_messages_par_page(), $config->get_love_lim_inf(), $config->get_love_lim_sup());
        }

        /**
         * @inheritDoc
         */
        public function execute() {
            if ($_SESSION['current_user'] !== 0) {
                // User is not authorized
                http_response_code(401);
                header('Location: /unauthorized');
                return;
            }

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
            return [];
        }

        /**
         * @inheritDoc
         */
        public function needs_standard_layout(): bool {
            session_start();
            return $_SESSION['current_user'] === 0;
        }
    }
?>