<?php
    namespace Vanestarre\View;

    /**
     * Class ConfigView
     *
     * Config page for Vanestarre
     *
     * @author CHATEAUX Adrien
     * @package Vanestarre\View
     */
    class ConfigView implements IView
    {
        /**
         * @var int $messages_par_page The default value for the "nbr-messages-par-page" input
         */
        private $messages_par_page;

        /**
         * @var int $min_reaction_event The default value for the "nbr-min-react-pour-event" input
         */
        private $min_reaction_event;

        /**
         * @var int $max_reaction_event The default value for the "nbr-max-react-pour-event" input
         */
        private $max_reaction_event;

        /**
         * AccountView constructor.
         * @param int $messages_par_page The default value for the "nbr-messages-par-page" input
         * @param int $min_reaction_event The default value for the "nbr-min-react-pour-event" input
         * @param int $max_reaction_event The default value for the "nbr-max-react-pour-event" input
         */
        public function __construct(int $messages_par_page, int $min_reaction_event, int $max_reaction_event) {
            $this->messages_par_page = $messages_par_page;
            $this->min_reaction_event = $min_reaction_event;
            $this->max_reaction_event = $max_reaction_event;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents(): void {
            echo <<<HTML
                    <!-- Configuration card -->
                    <div class="card" id="configuration-card">
                        <h2>Bonjour Vanéstarre</h2>
                        
                        <form id="form-modif-config" action="/config/update">
                            <div class="text-line">
                                <p>Vous pouvez changer ci-dessous la configuration de votre site :</p>
                            </div>
                            
                            <div class="div-form">
                                <label for="nbr-messages-par-page">Nombre de messages affichés par page :</label>
                                <input type="number" id="nbr-messages-par-page" min="1" value=$this->messages_par_page name="nbr_messages_par_page">
                            </div>
                            
                            <div class="div-form">
                                <label for="nbr-min-react-pour-event">Nombre de reactions "love" minimum pour déclencher l'heureux évènement :</label>
                                <input type="number" id="nbr-min-react-pour-event" min="1" value=$this->min_reaction_event name="nbr_min_react_pour_event">
                            </div>
                            
                            <div class="div-form">
                                <label for="nbr-max-react-pour-event">Nombre de reactions "love" maximum pour déclencher l'heureux évènement :</label>
                                <input type="number" id="nbr-max-react-pour-event" min="1" value=$this->max_reaction_event name="nbr_max_react_pour_event">
                            </div>
                            
                            <input type="submit" value="Valider" id="submit-config-change"> 
                        </form>
                    </div>
                    
                    <!-- Member management card -->
                    <div class="card">
                        <h2>Gestion des membres</h2>                            
                        <div class="text-line">
                            <p>Vous avez accès ci-dessous à l'ensemble des membres de Vanéstarre :</p>
                        </div>
                        
                        <div id="members-table">
                            <!-- example line for the table -->
                            <div class="table-line">
                                <div class="shown-line">
                                    <div class="text-box">
                                        <p>example_username</p>
                                    </div>
                                    <div class="text-box">
                                        <p>example_email_address</p>
                                    </div>
                                    <div class="arrow-down">
                                        <span class="material-icons button-like unselectable">keyboard_arrow_down</span>
                                    </div>
                                </div>   
                                <div class="hidden-line">
                                    <form id="form-modif-membre" action="/config/changemember">
                                        <input type="text" id="new-username" name="new-username">
                                        <input type="text" id="new-email-adress" name="new-email-adress">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

            HTML;
        }
    }
?>