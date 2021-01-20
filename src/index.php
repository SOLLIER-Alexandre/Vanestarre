<?php
    /**
     * Index file of the project, where all requests are routed
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre
     */

    namespace Vanestarre;

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
            $controller = new Controller\HomeController();
            break;

        case '/account':
            $controller = new Controller\AccountController();
            break;

        case '/search':
            $controller = new Controller\SearchController();
            break;

        case '/login':
            $controller = new Controller\LoginController();
            break;

        case '/createAccount':
            $controller = new Controller\CreateAccountController();
            break;

        case '/postMessage':
            $controller = new Controller\PostMessageController();
            break;

        case '/deleteMessage':
            $controller = new Controller\DeleteMessageController();
            break;

        case '/register':
            $controller = new Controller\RegisterController();
            break;

        default:
            $controller = new Controller\PNFController();
    }

    if (!is_null($controller)) {
        session_start();

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