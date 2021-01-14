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
                    <article class="card">
                        <p class="post-title">Vanéstarre • Posté il y a 13h</p>
                        <p class="post-message">eske vou konéssé twitch prim xDDDDDDDD</p>
                        <img src="https://materializecss.com/images/sample-1.jpg" alt="Image du post de Vanéstarre">
                    </article>
                    
                    <article class="card">
                        <p class="post-title">Vanéstarre • Posté il y a 16h</p>
                        <p class="post-message">yo lé besta g lancé le rézo cmt ça va xoxoxo</p>
                    </article>

            HTML;

        }
    }

?>