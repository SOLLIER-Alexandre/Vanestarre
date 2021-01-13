<?php
require_once __DIR__ . '/icontroller.inc.php';

/**
 * Class TemplateController
 *
 * Controller for a template page
 *
 * @author RADJA Samy
 */
class TemplateController implements IController
{
    /**
     * @inheritDoc
     */
    public function execute() {
        require_once __DIR__ . '/../view/template_view.php';

        $view = new TemplateView();

        // Output the view contents
        $view->echo_contents();
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string {
        return 'Template';
    }

    /**
     * @inheritDoc
     */
    public function getStylesheets(): array {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getScripts(): array {
        return [];
    }
}
?>