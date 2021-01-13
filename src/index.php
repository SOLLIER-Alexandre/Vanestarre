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
    if ($request_path === '/' || $request_path === '/index') {
        require_once __DIR__ . '/controller/home_controller.php';
        $controller = new HomeController();
    } else if ($request_path === '/account') {
        require_once __DIR__ . '/controller/account_controller.php';
        $controller = new AccountController();
    } else if ($request_path === '/search') {
        require_once __DIR__ . '/controller/search_controller.php';
        $controller = new SearchController();
    } else {
        require_once __DIR__ . '/controller/pnf_controller.php';
        $controller = new PNFController();
    }

    if (!is_null($controller)) {
        // Begin the page
        start_page($controller->getTitle() . ' – Vanéstarre', $controller->getStylesheets(), $controller->getScripts());
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