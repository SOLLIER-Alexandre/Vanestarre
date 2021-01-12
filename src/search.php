<?php
    include 'utils.inc.php';

    start_page('Recherche – Vanéstarre');
    start_layout();

    echo '        <h1>Recherche Vanéstarre — ' . filter_input(INPUT_GET, 'query', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . '</h1>' . PHP_EOL;

    end_layout();
    end_page();
?>