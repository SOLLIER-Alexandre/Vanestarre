<?php
    namespace Vanestarre\View;

    /**
    * Class TemplateView
    *
    * Config page for Vanestarre
    *
    * @author CHATEAUX Adrien
    * @package Vanestarre\View
    */
    class VanestarreConfigView implements IView
    {
        /**
        * @inheritDoc
        */
        public function echo_contents()
        {
            echo '        <h1>Template Vanéstarre</h1>' . PHP_EOL;
        }
    }
?>