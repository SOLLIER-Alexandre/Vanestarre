<?php
    namespace Vanestarre\View;

    /**
     * Class RegisterView
     *
     * View for the create account page
     *
     * @author RADJA Samy
     * @package Vanestarre\View
     */
    class RegisterView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<'HTML'
                    <div class="card">
                        <h2>Créez un compte</h2> 
                                
                        <form action="/user/register" method="post">
                            <label>Identifiant :</label>
                            <input type="text" name="username" class="input-zone" autocomplete="username" maxlength="64" required/><br/>
                                               
                            <label>Email :</label>
                            <input type="email" name="email" class="input-zone" autocomplete="email" maxlength="64" required/><br/>
                            
                            <label>Mot de passe :</label>
                            <input type="password" name="mdp" class="input-zone" autocomplete="current-password" maxlength="128" required/><br/>
                            
                            <input type="submit" name="envoie" class="submit-button" value="Créer votre compte">
                        </form>
                        
                    <div/>
            HTML;

        }
    }
?>