<?php
    namespace Vanestarre\View;

    use Vanestarre\Model\Messages;

    /**
     * Class MessagesView
     *
     * View for a template page
     *
     * @author DEUDON Eugénie
     * @package Vanestarre\View
     */
    class MessagesView implements IView
    {
        /**
         * @inheritDoc
         */
        public function echo_contents() {
            $messages = new MessagesDB;
            $messages_list = $messages->get_n_last_messages(2, 0);
        }
    }
?>