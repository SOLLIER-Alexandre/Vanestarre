<?php
require_once __DIR__ . '/iview.inc.php';

/**
 * Class MessagesView
 *
 * View for a template page
 *
 * @author DEUDON Eugénie
 */
class MessagesView implements IView
{
    /**
     * @inheritDoc
     */
    public function echo_contents() {
        echo '        <h1>Template Vanéstarre</h1>' . PHP_EOL;
    }
}
?>