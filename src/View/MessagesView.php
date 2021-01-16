<?php
    namespace Vanestarre\View;

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
        $messages_list = $messages->get_n_last_messages(2,0);
    }
}
?>