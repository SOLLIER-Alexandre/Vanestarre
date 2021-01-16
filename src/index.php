<?php
    /**
     * Index file of the project, where all requests are routed
     *
     * @author SOLLIER Alexandre
     */

    require __DIR__ . '/utils.inc.php';

    $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $controller = null;

    // Register autoloader for MVC classes, following https://www.php-fig.org/psr/psr-4/
    spl_autoload_register(function ($class) {
        // Check that the class begins with the right vendor namespace
        $vendorNamespace = 'Vanestarre\\';
        if (strncmp($class, $vendorNamespace, strlen($vendorNamespace)) !== 0) {
            return;
        }

        $classWithoutVendor = substr($class, strlen($vendorNamespace));
        require __DIR__ . '/' . str_replace('\\', '/', $classWithoutVendor) . '.php';
    });

    // Route the request
    switch ($request_path) {
        case '/':
        case '/home':
            $controller = new Vanestarre\Controller\HomeController();
            break;

        case '/account':
            $controller = new Vanestarre\Controller\AccountController();
            break;

        case '/search':
            $controller = new Vanestarre\Controller\SearchController();
            break;

        case '/login':
            $controller = new Vanestarre\Controller\LoginController();
            break;

        case '/createAccount':
            $controller = new Vanestarre\Controller\CreateAccountController();
            break;

        case '/postMessage':
            $controller = new Vanestarre\Controller\PostMessageController();
            break;

        case '/messages':
            $controller = new Vanestarre\Controller\MessagesController();
            break;

        default:
            $controller = new Vanestarre\Controller\PNFController();
    }

    if (!is_null($controller)) {
        // Begin the common page if needed
        if ($controller->needs_standard_layout()) {
            start_page($controller->get_title() . ' – Vanéstarre', $controller->get_stylesheets(), $controller->get_scripts());
            start_layout();
        }

        // Execute the selected Controller
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