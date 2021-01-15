<?php
require_once __DIR__ . '/iview.inc.php';
require __DIR__ . '../model/messages.php';

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
        $messages = new Messages;
        echo $messages->get_n_last_messages(2,0);
    }
}
?>