<?php

    namespace Vanestarre\View;

    use DateTimeImmutable;
    use Vanestarre\Model\Message;

    /**
     * Class HomeView
     *
     * View for the home page (website index)
     *
     * @author SOLLIER Alexandre
     * @package Vanestarre\View
     */
    class HomeView implements IView
    {
        /**
         * @var int $current_page The current page number
         */
        private $current_page;

        /**
         * @var int $page_count The number of pages to show
         */
        private $page_count;

        /**
         * @var array $messages Array of messages this View has
         */
        private $messages;

        /**
         * @var string Contains the query if the search bar has been used
         */
        private $search_query;

        /**
         * @var bool $is_connected True if we can show stuff for connected users
         */
        private $is_connected;

        /**
         * @var bool $has_authoring_tools True if we can show authoring tools to the user
         */
        private $has_authoring_tools;

        /**
         * @var bool $error_fetching_messages True if we have to show an error messages because we couldn't fetch messages
         */
        private $error_fetching_messages;

        /**
         * @var int|null $error ID of the error that occurred, if there was one
         */
        private $error;

        /**
         * HomeView constructor.
         */
        public function __construct() {
            $this->current_page = 1;
            $this->page_count = 1;
            $this->messages = array();
            $this->search_query = null;
            $this->has_authoring_tools = false;
            $this->error_fetching_messages = false;
            $this->error = null;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents(): void {
            // If there was an error, just output it
            if ($this->error_fetching_messages) {
                $this->echo_error_fetching_message();
                return;
            }

            // Output error box if one occurred
            if (!is_null($this->error)) {
                $this->echo_error_box();
            }

            if ($this->has_authoring_tools) {
                // Output message writer if connected user is an author
                $this->echo_message_writer();
            }

            // Output every message
            foreach ($this->messages as $message) {
                $this->echo_message($message);
            }

            // Output page selector if there are more than one page
            if ($this->page_count > 1) {
                $this->echo_pager();
            }

            // Output dialogs
            if ($this->has_authoring_tools) {
                // Output message editing dialogs if the connected user is an author
                $this->echo_edit_message_dialog();
                $this->echo_delete_message_dialog();
                $this->echo_delete_message_image_dialog();
            }

            if ($this->is_connected) {
                // Output donation dialog for connected users
                $this->echo_donation_dialog();
            }
        }

        /**
         * Outputs the error box if one occurred
         */
        private function echo_error_box(): void {
            // Begin error card
            echo '        <div class="card">' . PHP_EOL;
            echo '            <h2 id="error-box-title"><span class="material-icons">error</span> Une erreur est survenue</h2>' . PHP_EOL;

            // Check which error is this
            switch ($this->error) {
                case 1:
                case 2:
                    // Error while posting a message
                    echo '            <p>Votre message n\'a pas pu être posté</p>' . PHP_EOL;
                    break;

                case 10:
                    // Error while modifying a message
                    echo '            <p>Le message n\'a pas pu être modifié</p>' . PHP_EOL;
                    break;

                case 20:
                    // Error while uploading an image
                    echo '            <p>L\'image n\'a pas pu être uploadé</p>' . PHP_EOL;
                    break;

                case 21:
                case 22:
                    // Error while removing an image
                    echo '            <p>L\'image n\'a pas pu être supprimée</p>' . PHP_EOL;
                    break;

                default:
                    // Unknown error
                    echo '            <p>Mais elle est inconnue...</p>' . PHP_EOL;
            }

            // End error card
            echo '        </div>' . PHP_EOL;
        }

        /**
         * Outputs the form for message posting
         * @param string $form_id ID of the form to output
         * @param bool $is_edition_form Is this form for editing a message?
         */
        private function echo_message_post_form(string $form_id, bool $is_edition_form) {
            // Compute the base indentation for the generated code
            $base_indent = str_repeat(' ', $is_edition_form ? 24 : 12);

            echo $base_indent . '<form class="message-form" action="/message/post" method="post" enctype="multipart/form-data">' . PHP_EOL;

            // Output the hidden input containing the edited message ID if it's an edition form
            if ($is_edition_form) {
                echo $base_indent . '   <input id="edit-message-id" name="messageId" type="hidden">' . PHP_EOL;
            }

            // Yeah that looks horrible but generated code needed to be indented so...
            echo <<<HTML
            $base_indent   <textarea id="$form_id-text" placeholder="Postez un message" name="message"></textarea>
            $base_indent   <div class="message-form-buttons">
            $base_indent       <div>
            $base_indent           <span class="button-like unselectable beta-insert-button" role="button" data-for-textarea="$form_id-text">β</span>
            
            $base_indent           <input id="$form_id-file" class="message-form-file" type="file" name="image" accept="image/*">
            $base_indent           <label for="$form_id-file" class="material-icons unselectable button-like message-form-file-label">add_photo_alternate</label>
            $base_indent           <span class="material-icons unselectable button-like message-form-file-remove disabled" role="button" aria-disabled="true" data-for-input="$form_id-file">remove</span>
            $base_indent       </div>
            
            $base_indent       <div>
            $base_indent           <span class="message-length-counter" data-for-textarea="$form_id-text">50</span>
            $base_indent           <input class="send-message-button input-button" type="submit" value="Post" data-for-textarea="$form_id-text" disabled>
            $base_indent       </div>
            $base_indent   </div>
            $base_indent</form>

            HTML;
        }

        /**
         * Outputs the form for writing a message
         */
        private function echo_message_writer(): void {
            echo '        <!-- Form for writing a new message -->' . PHP_EOL;
            echo '        <div class="card">' . PHP_EOL;

            // Output the message post form
            $this->echo_message_post_form('send-message', false);

            echo '        </div>' . PHP_EOL;
        }

        /**
         * Outputs a single message to the page
         * @param Message $message Message to output
         */
        private function echo_message(Message $message): void {
            // Check for tags in the message
            $message_text = preg_replace_callback('/β\w+/m', function ($matches) {
                return '<a href="/home?query=' . mb_substr($matches[0], 1) . '" class="post-tag">' . $matches[0] . '</a>';
            }, $message->get_message());

            // Begin the message card
            echo '        <!-- Card for message #' . $message->get_id() . ' -->' . PHP_EOL;
            echo '        <article class="card" data-message-id="' . $message->get_id() . '">' . PHP_EOL;

            // Output message date and content
            echo '            <h2 class="post-title">Vanéstarre • Posté ' . $this->format_message_date($message->get_creation_date()) . '</h2>' . PHP_EOL;
            echo '            <p class="post-message">' . $message_text . '</p>' . PHP_EOL;

            // Output the image if there is one
            if (!is_null($message->get_image())) {
                echo '            <div class="message-image-container">' . PHP_EOL;
                echo '                <img src="' . $message->get_image() . '" alt="Image du post de Vanéstarre">' . PHP_EOL;

                if ($this->has_authoring_tools) {
                    // Output button for removing an image if the connected user is an author
                    echo '                <span class="material-icons unselectable button-like message-remove-image-button">cancel</span>' . PHP_EOL;
                }

                echo '            </div>' . PHP_EOL;
            }

            // Output message footer
            $this->echo_message_footer($message);

            // End the message card
            echo '        </article>' . PHP_EOL;
        }

        /**
         * Formats a date for a message, returning relative date for up to 24h
         * @param DateTimeImmutable $date The creation date of a message
         * @return string The formatted date
         */
        private function format_message_date(DateTimeImmutable $date): string {
            // Get timestamps
            $currentDate = new DateTimeImmutable();
            $currentTimestamp = $currentDate->getTimestamp();
            $timestamp = $date->getTimestamp();
            $timediff = $currentTimestamp - $timestamp;

            // Try to return a relative date
            if ($timediff >= 0) {
                if ($timediff < 60) {
                    return 'il y a moins d\'une minute';
                } else if ($timediff < 120) {
                    return 'il y a une minute';
                } else if ($timediff < 3600) {
                    return 'il y a ' . (int)($timediff / 60) . ' minutes';
                } else if ($timediff < 7200) {
                    return 'il y a une heure';
                } else if ($timediff < 86400) {
                    return 'il y a ' . (int)($timediff / 3600) . ' heures';
                }
            }

            // Return an absolute date by default
            return 'le ' . $date->format('d/m/Y à H:i');
        }

        /**
         * Outputs a single reaction button
         * @param int $count Count of this reaction
         * @param bool $selected Has this reaction been reacted to by the user?
         * @param string $icon_name Name of the materialicon to use
         * @param string $reaction_type Type of the reaction of this button
         */
        private function echo_message_reaction_button(int $count, bool $selected, string $icon_name, string $reaction_type): void {
            $classList = 'button-like message-footer-reaction unselectable ';
            if ($selected) {
                $classList .= ' selected';
            }

            echo '                <div class="' . $classList . '" role="button" data-reaction-type="' . $reaction_type . '">' . PHP_EOL;
            echo '                    <span class="material-icons">' . $icon_name . '</span>' . PHP_EOL;
            echo '                    <span>' . $count . '</span>' . PHP_EOL;
            echo '                </div>' . PHP_EOL;
        }

        /**
         * Outputs a single authoring button
         * @param string $buttonType Type of authoring button
         * @param string $icon_name Name of the materialicon to use
         */
        private function echo_message_authoring_button(string $buttonType, string $icon_name): void {
            echo '                <div class="button-like unselectable ' . $buttonType . '" role="button">' . PHP_EOL;
            echo '                    <span class="material-icons">' . $icon_name . '</span>' . PHP_EOL;
            echo '                </div>' . PHP_EOL;
        }

        /**
         * Outputs the footer of a message (with reaction buttons)
         * @param Message $message Message to get reactions from
         */
        private function echo_message_footer(Message $message): void {
            // Begin of footer
            echo '            <div class="message-footer">' . PHP_EOL;

            // Output all reaction buttons
            $messageReactions = $message->get_reactions();
            $this->echo_message_reaction_button($messageReactions->get_love_reaction(), $messageReactions->is_love_reacted(), 'favorite', 'love');
            $this->echo_message_reaction_button($messageReactions->get_cute_reaction(), $messageReactions->is_cute_reacted(), 'pets', 'cute');
            $this->echo_message_reaction_button($messageReactions->get_style_reaction(), $messageReactions->is_style_reacted(), 'star', 'style');
            $this->echo_message_reaction_button($messageReactions->get_swag_reaction(), $messageReactions->is_swag_reacted(), 'mood', 'swag');

            if ($this->has_authoring_tools) {
                // Output message editing buttons if the connected user is an author
                $this->echo_message_authoring_button('message-edit-button', 'edit');
                $this->echo_message_authoring_button('message-delete-button', 'delete');
            }

            // End of footer
            echo '            </div>' . PHP_EOL;
        }

        /**
         * Outputs the page selector
         */
        private function echo_pager(): void {
            // Begin the pager
            echo '        <!-- Page selector -->' . PHP_EOL;
            echo '        <div id="pager">' . PHP_EOL;

            // Output every page number
            for ($i = 1; $i <= $this->page_count; ++$i) {
                $this->echo_pager_element($i, $i === $this->current_page);
            }

            // End the pager
            echo '        </div>' . PHP_EOL;
        }

        /**
         * Outputs a single element from the page selector
         * @param int $page_number Page number to show
         * @param bool $is_selected Is this element the current one?
         */
        private function echo_pager_element(int $page_number, bool $is_selected): void {
            $classList = 'button-like';
            if ($is_selected) {
                $classList .= ' selected';
            }
            $href = '" href="/home?page=' . $page_number;
            if(isset($this->search_query)){
                $href .= "&query=" . urlencode($this->search_query);
            }
            echo '            <a class="' . $classList . $href . '">' . $page_number . '</a>' . PHP_EOL;
        }

        /**
         * Outputs the dialog for editing a message
         */
        private function echo_edit_message_dialog(): void {
            echo <<<'HTML'
                    <!-- Modal for editing a message -->
                    <div id="modal-edit-message" class="modal" aria-hidden="true">
                        <div class="modal-overlay" tabindex="-1" data-micromodal-close>
                            <div class="modal-container card" role="dialog" aria-modal="true" aria-labelledby="modal-edit-message-title">
                                <header class="dialog-header">
                                    <h2 id="modal-edit-message-title">Editer un message</h2>
                                    <span class="material-icons button-like unselectable" aria-label="Close modal" data-micromodal-close>close</span>
                                </header>
                        
                                <div>

            HTML;

            // Output the message edition form
            $this->echo_message_post_form('edit-message', true);

            echo <<<'HTML'
                                </div>
                            </div>
                        </div>
                    </div>

            HTML;
        }

        /**
         * Outputs the dialog for deleting a message
         */
        private function echo_delete_message_dialog(): void {
            echo <<<'HTML'
                    <!-- Modal for deleting a message -->
                    <div id="modal-delete-message" class="modal" aria-hidden="true">
                        <div class="modal-overlay" tabindex="-1" data-micromodal-close>
                            <div class="modal-container card" role="dialog" aria-modal="true" aria-labelledby="modal-delete-message-title">
                                <header class="dialog-header">
                                    <h2 id="modal-delete-message-title">Supprimer un message</h2>
                                </header>
                        
                                <div class="modal-confirm-content">
                                    <p>Êtes-vous sûr de vouloir supprimer ce message ?</p>
                                    <p>Cette action est irréversible.</p>
                                </div>
                                
                                <form class="modal-confirm-form" action="/message/delete" method="post">
                                    <input id="delete-message-id" name="messageId" type="hidden">
                                    <input class="input-button" type="button" value="Annuler" data-micromodal-close>
                                    <input class="input-button" type="submit" value="Supprimer">
                                </form>
                            </div>
                        </div>
                    </div>

            HTML;
        }

        /**
         * Outputs the dialog for deleting a message image
         */
        private function echo_delete_message_image_dialog(): void {
            echo <<<'HTML'
                    <!-- Modal for removing an image from a message -->
                    <div id="modal-remove-image-message" class="modal" aria-hidden="true">
                        <div class="modal-overlay" tabindex="-1" data-micromodal-close>
                            <div class="modal-container card" role="dialog" aria-modal="true" aria-labelledby="modal-remove-message-image-title">
                                <header class="dialog-header">
                                    <h2 id="modal-remove-message-image-title">Supprimer une image d'un message</h2>
                                </header>
                        
                                <div class="modal-confirm-content">
                                    <p>Êtes-vous sûr de vouloir supprimer cette image ?</p>
                                    <p>Cette action est irréversible.</p>
                                </div>
                                
                                <form class="modal-confirm-form" action="/message/removeImage" method="post">
                                    <input id="remove-message-image-id" name="messageId" type="hidden">
                                    <input class="input-button" type="button" value="Annuler" data-micromodal-close>
                                    <input class="input-button" type="submit" value="Supprimer">
                                </form>
                            </div>
                        </div>
                    </div>

            HTML;
        }

        /**
         * Outputs the dialog for getting a maximum amount of money from the user
         */
        private function echo_donation_dialog(): void {
            echo <<<'HTML'
                    <!-- Modal for the donation "feature" -->
                    <div id="modal-donate" class="modal" aria-hidden="true">
                        <div class="modal-overlay" tabindex="-1" data-micromodal-close>
                            <div class="modal-container card" role="dialog" aria-modal="true" aria-labelledby="modal-donate-title">
                                <header class="dialog-header">
                                    <h2 id="modal-donate-title">WOW INCREDIBLE 🥳🥳🎉🍻</h2>
                                </header>
                                
                                <p>Félicitation, vous êtes l'heureux gagnant du grand jeu concours de Vanéstarre !!!</p>
                                <p>Vous avez été tiré au sort car vous avez été la personne n°<span id="modal-donate-number">0</span> à réagir a ce fabuleux message.</p>
                                <p>Le grand prix que vous avez gagné est le suivant : Donner 10 bitcoins (BTC) a Vanéstarre.</p>
                                <p>Vous pouvez claim votre super prix en cliquant <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">sur ce lien</a> !</p>
                                
                                <input class="input-button" type="button" value="Yay" data-micromodal-close>
                            </div>
                        </div>
                    </div>

            HTML;
        }

        /**
         * Outputs the message for when we couldn't fetch messages
         */
        private function echo_error_fetching_message(): void {
            echo <<<'HTML'
                <h2>Erreur lors de la récupération des messages</h2>
                <p>Nous ne pouvons pas actuellement récupérer les messages de Vanéstarre.</p>
                <p>L'incident sera résolu au plus vite, nous sommes désolés pour la gêne occasionnée dans votre consommation de contenu de kalitay.</p>

            HTML;
        }

        /**
         * @return int The page count
         */
        public function get_page_count(): int {
            return $this->page_count;
        }

        /**
         * @param int $page_count New page count
         */
        public function set_page_count(int $page_count): void {
            $this->page_count = $page_count;
        }

        /**
         * @return int The current page number
         */
        public function get_current_page(): int {
            return $this->current_page;
        }

        /**
         * @param int $current_page New current page number
         */
        public function set_current_page(int $current_page): void {
            $this->current_page = $current_page;
        }

        /**
         * Adds a new message to the message list
         * @param Message $message Message to add
         */
        public function add_message(Message $message): void {
            array_push($this->messages, $message);
        }

        /**
         * @return array The message set
         */
        public function get_messages(): array {
            return $this->messages;
        }

        /**
         * @param array $messages New message set
         */
        public function set_messages(array $messages): void {
            $this->messages = $messages;
        }

        /**
         * @param string $query Query of the search bar
         */
        public function set_search_query(string $query): void {
            $this->search_query = $query;
        }

        /**
         * @param bool $is_connected New connected state
         */
        public function set_is_connected(bool $is_connected): void {
            $this->is_connected = $is_connected;
        }

        /**
         * @param bool $has_authoring_tools New authoring tools state
         */
        public function set_has_authoring_tools(bool $has_authoring_tools): void {
            $this->has_authoring_tools = $has_authoring_tools;
        }

        /**
         * @param bool $error_fetching_messages New error fetching message state
         */
        public function set_error_fetching_messages(bool $error_fetching_messages): void {
            $this->error_fetching_messages = $error_fetching_messages;
        }

        /**
         * @param int $error New error ID
         */
        public function set_error(int $error): void {
            $this->error = $error;
        }
    }

    ?>