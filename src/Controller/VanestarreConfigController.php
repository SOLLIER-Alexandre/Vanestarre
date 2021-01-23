<?php
    namespace Vanestarre\Controller;

    use Vanestarre\Model\VanestarreConfig;
    use Vanestarre\View\VanestarreConfigView;

    /**
    * Class VanestarreConfigController
    *
    * Controller for the VanestarreConfigView page
    *
    * @author CHATEAUX Adrien
    * @package Vanestarre\Controller
    */
    class VanestarreConfigController implements IController
    {
        /**
         * @var VanestarreConfigView View associated with this controller
         */
        private $view;

        /**
         * VanestarreConfigController constructor.
         */
        public function __construct() {
            $config = new VanestarreConfig();
            $this->view = new VanestarreConfigView($config->get_nbr_messages_par_page(), $config->get_love_lim_inf(), $config->get_love_lim_sup());
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
            return ['/styles/vanestarre_config.css'];
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