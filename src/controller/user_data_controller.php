<?php
require_once __DIR__ . '/icontroller.inc.php';

/**
 * Class UserDataController
 *
 * Controller for the treatment of user data
 *
 * @author RADJA Samy
 */
class UserData implements IController
{

    /**
     * TemplateController constructor.
     */
    public function __construct() {
    }

    /**
     * @inheritDoc
     */
    public function execute() {
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