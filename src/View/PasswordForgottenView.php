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
         * @var bool $show_confirmation True if the mail with the new temporary password has been sent
         */
        private $show_confirmation;

        /**
         * PasswordForgottenView constructor.
         */
        public function __construct() {
            $this->show_confirmation = false;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents() {
            if ($this->show_confirmation) {
                echo <<< 'HTML'
                    <div class="card">
                        <h2>Mail envoyé avec succès</h2>        
                        <hr>
                        
                        <p>Nous vous avons envoyé un mail si un compte y est associé.</p><br/>
                        <p>Veuillez suivre la procédure qui y est indiqué pour réinitialiser votre mot de passe.</p>
                    <div/>  
                HTML;
            } else {
                echo <<< 'HTML'
                    <div class="card">
                        <h2>Mot de passe oublié ?</h2>        
                        <p>Vous avez oublié votre mot de passe ?</p>
                        <p>Indiquez l'addresse email avec laquelle vous avez créé votre compte pour réinitialiser votre mot de passe :</p>
                                
                        <form action="/user/passwordForgottenMessage" method="post">
                            <input type="text" name="mail" autocomplete="email" maxlength="64" required/>                        
                            <input type="submit" name="reset" class="submit-button" value="Réinitialiser">
                        </form>                    
                    <div/>
                HTML;
            }
        }

        /**
         * @param bool $show_confirmation Show confirmation state
         */
        public function set_show_confirmation(bool $show_confirmation): void
        {
            $this->show_confirmation = $show_confirmation;
        }
    }
?>