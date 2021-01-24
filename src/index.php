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

        case '/message/post':
            $controller = new Controller\Message\MessagePostController();
            break;

        case '/message/delete':
            $controller = new Controller\Message\MessageDeleteController();
            break;

        case '/message/removeImage':
            $controller = new Controller\Message\MessageRemoveImageController();
            break;

        case '/message/reaction/set':
            $controller = new Controller\Message\Reaction\MessageReactionSetController();
            break;

        case '/message/reaction/unset':
            $controller = new Controller\Message\Reaction\MessageReactionUnsetController();
            break;

        case '/user/register':
            $controller = new Controller\User\UserRegisterController();
            break;

        case '/user/login':
            $controller = new Controller\User\UserLoginController();
            break;

        case '/user/logout':
            $controller = new Controller\User\UserLogoutController();
            break;

        case '/user/passwordUpdate':
            $controller = new Controller\User\UserPasswordUpdateController();
            break;

        case '/user/passwordForgotten':
            $controller = new Controller\User\UserPasswordForgottenController();
            break;

        case '/config/update':
            $controller = new Controller\ModifConfigController();
            break;

        case '/register':
            $controller = new Controller\RegisterController();
            break;

        case '/login':
            $controller = new Controller\LoginController();
            break;

        case '/account':
            $controller = new Controller\AccountController();
            break;

        case '/config':
            $controller = new Controller\VanestarreConfigController();
            break;

        case '/unauthorized':
            $controller = new Controller\Error\UnauthorizedController();
            break;

        default:
            $controller = new Controller\Error\PageNotFoundController();
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