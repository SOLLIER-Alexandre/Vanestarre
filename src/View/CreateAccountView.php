<?php
    namespace Vanestarre\View;

    /**
     * Class CreateAccountView
     *
     * View for the create account page
     *
     * @author RADJA Samy
     * @package Vanestarre\View
     */
    class CreateAccountView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<'HTML'
                    <div class="create-account-box">
                        <h2>Créez un compte</h2>        
                                
                        <form action="/register" method="post">
                            <label>Identifiant :</label>
                            <input type="text" name="username" class="input-zone" style="color: black" autocomplete="username" maxlength="15" required/><br/>
                                               
                            <label>Email :</label>
                            <input type="email" name="email" class="input-zone" style="color: black" autocomplete="email" maxlength="25" required/><br/>
                            
                            <label>Mot de passe :</label>
                            <input type="password" name="mdp" class="input-zone" style="color: black" autocomplete="current-password" maxlength="20" required/><br/>
                            
                            <input type="submit" name="envoie" class="submit-button" value="Créer votre compte">
                        </form>
                        
                    <div/>
            HTML;

        }
    }
?>