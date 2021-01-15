<?php
require_once __DIR__ . '/icontroller.inc.php';
require_once __DIR__ . '/../view/messages_view.php';

/**
 * Class MessagesController
 *
 * Controller for a template page
 *
 * @author DEUDON Eugénie
 */
class MessagesController implements IController
{
    /**
     * @var MessagesView View associated with this controller
     */
    private $view;

    /**
     * TemplateController constructor.
     */
    public function __construct() {
        $this->view = new MessagesView();
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
        return 'Messages';
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
        return true;
    }
}
?>