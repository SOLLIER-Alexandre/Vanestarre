<?php
    function start_page($title = 'Vanestarre', $stylesheets = [], $scripts = [])
    {
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

        foreach ($stylesheets as $stylesheet) {
            echo '<link rel="stylesheet" href="' . $stylesheet . '">';
        }

        foreach ($scripts as $script) {
            echo '<script src="' . $script . '" async></script>';
        }

        echo <<<EOL
        </head>
        
        <body>

        EOL;
    };

    function end_page() {
        echo <<<'EOL'
        </body>
        
        </html>
        EOL;
    }

    function start_layout() {
        echo <<<'EOL'
            <header>
                <a href="/" class="title">Vanestarre</a>
            </header>
            
            <main>

        EOL;
    }

    function end_layout() {
        echo <<<'EOL'
            </main>

        EOL;
    }
?>