<?php
    require_once __DIR__ . '/iview.inc.php';

    /**
     * Class LoginView
     *
     * View for the login page
     *
     * @author RADJA Samy
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
                        <input type="button" name="loginToAccount" value="Login" class="login-button"><br/>
                        <input type="button" name="createNewAccount" value="Create an account" class="create-account-button"><br/>
                    </div>
            
            HTML;
        }
    }
?>