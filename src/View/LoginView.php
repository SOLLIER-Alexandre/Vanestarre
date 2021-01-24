<?php
    namespace Vanestarre\View;

    /**
     * Class LoginView
     *
     * View for the login page
     *
     * @author RADJA Samy
     * @package Vanestarre\View
     */
    class LoginView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<'HTML'
                    <div class="card login-box">
                        <img src="https://i.ibb.co/2P3H0nK/Vfor-Vanessa2.png" alt="Logo Vanestarre" class="login-image"><br/>
                        <p>Connectez vous, ou créez un compte !</p>
                        
                        <button class="login-button" id="login-input-trigger">Login</button><br/>
                        <form action="/user/login" method="post" id="login-form">
                            <input type="text" name="username" autocomplete="username" maxlength="64" required>
                            <input type="password" name="mdp" autocomplete="current-password" maxlength="128" required>
                            <input type="submit" name="connexion" value="Se connecter">
                        </form>
                        <a href="/us" class="forgotten-password">mot de passe oublié ?</a> 
                        
                        <a href="/register" class="create-account-button">Create an account</a><br/>
                    </div>
            
            HTML;
        }
    }
?>