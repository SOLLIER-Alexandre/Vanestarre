<?php
    /**
     * Index file of the project, where all requests are routed
     *
     * @author SOLLIER Alexandre
     */

    require_once __DIR__ . '/utils.inc.php';

    $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $controller = null;

    // Route the request
    switch ($request_path) {
        case '/':
        case '/index':
            require_once __DIR__ . '/controller/home_controller.php';
            $controller = new HomeController();
            break;

        case '/account':
            require_once __DIR__ . '/controller/account_controller.php';
            $controller = new AccountController();
            break;

        case '/search':
            require_once __DIR__ . '/controller/search_controller.php';
            $controller = new SearchController();
            break;

        case '/login':
            require_once __DIR__ . '/controller/login_controller.php';
            $controller = new LoginController();
            break;

        default:
            require_once __DIR__ . '/controller/pnf_controller.php';
            $controller = new PNFController();
    }

    if (!is_null($controller)) {
        // Begin the page
        start_page($controller->get_title() . ' – Vanéstarre', $controller->get_stylesheets(), $controller->get_scripts());
        start_layout();

        // Execute the selected controller
        $controller->execute();

        // End the page
        end_layout();
        end_page();
    } else {
        // That shouldn't have happened?!
        header("Location: /");
    }
?>