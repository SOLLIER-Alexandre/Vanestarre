<?php
namespace Vanestarre\Controller;

/**
 * Class ModifConfigController
 *
 * Used to change the json config file
 *
 * @author CHATEAUX Adrien
 * @package Vanestarre\Controller
 */
class TemplateController implements IController
{
    /**
     * @var ModifConfigController View associated with this controller
     */
    private $view;

    /**
     * ModifConfigController constructor.
     */
    public function __construct() {
        $this->view = new ModifConfigControllerView();
    }

    /**
     * @inheritDoc
     */
    public function execute() {
        // Output the view contents
        $this->view->echo_contents();
    }

    /**
     * @inheritDoc
     */
    public function get_title(): string {
        return 'Modif Config';
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