<?php
    namespace Vanestarre\Controller;

    use Vanestarre\View\VanestarreConfigView;

    /**
    * Class VanestarreConfigController
    *
    * Controller for the VanestarreConfigView page
    *
    * @author CHATEAUX Adrien
    * @package Vanestarre\Controller
    */
    class TemplateController implements IController
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
            $this->view = new VanestarreConfigView();
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
            return [];
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