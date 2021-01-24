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
         * AccountView constructor.
         */
        public function __construct() {
            $this->username = '';
            $this->email = '';
            $this->show_config_link = false;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents(): void {
            $this->echo_account_card();
        }

        private function echo_account_card(): void {
            echo <<<HTML
                    <!-- Account card -->
                    <div class="card">
                        <h2>Compte Vanéstarre</h2>
                        
                        <div class="text-line">
                            <h3>Votre nom d'utilisateur : </h3>
                            <span>$this->username</span>
                        </div>
                        
                        <div class="text-line">
                            <h3>Votre adresse e-mail : </h3>
                            <span>$this->email</span>
                        </div>
                        
                        <!-- Form for changing password -->
                        <form id="form-modif-pwd" action="/user/passwordUpdate" method="post">
                            <div class="text-line">
                                <h3>Changez votre mot de passe : </h3>
                            </div>
                            
                            <div class="div-form">
                               <label for="old-pwd">Ancien mot de passe :</label>
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
    }
?>