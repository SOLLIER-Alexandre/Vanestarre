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
        private $email_adress;

        /**
         * AccountView constructor.
         * @param string $username The username of the user
         * @param string $email_adress The email adress of the user
         */
        public function __construct(string $username, string $email_adress) {
            $this->username = $username;
            $this->email_adress = $email_adress;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<"HTML"
                    <div class="card" id="main-card">
                        <h2>Compte Vanéstarre</h2>
                        <div id="div-username" class="text-line">
                            <h3>Votre Username : </h3>
                            <span>$this->username</span>
                        </div>
                        <div id="div-email" class="text-line">
                            <h3>Votre adresse e-mail : </h3>
                            <span>$this->email_adress</span>
                        </div>
                        <form id="form-modif-pwd" action="/ModifPwdView.php">
                            <div id="div-form-title" class="text-line">
                                <h3>Changez votre mot de passe : </h3>
                            </div>
                            <div id="form-old-pwd" class="div-form">
                               <label for="old-pwd">Ancien mot de passe :</label>
                               <input type="text" id="old-pwd">
                            </div>
                            <div id="form-new-pwd" class="div-form">
                               <label for="new-pwd">Nouveau mot de passe :</label>
                               <input type="text" id="new-pwd">
                            </div>
                            <div id="form-new-pwd-bis" class="div-form">
                               <label for="new-pwd-bis">Entrez à nouveau votre nouveau mot de passe :</label>
                               <input type="text" id="new-pwd-bis">
                            </div>
                            <input type="submit" value="Valider" id="submit-pwd-change"> 
                        </form>
                    </div>
               HTML;
        }
    }
?>