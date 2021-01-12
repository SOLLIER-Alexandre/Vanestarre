<?php

    /**
     * Interface IView
     *
     * Interface for an MVC View
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