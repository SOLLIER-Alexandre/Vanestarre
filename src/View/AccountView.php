<?php
    namespace Vanestarre\View;

    /**
     * Class AccountView
     *
     * View for the account management page
     *
     * @author CHATEAUX Adrien
     * @package Vanestarre\View
     */
    class AccountView implements IView
    {
        /**
         * @var string $username The username of the user
         */
        private $username;

        /**
         * @var string $mail_adress The mail adress of the user
         */
        private $email_adress;

        /**
         * AccountView constructor.
         * @param string $username The username of the user
         * @param string $email_adress The email adress of the user
         */
        public function __construct(string $username, string $email_adress) {
            $this->username = $username;
            $this->email_adress = $email_adress;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<"HTML"
                    <h1 id="title">Compte Vanéstarre</h1>
                    <div id="main_frame">                        
                        <div id="username_frame" class="frame">
                            <h2>Votre Username : </h2>
                            <p>$this->username</p>
                        </div>
                        <div id="mail_frame" class="frame">
                            <h2>Votre adresse e-mail : </h2>
                            <p>$this->email_adress</p>
                        </div>
                            <button id="show_form_button" onclick="showForm()">Modifier votre mot de passe</button>
                            <div id="pwd_change_frame" class="frame">
                                <form id="form_modif_pwd" action="/modif_pwd_view.php">
                                    <div class="form_frame">
                                        <div>
                                            <label for="old_pwd">Ancien mot de passe :</label>
                                        </div>
                                        <div>
                                            <input type="text" id="old_pwd">
                                        </div>                                       
                                    </div>
                                    <div class="form_frame">
                                        <div>
                                            <label for="new_pwd">Nouveau mot de passe :</label>
                                        </div>
                                        <div>
                                            <input type="text" id="new_pwd">
                                        </div>
                                    </div>
                                    <div class="form_frame">
                                        <div>
                                            <label for="verif_new_pwd">Entrez à nouveau votre nouveau mot de passe :</label>
                                        </div>
                                        <div>
                                            <input type="text" id="verif_new_pwd">
                                        </div>
                                    </div>
                                    <div class="form_frame">
                                        <input type="submit" value="Valider" id="submit_pwd_change">             
                                    </div>     
                                </form>
                            </div>
                        </div>      
                    </div>
            HTML;
        }
    }
?>