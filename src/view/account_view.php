<?php
    require __DIR__ . '/iview.inc.php';

    /**
     * Class AccountView
     *
     * View for the account management page
     *
     * @author CHATEAUX Adrien
     */
    class AccountView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<'HTML'
                    <h1 id="title">Compte Vanéstarre</h1>
                    <div id="main_frame">                        
                        <div id="username_frame" class="frame">
                            <h2>Votre Username : </h2>
                            <p>Username</p>
                        </div>
                        <div id="mail_frame" class="frame">
                            <h2>Votre adresse e-mail : </h2>
                            <p>e-mail</p>
                        </div>
                            <button id="show_form_button" onclick="showForm()">Modifier votre mot de passe</button>
                        </div>
                        <div id="pwd_change_frame" class="frame">
                                <form id="form_modif_pwd" action="/modif_pwd_view.php">
                                    <label for="old_pwd">Ancien mot de passe :</label><br/>
                                    <input type="text" id="old_pwd"><br/><br/>
                                    <label for="new_pwd">Nouveau mot de passe :</label><br/>
                                    <input type="text" id="new_pwd"><br/><br/>
                                    <label for="verif_new_pwd">Entrez à nouveau votre nouveau mot de passe :</label><br/>
                                    <input type="text" id="verif_new_pwd"><br/><br/>
                                    <input type="submit" value="Valider" id="submit_pwd_change">                  
                                </form>
                            </div>
                    </div>
            HTML;
        }
    }
?>