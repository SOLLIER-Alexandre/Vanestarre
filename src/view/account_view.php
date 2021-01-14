<?php
    require_once __DIR__ . '/iview.inc.php';

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
                    <h1>Compte Vanéstarre</h1>
                    <h2>Votre Username : </h2>
                    <div>Username</div>
                    <h2>Votre adresse e-mail : </h2>
                    <div>e-mail</div>
                    <h2>Votre mot de passe : </h2>
                    <div>Et non lol, on est pas des débiles ici, par contre pour le reset, ça se passe ici :</div>
                    <button id="show_form_button" onclick="showForm()">Modifier votre mot de passe</button>
                    <form id="form_modif_pwd" action="/modif_pwd_view.php">
                        <label for="old_pwd">Ancien mot de passe :</label><br/>
                        <input type="text" id="old_pwd"><br/><br/>
                        <label for="new_pwd">Nouveau mot de passe :</label><br/>
                        <input type="text" id="new_pwd"><br/><br/>
                        <label for="verif_new_pwd">Entrez à nouveau votre nouveau mot de passe :</label><br/>
                        <input type="text" id="verif_new_pwd"><br/><br/>
                        <input type="submit" value="Valider">                  
                    </form>

            HTML;
        }
    }

?>