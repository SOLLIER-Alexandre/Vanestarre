<?php
    require_once __DIR__ . '/iview.inc.php';

    /**
     * Class HomeView
     *
     * View for the home page (website index)
     *
     * @author SOLLIER Alexandre
     */
    class HomeView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            echo <<<'HTML'
            <div class="card">
                <p class="post-title">Vanéstarre • Posté il y a 13h</p>
                <p class="post-message">eske vou konéssé twitch prim xDDDDDDDD</p>
            </div>
            
            <div class="card">
                <p class="post-title">Vanéstarre • Posté il y a 16h</p>
                <p class="post-message">yo lé besta g lancé le rézo cmt ça va xoxoxo</p>
            </div>

            HTML;

        }
    }

?>