<?php

    namespace Vanestarre\View;

    /**
     * Interface IView
     *
     * Interface for an MVC View
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\View
     */
    interface IView
    {
        /**
         * Outputs the content of the View
         * @return void
         */
        public function echo_contents();
    }

?>