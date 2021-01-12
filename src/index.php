<?php
    require_once 'utils.inc.php';

    $request_path = parse_url($_SERVER['REQUEST_URI'])['path'];
    $page_title = 'Vanéstarre';
    $controller_path = 'controller/404.php';

    // Route the request
    if ($request_path === '/' || $request_path === '/index') {
        $page_title = 'Accueil - ' . $page_title;
        $controller_path = 'controller/home.php';
    } else if ($request_path === '/account') {
        $page_title = 'Compte - ' . $page_title;
        $controller_path = 'controller/account.php';
    } else if ($request_path === '/search') {
        $page_title = 'Recherche - ' . $page_title;
        $controller_path = 'controller/search.php';
    } else {
        $page_title = 'Erreur - ' . $page_title;
    }

    start_page($page_title);
    start_layout();

    require_once $controller_path;

    end_layout();
    end_page();
?>