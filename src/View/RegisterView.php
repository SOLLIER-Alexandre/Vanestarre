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
         * @var int|null $err_id ID of the err to print a message for
         */
        private $err_id;

        /**
         * @param int|null $err_id setter
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
                            <!-- Registration error message card -->
                            <div class="error-text">
                                <span class="material-icons alert">alert</span>

            HTML;

            // Output the correct message
            switch ($this->err_id) {
                case 1:
                    echo '                    <p>Votre mot de passe est trop court (5 caractères minimum)</p>' . PHP_EOL;
                    break;

                case 2:
                    echo '                    <p>L\' email est invalide</p>' . PHP_EOL;
                    break;

                case 3:
                    echo '                    <p>L\' username ou l\' email a déjà été utilisé</p>' . PHP_EOL;
                    break;

                case 4:
                    echo '                    <p>Erreur lors de l\' inscription. Veuillez réessayer</p>' . PHP_EOL;
                    break;

                default:
                    echo '                    <p>Une erreur inconnue s\' est produite. Veuillez réessayer</p>' . PHP_EOL;
                    break;
            }

            echo '                </div>' . PHP_EOL;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<< 'HTML'
                    <div class="card register-box">
                        <h2>Créez un compte</h2> 
                        <hr/>
                         
                        <!-- Form for creating a new account -->
                        <form action="/user/register" method="post">
                            <label>Identifiant :</label>
                            <input type="text" name="username" class="input-zone" autocomplete="username" maxlength="64" required/><br/>
                                               
                            <label>Email :</label>
                            <input type="email" name="email" class="input-zone" autocomplete="email" maxlength="64" required/><br/>
                            
                            <label>Mot de passe :</label>
                            <input type="password" name="mdp" class="input-zone" autocomplete="current-password" minlength="5" maxlength="128" required/><br/>

            HTML;
            //test if there is an error
            if(isset($this->err_id)) {
                //if there is an error, shows it
                $this->echo_error();
            }
            echo <<<'HTML'
            
                            <input type="submit" name="envoie" class="submit-button" value="Créer le compte">
                        </form>                       
                    </div>

            HTML;
        }
    }
?>