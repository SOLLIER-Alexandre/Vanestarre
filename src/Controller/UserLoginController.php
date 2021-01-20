<?php
namespace Vanestarre\Controller;

use mysql_xdevapi\Exception;
use Vanestarre\Model\AuthDB;

/**
 * Class UserLoginController
 *
 * Controller for the login of the user
 *
 * @author RADJA Samy
 * @package Vanestarre\Controller
 */

class UserLoginController implements IController
{

    /**
     * UserLoginController constructor.
     */
    public function __construct() {
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function execute() {
        $username = $_POST['username'];
        $currentPassword = $_POST['mdp'];

        if (strlen($currentPassword)<=20 and strlen($username)<=15) {
            $login = new AuthDB();
            $userInfo = $login->get_user_data($username);
            $hashedPassword = $userInfo->get_password();
            if (password_verify ($currentPassword, $hashedPassword)) {
                session_start();
                $_SESSION["current_user"] = $username;
                header('Location: /');
            }
            else {
                header('Location: https://developer.mozilla.org/fr/docs/Web/HTTP/Status/400');
            }

        }
    }

    /**
     * @inheritDoc
     */
    public function get_title(): string {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function get_stylesheets(): array {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function get_scripts(): array {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function needs_standard_layout(): bool {
        return false;
    }
}
?>