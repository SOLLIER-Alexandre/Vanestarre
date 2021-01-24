<?php
    namespace Vanestarre\View;

    /**
     * Class UserPasswordForgottenView
     *
     * Controller for the confirmation of the password sent to reset the previous forgotten one
     *
     * @author RADJA Samy
     * @package Vanestarre\View
     */
        class UserPasswordForgottenView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<< 'HTML'
                    <div class="card">
                        <h2>Mail envoyé avec succès</h2>        
                        <hr>
                        
                        <p>Nous vous avons envoyé un mail si un compte y est associé.</p><br/>
                        <p>Veuillez suivre la procédure qui y est indiqué pour réinitialiser votre mot de passe.</p>

                        </form>                    
                    <div/>  

            HTML;
        }
    }
?>