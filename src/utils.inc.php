<?php
    /**
     * Utils for outputting a standard page
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre
     */

    namespace Vanestarre;

    use Vanestarre\Exception\DatabaseConnectionException;
    use Vanestarre\Model\AuthDB;

    /**
     * Echoes the start of a regular HTML document
     *
     * @param string $title The title of the page
     * @param array $stylesheets Array of stylesheets to include in the page
     * @param array $scripts Array of scripts to include in the page
     */
    function start_page($title = 'Vanéstarre', $stylesheets = [], $scripts = []) {
        // Start of the <head>
        echo <<<HTML
        <!doctype html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <meta name="Description" content="Page d'accueil du blog de Vanéstarre">
            <title>$title</title>
            
            <!-- Common stylesheets and script -->
            <link rel="stylesheet" href="/styles/common.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
            <script src="/scripts/common.js" async></script>
            
            <!-- Controller-specific stylesheets and scripts -->

        HTML;

        // Echo all the stylesheets to the document
        foreach ($stylesheets as $stylesheet) {
            echo '    <link rel="stylesheet" href="' . $stylesheet . '">' . PHP_EOL;
        }

        // Echo all the scripts to the document
        foreach ($scripts as $script) {
            echo '    <script src="' . $script . '" async></script>' . PHP_EOL;
        }

        // End of the <head>, begin a <body>
        echo <<<'HTML'
        </head>
        
        <body>

        HTML;
    }

    /**
     * Echoes the end of a regular HTML document (started with the start_page() function)
     */
    function end_page() {
        // End the <body> and <html> tags
        echo <<<'HTML'
        </body>
        
        </html>
        HTML;
    }

    /**
     * Echoes the start of the standard project layout
     * This contains the page header with the website title, a search box and an account manager
     */
    function start_layout() {
        // Add the standard <header>, and begin a <main> block
        echo <<<'HTML'
            <!-- Common page header -->
            <header id="header">
                <h1><a href="/" id="page-title" class="hidden-on-search">Vanéstarre</a></h1>
                <div class="header-right-content">
                    <form id="search-form" method="get" action="/home">
                        <input id="search-box" name="query" type="search" placeholder="Recherche...">
                    </form>
                    
                    <span id="search-btn" class="material-icons unselectable button-like hidden-on-search">search</span>

        HTML;

        // Start session temporarily to get currently connected username
        session_start();

        try {
            // Get the logged in user
            $auth_db = new AuthDB();
            $logged_in_user = $auth_db->get_logged_in_user();
        } catch (DatabaseConnectionException $e) {
            // That doesn't smell good, let $logged_in_user be null
        }

        session_write_close();

        if (isset($logged_in_user)) {
            $logged_in_username = filter_var($logged_in_user->get_username(), FILTER_SANITIZE_SPECIAL_CHARS);
            echo <<<HTML
                        <a href="/account" id="account-link" class="button-like hidden-on-search" role="button">
                            <span class="material-icons unselectable">account_circle</span> $logged_in_username
                        </a>
                        <a id="logout-button" class="material-icons unselectable button-like hidden-on-search" href="/user/logout">logout</a>

            HTML;
        } else {
            echo <<<HTML
                        <a href="/login" id="account-link" class="button-like hidden-on-search" role="button">
                            <span class="material-icons unselectable">account_circle</span> Invité
                        </a>

            HTML;
        }

        echo <<<'HTML'
                </div>
            </header>
            
            <main>

        HTML;
    }

    /**
     * Echoes the end of the standard project layout (started with the start_layout() function)
     */
    function end_layout() {
        // End the <main> block
        echo <<<'HTML'
            </main>

        HTML;
    }

    ?>