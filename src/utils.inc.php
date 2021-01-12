<?php
    /**
     * Echoes the start of a regular HTML document
     *
     * @param string $title The title of the page
     * @param array $stylesheets Array of stylesheets to include in the page
     * @param array $scripts Array of scripts to include in the page
     */
    function start_page($title = 'Vanestarre', $stylesheets = [], $scripts = [])
    {
        // Start of the <head>
        echo <<<EOL
        <!doctype html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <meta name="Description" content="Page d'accueil du blog de Vanéstarre">
            <title>$title</title>
            <link rel="stylesheet" href="styles/common.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
            <script src="scripts/common.js" async></script>

        EOL;

        // Echo all the stylesheets to the document
        foreach ($stylesheets as $stylesheet) {
            echo '<link rel="stylesheet" href="' . $stylesheet . '">';
        }

        // Echo all the scripts to the document
        foreach ($scripts as $script) {
            echo '<script src="' . $script . '" async></script>';
        }

        // End of the <head>, begin a <body>
        echo <<<EOL
        </head>
        
        <body>

        EOL;
    }

    ;

    /**
     * Echoes the end of a regular HTML document (started with the start_page() function)
     */
    function end_page()
    {
        // End the <body> and <html> tags
        echo <<<'EOL'
        </body>
        
        </html>
        EOL;
    }

    /**
     * Echoes the start of the standard project layout
     * This contains the page header with the website title, a search box and an account manager
     *
     * @param string|null $account_name Name of the account to show. Pass null for the default string.
     */
    function start_layout($account_name = null)
    {
        // Add the standard <header>, and begin a <main> block
        echo <<<'EOL'
            <header id="header">
                <a href="/" id="page-title" class="hidden-on-search">Vanéstarre</a>
                <div class="header-right-content">
                    <form id="search-form" method="get" action="search.php">
                        <input id="search-box" name="query" type="search" placeholder="Recherche...">
                    </form>
                    
                    <span id="search-btn" class="material-icons unselectable text-button hidden-on-search">search</span>
                    <a href="account.php" id="account-link" class="text-button hidden-on-search">
                        <span class="material-icons unselectable">account_circle</span>
        EOL;

        if ($account_name === null) {
            echo 'Invité';
        } else {
            echo $account_name;
        }

        echo <<<'EOL'
        
                    </a>
                </div>
            </header>
            
            <main>

        EOL;
    }

    /**
     * Echoes the end of the standard project layout (started with the start_layout() function)
     */
    function end_layout()
    {
        // End the <main> block
        echo <<<'EOL'
            </main>

        EOL;
    }

?>