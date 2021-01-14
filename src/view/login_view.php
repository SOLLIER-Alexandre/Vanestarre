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
                    <article class="card">
                        <img src="https://i.ibb.co/2P3H0nK/Vfor-Vanessa2.png" alt="Logo Vanestarre" class="loginBox"><br/>
                        <p class="loginBox">Connectez vous, ou créez un compte !</p>
                        <input type="text" name="usernameEntry" class="loginBox"><br/>
                        <input type="text" name="passwordEntry" class="loginBox"><br/>
                    </article>
            
            HTML;
        }
    }
?>