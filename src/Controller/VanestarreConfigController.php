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
        * TemplateController constructor.
        */
        public function __construct()
        {
            $config = new VanestarreConfig();
            $this->view = new VanestarreConfigView($config->get_nbr_messages_par_page(), $config->get_love_lim_inf(), $config->get_love_lim_sup());
        }

        /**
         * @inheritDoc
         */
        public function execute()
        {
            // Output the view contents
            $this->view->echo_contents();
        }

        /**
         * @inheritDoc
         */
        public function get_title(): string
        {
            return 'Vanestarre Config';
        }

        /**
         * @inheritDoc
         */
        public function get_stylesheets(): array
        {
            return ['/styles/vanestarre_config.css'];
        }

        /**
         * @inheritDoc
         */
        public function get_scripts(): array
        {
            return [];
        }

        /**
         * @inheritDoc
         */
        public function needs_standard_layout(): bool
        {
            return true;
        }
    }
?>