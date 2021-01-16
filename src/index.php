<?php
    /**
     * Index file of the project, where all requests are routed
     *
     * @author SOLLIER Alexandre
     */

    require __DIR__ . '/utils.inc.php';

    $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $controller = null;

    // Route the request
    switch ($request_path) {
        case '/':
        case '/home':
            require __DIR__ . '/controller/HomeController.php';
            $controller = new HomeController();
            break;

        case '/account':
            require __DIR__ . '/controller/AccountController.php';
            $controller = new AccountController();
            break;

        case '/search':
            require __DIR__ . '/controller/SearchController.php';
            $controller = new SearchController();
            break;

        case '/login':
            require __DIR__ . '/controller/LoginController.php';
            $controller = new LoginController();
            break;

        case '/createAccount':
            require __DIR__ . '/controller/CreateAccountController.php';
            $controller = new CreateAccountController();
            break;

        case '/postMessage':
            require __DIR__ . '/controller/PostMessageController.php';
            $controller = new PostMessageController();
            break;

        case '/messages':
            require __DIR__ . '/controller/MessagesController.php';
            $controller = new MessagesController();
            break;

        default:
            require __DIR__ . '/controller/PNFController.php';
            $controller = new PNFController();
    }

    if (!is_null($controller)) {
        // Begin the common page if needed
        if ($controller->needs_standard_layout()) {
            start_page($controller->get_title() . ' – Vanéstarre', $controller->get_stylesheets(), $controller->get_scripts());
            start_layout();
        }

        // Execute the selected controller
        $controller->execute();

        // End the common page if needed
        if ($controller->needs_standard_layout()) {
            end_layout();
            end_page();
        }
    } else {
        // That shouldn't have happened?!
        header("Location: /");
    }
?>