<?php
require_once __DIR__ . '/iview.inc.php';

/**
 * Class TemplateView
 *
 * View for a template page
 *
 * @author RADJA Samy
 */
class TemplateView implements IView
{
    /**
     * @inheritDoc
     */
    public function echo_contents() {
        echo '        <h1>Template Vanéstarre</h1>' . PHP_EOL;
    }
}
?>