<?php
    require __DIR__ . '/IView.php';

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
                        <a href="" class="login-button">Login</a><br/>
                        <a href="/createAccount" class="create-account-button">Create an account</a><br/>
                    </div>
            
            HTML;
        }
    }
?>