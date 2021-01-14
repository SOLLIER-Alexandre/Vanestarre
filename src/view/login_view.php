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
            echo <<< 'HTML'
                <article class="card">
                    <img src="https://i.ibb.co/2P3H0nK/Vfor-Vanessa2.png" alt="Logo Vanestarre"><br/>
                    <input type="text" name="usernameEntry"><br/>
                    <input type="text" name="passwordEntry"><br/>
                </article>
            
            HTML;
        }
    }
?>