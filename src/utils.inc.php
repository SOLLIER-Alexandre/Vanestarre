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
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
     */
    function start_layout()
    {
        // Add the standard <header>, and begin a <main> block
        echo <<<'EOL'
            <header>
                <a href="/" class="title">Vanestarre</a>
                <div class="header_right_content">
                    <input class="search_box" type="search" placeholder="Recherche...">
                    <span class="material-icons unselectable text_button">search</span>
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