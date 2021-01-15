<?php
require_once __DIR__ . '/iview.inc.php';

/**
 * Class CreateAccountView
 *
 * View for the create account page
 *
 * @author RADJA Samy
 */
class CreateAccountView implements IView
{
    /**
     * @inheritDoc
     */
    public function echo_contents() {
        echo '        <h1>Template Vanéstarre</h1>' . PHP_EOL;
    }
}
?>