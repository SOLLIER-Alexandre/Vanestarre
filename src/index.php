<?php
    include 'utils.inc.php';

    start_page('Accueil - Vanéstarre');
    start_layout();

    for ($x = 0; $x < 100; $x++) {
        echo '        <p>Hello, World!</p>' . PHP_EOL;
    }

    end_layout();
    end_page();
?>