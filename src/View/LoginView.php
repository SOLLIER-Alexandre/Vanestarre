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
         * @var int|null $err_id ID of the err to print a message for
         */
        private $err_id;

        /**
         * @param int|null $err_id
         */
        public function set_err_id(?int $err_id): void
        {
            $this->err_id = $err_id;
        }

        /**
         * LoginView constructor.
         */
        public function __construct() {
            $this->err_id = null;
        }

        private function echo_error(): void {
            echo <<<HTML
                    <!-- Password change message card -->
                    <div class="error-text">
                        <span class="material-icons alert">alert</span>
            HTML;

            // Output the correct message
            switch ($this->err_id) {
                case 2:
                    echo '            <p>L\' identifiant ou le mot de passe est incorrect</p>' . PHP_EOL;
                    break;

                default:
                    echo '            <p>Une erreur inconnue s\'est produite. Veuillez réessayer</p>' . PHP_EOL;
                    break;
            }

            echo '        </div>' . PHP_EOL;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<'HTML'
                    <div class="card login-box">
                        <!-- Website icon -->
                        <img src="https://i.ibb.co/2P3H0nK/Vfor-Vanessa2.png" alt="Logo Vanestarre" class="login-image">
                        <p>Connectez vous, ou créez un compte !</p>
                                       
                        <!-- Form for logging in -->
                        <form action="/user/login" method="post" class="login-form">
                            <input type="text" class="input-zone" name="username" placeholder="Username" autocomplete="username" maxlength="64" required>
                            <input type="password" class="input-zone" name="mdp" placeholder="Password" autocomplete="current-password" maxlength="128" required>
            

            HTML;

            echo '                <a href="/passwordForgotten" class="forgotten-password">Mot de passe oublié ?</a>' . PHP_EOL;

            if (isset($this->err_id)) {
                //if there is an error, shows it
                $this->echo_error();
            }

            echo <<<'HTML'
            
                            <input type="submit" class="login-button" value="Connexion">
                        </form>
                        
                        <hr/>
                        
                        <!-- Link to the register page -->
                        <a href="/register" class="create-account-button">Créer un compte</a>
                    </div>

            HTML;
        }
    }
?>