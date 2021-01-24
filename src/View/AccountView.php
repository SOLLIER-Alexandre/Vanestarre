<?php
    namespace Vanestarre\View;

    /**
     * Class AccountView
     *
     * View for the account management page
     *
     * @author CHATEAUX Adrien
     * @package Vanestarre\View
     */
    class AccountView implements IView
    {
        /**
         * @var string $username The username of the user
         */
        private $username;

        /**
         * @var string $mail_adress The mail adress of the user
         */
        private $email;

        /**
         * @var bool $show_config_link True if we can show a link to the config page
         */
        private $show_config_link;

        /**
         * @var int|null $error_message_id ID of the error message to print
         */
        private $error_message_id;

        /**
         * AccountView constructor.
         */
        public function __construct() {
            $this->username = '';
            $this->email = '';
            $this->show_config_link = false;
            $this->error_message_id = null;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents(): void {
            if (isset($this->error_message_id)) {
                $this->echo_password_message_card();
            }

            $this->echo_account_card();

            if ($this->show_config_link) {
                $this->echo_config_link();
            }
        }

        /**
         * Outputs the password change confirmation/error message card
         */
        private function echo_password_message_card(): void {
            echo <<<HTML
                    <!-- Password change message card -->
                    <div class="card">
                        <h2 class="password-message-title"><span class="material-icons unselectable">info</span> Mot de passe</h2>

            HTML;

            // Output the correct message
            switch ($this->error_message_id) {
                case 0:
                    echo '            <p>Le mot de passe a été changé avec succès !</p>' . PHP_EOL;
                    break;

                case 2:
                    echo '            <p>Le nouveau mot de passe et sa confirmation ne correspondent pas</p>' . PHP_EOL;
                    break;

                case 3:
                    echo '            <p>Le mot de passe actuel est incorrect</p>' . PHP_EOL;
                    break;

                default:
                    echo '            <p>Une erreur inconnue s\'est produite</p>' . PHP_EOL;
            }

            echo '        </div>' . PHP_EOL;
        }

        /**
         * Outputs the account details card, with a form for changing password
         */
        private function echo_account_card(): void {
            echo <<<HTML
                    <!-- Account card -->
                    <div class="card">
                        <h2>Compte Vanéstarre</h2>
                        
                        <div class="text-line">
                            <h3>Votre nom d'utilisateur : </h3>
                            <p>$this->username</p>
                        </div>
                        
                        <div class="text-line">
                            <h3>Votre adresse e-mail : </h3>
                            <p>$this->email</p>
                        </div>
                        
                        <!-- Form for changing password -->
                        <form id="form-modif-pwd" action="/user/passwordUpdate" method="post">
                            <div class="text-line">
                                <h3>Changez votre mot de passe : </h3>
                            </div>
                            
                            <div class="div-form">
                               <label for="old-pwd">Mot de passe actuel :</label>
                               <input type="password" id="old-pwd" name="oldPassword" autocomplete="current-password" maxlength="128" required>
                            </div>
                            
                            <div class="div-form">
                               <label for="new-pwd">Nouveau mot de passe :</label>
                               <input type="password" id="new-pwd" name="newPassword" autocomplete="new-password" maxlength="128" required>
                            </div>
                            
                            <div class="div-form">
                               <label for="new-pwd-bis">Confirmation du nouveau mot de passe :</label>
                               <input type="password" id="new-pwd-bis" name="newPasswordConfirmation" autocomplete="new-password" maxlength="128" required>
                            </div>
                            
                            <input type="submit" value="Valider" id="submit-pwd-change"> 
                        </form>
                    </div>

               HTML;
        }

        /**
         * Outputs a link to the config page
         */
        private function echo_config_link(): void {
            echo <<<HTML
                    <!-- Config card -->
                    <div class="card">
                        <h2>Configuration du site</h2>
                        
                        <div id="config-link-container">
                            <span class="material-icons unselectable">arrow_forward</span>
                            <a href="/config">Cliquez ici pour configurer votre site internet</a>
                        </div>
                    </div>

               HTML;
        }

        /**
         * @param string $username New username
         */
        public function set_username(string $username): void {
            $this->username = $username;
        }

        /**
         * @param string $email New email address
         */
        public function set_email(string $email): void {
            $this->email = $email;
        }

        /**
         * @param bool $show_config_link New show config link state
         */
        public function set_show_config_link(bool $show_config_link): void {
            $this->show_config_link = $show_config_link;
        }

        /**
         * @param int|null $error_message_id New error message ID
         */
        public function set_error_messageId(?int $error_message_id): void {
            $this->error_message_id = $error_message_id;
        }
    }
?>