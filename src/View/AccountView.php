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
         * @var bool $is_author True if the user is an author (we can show a link to the config page and not show a link to delete the account)
         */
        private $is_author;

        /**
         * @var int|null $status_id ID of the status to print a message for
         */
        private $status_id;

        /**
         * AccountView constructor.
         */
        public function __construct() {
            $this->username = '';
            $this->email = '';
            $this->is_author = false;
            $this->status_id = null;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents(): void {
            if (isset($this->status_id)) {
                // There's a status message to show
                $this->echo_password_message_card();
            }

            // Show cards for editing the account
            $this->echo_account_card();
            $this->echo_password_change_card();

            if ($this->is_author) {
                // Show link to the configuration page if user is authorized
                $this->echo_config_link();
            } else {
                // User is not an admin, allow them to delete their account
                $this->echo_account_deletion_card();
                $this->echo_account_deletion_confirm_dialog();
            }
        }

        /**
         * Outputs the password change confirmation/error message card
         */
        private function echo_password_message_card(): void {
            echo <<<HTML
                    <!-- Password change message card -->
                    <div class="card">
                        <h2 class="password-message-title"><span class="material-icons unselectable">info</span> Information</h2>

            HTML;

            // Output the correct message
            switch ($this->status_id) {
                case 1:
                    echo '            <p>Le mot de passe a été changé avec succès !</p>' . PHP_EOL;
                    break;

                case 2:
                    echo '            <p>Vos informations ont été changées avec succès !</p>' . PHP_EOL;
                    break;

                case 11:
                    echo '            <p>Le nouveau mot de passe et sa confirmation ne correspondent pas</p>' . PHP_EOL;
                    break;

                case 12:
                    echo '            <p>Le mot de passe actuel est incorrect</p>' . PHP_EOL;
                    break;

                case 30:
                    echo '            <p>Votre compte n\'a pas pu petre supprimé</p>' . PHP_EOL;
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
                        
                        <form action="/user/detailsUpdate" method="post">
                            <div class="div-form">
                                <label for="username-input">Votre nom d'utilisateur :</label>
                                <input type="text" id="username-input" name="username" value="$this->username" autocomplete="username" maxlength="64" required>
                            </div>
                            
                            <div class="div-form">
                                <label for="email-input">Votre adresse e-mail :</label>
                                <input type="email" id="email-input" name="email" value="$this->email" autocomplete="email" maxlength="64" required>
                            </div>
                            
                            <input type="submit" value="Valider" id="submit-pwd-change"> 
                        </form>
                    </div>

               HTML;
        }

        /**
         * Outputs the card for changing password
         */
        private function echo_password_change_card(): void {
            echo <<<'HTML'
                    <div class="card">
                        <!-- Form for changing password -->
                        <h2>Changez votre mot de passe :</h2>
                        
                        <form id="form-modif-pwd" action="/user/passwordUpdate" method="post">
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

        private function echo_account_deletion_card(): void {
            echo <<<HTML
                    <!-- Account deletion card -->
                    <div class="card">
                        <h2>Suppression du compte</h2>
                        
                        <p>Nous ne voulons pas vous voir partir...</p>
                        <p>Mais si vous le souhaitez réellement, vous pouvez le faire ici.</p>
                        <p id="delete-account-button" class="button-like unselectable" role="button" data-micromodal-trigger="modal-account-deletion"><span class="material-icons">delete</span>Supprimer mon compte</p>
                    </div>
            HTML;
        }

        /**
         * Outputs the dialog for asking the user if they really want to delete their account
         * (But why would they?!)
         */
        private function echo_account_deletion_confirm_dialog(): void {
            echo <<<'HTML'
                    <!-- Modal for confirming account deletion -->
                    <div id="modal-account-deletion" class="modal" aria-hidden="true">
                        <div class="modal-overlay" tabindex="-1" data-micromodal-close>
                            <div class="modal-container card" role="dialog" aria-modal="true" aria-labelledby="modal-account-deletion-title">
                                <header class="dialog-header">
                                    <h2 id="modal-account-deletion-title">Suppression du compte Vanéstarre</h2>
                                </header>
                        
                                <div class="modal-confirm-content">
                                    <p>Êtes-vous sûr de vouloir supprimer votre compte ?</p>
                                    <p>Nous ne voulons pas vous voir partir :(</p>
                                    <p>Vanéstarre vous aime tous xoxoxoxo</p>
                                    <p><q>c vré</q> - Vanéstarre</p>
                                </div>
                                
                                <form class="modal-confirm-form" action="/user/delete" method="post">
                                    <input id="remove-message-image-id" name="messageId" type="hidden">
                                    <input class="input-button" type="button" value="Annuler" data-micromodal-close>
                                    <input class="input-button" type="submit" value="Supprimer">
                                </form>
                            </div>
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
         * @param bool $is_author New author state
         */
        public function set_is_author(bool $is_author): void {
            $this->is_author = $is_author;
        }

        /**
         * @param int|null $status_id New error message ID
         */
        public function set_status_id(?int $status_id): void {
            $this->status_id = $status_id;
        }
    }
?>