<?php

    /**
     * Interface IController
     *
     * Interface for an MVC Controller
     *
     * @author SOLLIER Alexandre
     */
    interface IController
    {
        /**
         * Executes the controller, which will get data from its Model and display it using its View
         * @return void
         */
        public function execute();

        /**
         * Returns the page title associated with this controller
         * @return string The page title
         */
        public function get_title(): string;

        /**
         * Returns the .css stylesheet files this page needs
         * @return array The stylesheet file paths
         */
        public function get_stylesheets(): array;

        /**
         * Returns the .js script files this page needs
         * @return array The script file paths
         */
        public function get_scripts(): array;

        /**
         * Returns true if the controller needs to have the common HTML document and layout outputted
         * to the page, or false if the controller takes care of it
         * @return bool True if the controller needs the standard layout
         */
        public function needs_standard_layout(): bool;
    }
?>