<?php
    namespace Vanestarre\View;

    /**
     * Class PasswordForgottenView
     *
     * View for for getting a new password via mail when the previous one is forgotten
     *
     * @author RADJA Samy
     * @package Vanestarre\View
     */
    class PasswordForgottenView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<< 'HTML'
                    <div class="card">
                        <h2>Mot de passe oublié ?</h2>        
                        <hr>
                        <p>Vous avez oublié votre mot de passe ?</p><br/>
                        <p>Indiquez l'addresse email avec laquelle vous avez créé votre compte pour réinitialiser votre mot de passe :</p>
                                
                        <form action="/user/passwordForgottenMessage" method="post">
                            <input type="text" name="mail" style="color: black" autocomplete="email" maxlength="64" required/><br/>                           
                            <input type="submit" name="reset" class="submit-button" value="Réinitialiser">
                        </form>                    
                    <div/>  

            HTML;
        }
    }
?>