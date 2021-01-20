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
         * @var int $default_nbr_messages_par_page The default value for the "nbr-messages-par-page" input
         */
        private $default_nbr_messages_par_page;

        /**
         * @var int $default_nbr_min_react_pour_event The default value for the "nbr-min-react-pour-event" input
         */
        private $default_nbr_min_react_pour_event;

        /**
         * @var int $default_nbr_max_react_pour_event The default value for the "nbr-max-react-pour-event" input
         */
        private $default_nbr_max_react_pour_event;

        /**
         * AccountView constructor.
         * @param int $default_nbr_messages_par_page The default value for the "nbr-messages-par-page" input
         * @param int $default_nbr_min_react_pour_event The default value for the "nbr-min-react-pour-event" input
         * @param int $default_nbr_max_react_pour_event The default value for the "nbr-max-react-pour-event" input
         */
        public function __construct(int $default_nbr_messages_par_page, int $default_nbr_min_react_pour_event, int $default_nbr_max_react_pour_event)
        {
            $this->default_nbr_messages_par_page = $default_nbr_messages_par_page;
            $this->default_nbr_min_react_pour_event = $default_nbr_min_react_pour_event;
            $this->default_nbr_max_react_pour_event = $default_nbr_max_react_pour_event;
        }

        /**
        * @inheritDoc
        */
        public function echo_contents()
        {
            echo <<<"HTML"
                    <div class="card" id="main-card">
                        <h2>Bonjour Vanéstarre</h2>
                        <form id="form-modif-config" action="/modifConfig">
                            <div id="div-form-title" class="text-line">
                                <p>Vous pouvez changer ci-dessous la configuration de votre site :</p>
                            </div>
                            <div id="div-form-nbr-messages-par-page" class="div-form">
                                <label for="nbr-messages-par-page">Nombre de messages affichés par page :</label>
                                <input type="number" id="nbr-messages-par-page" value=$this->default_nbr_messages_par_page>
                            </div>
                            <div id="div-form-nbr-min-react-pour-event" class="div-form">
                                <label for="nbr-min-react-pour-event">Nombre de reactions "love" minimum pour déclencher l'évènement "donation forcée" :</label>
                                <input type="number" id="nbr-min-react-pour-event" value=$this->default_nbr_min_react_pour_event>
                            </div>
                            <div id="div-form-nbr-max-react-pour-event" class="div-form">
                                <label for="nbr-max-react-pour-event">Nombre de reactions "love" maximum pour déclencher l'évènement "donation forcée" :</label>
                                <input type="number" id="nbr-max-react-pour-event" value=$this->default_nbr_max_react_pour_event>
                            </div>
                            <input type="submit" value="Valider" id="submit-config-change"> 
                        </form>
                    </div>
               HTML;
        }
    }
?>