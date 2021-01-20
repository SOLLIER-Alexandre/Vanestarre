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
                    <div class="login-box">
                        <img src="https://i.ibb.co/2P3H0nK/Vfor-Vanessa2.png" alt="Logo Vanestarre" class="login-image"><br/>
                        <p>Connectez vous, ou créez un compte !</p>
                        <button class="login-button" id="login-input-trigger">Login</button><br/>
                        <form action="/" method="post" id="login-form">
                            <input type="" style="color: black" maxlength="15" required>
                            <input type="password" style="color: black" maxlength="20" required>
                            <input type="submit" name="connection" value="Se connecter">
                        </form>
                        <a href="/createAccount" class="create-account-button">Create an account</a><br/>
                    </div>
            
            HTML;
        }
    }
?>