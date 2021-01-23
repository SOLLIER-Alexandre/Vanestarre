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
            $this->error_fetching_messages = false;
            $this->error = null;
        }

        /**
         * @inheritDoc
         */
        public function echo_contents(): void {
            // If there was an error, just print it
            if ($this->error_fetching_messages) {
                $this->echo_error_fetching_message();
                return;
            }

            // Echo error box if one occurred
            if (!is_null($this->error)) {
                $this->echo_error_box();
            }

            // TODO: Only output this when the connected account is Vanéstarre
            $this->echo_message_writer();

            // Echo every message
            foreach ($this->messages as $message) {
                $this->echo_message($message);
            }

            // Echo page selector
            $this->echo_pager();

            // Echo dialogs
            // TODO: Only output this when the connected account is Vanéstarre
            $this->echo_edit_message_dialog();
            $this->echo_delete_message_dialog();

            // TODO: Only output this when there is a connected user
            $this->echo_donation_dialog();
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
                    // Error while modifying a message
                    echo '            <p>L\'image n\'a pas pu être uploadé</p>' . PHP_EOL;
                    break;

                default:
                    // Unknown error
                    echo '            <p>Mais elle est inconnue...</p>' . PHP_EOL;
            }

            // End error card
            echo '        </div>' . PHP_EOL;
        }

        /**
         * Outputs the form for writing a message
         */
        private function echo_message_writer(): void {
            echo <<<'HTML'
                    <div class="card">
                        <form class="message-form" action="/postMessage" method="post" enctype="multipart/form-data">
                            <textarea id="send-message-text" placeholder="Postez un message" name="message"></textarea>
                            <div class="message-form-buttons">
                                <div>
                                    <span class="button-like unselectable beta-insert-button" role="button" data-for-textarea="send-message-text">β</span>
                                    <input type="file" name="image" accept="image/png, image/jpeg">
                                </div>
                                <div>
                                    <span class="message-length-counter" data-for-textarea="send-message-text">50</span>
                                    <input class="send-message-button input-button" type="submit" value="Post" data-for-textarea="send-message-text">
                                </div>
                            </div>
                        </form>
                    </div>

            HTML;
        }

        /**
         * Outputs a single message to the page
         * @param Message $message Message to output
         */
        private function echo_message(Message $message): void {
            // Check for tags in the message
            $message_text = preg_replace_callback('/β\w+/m', function ($matches) {
                return '<a href="/search?query=' . mb_substr($matches[0], 1) . '" class="post-tag">' . $matches[0] . '</a>';
            }, $message->get_message());

            // Begin the message card
            echo '        <article class="card" data-message-id="' . $message->get_id() . '">' . PHP_EOL;

            // Output message date and content
            echo '            <h2 class="post-title">Vanéstarre • Posté ' . $this->format_message_date($message->get_creation_date()) . '</h2>' . PHP_EOL;
            echo '            <p class="post-message">' . $message_text . '</p>' . PHP_EOL;

            // Output the image if there is one
            if (!is_null($message->get_image())) {
                echo '            <img src="' . $message->get_image() . '" alt="Image du post de Vanéstarre">' . PHP_EOL;
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
         * @param string $iconName Name of the materialicon to use
         * @param string $reactionType Type of the reaction of this button
         */
        private function echo_message_reaction_button(int $count, bool $selected, string $iconName, string $reactionType): void {
            $classList = 'button-like message-footer-reaction unselectable ';
            if ($selected) {
                $classList .= ' selected';
            }

            echo '                <div class="' . $classList . '" role="button" data-reaction-type="' . $reactionType . '">' . PHP_EOL;
            echo '                    <span class="material-icons">' . $iconName . '</span>' . PHP_EOL;
            echo '                    <span>' . $count . '</span>' . PHP_EOL;
            echo '                </div>' . PHP_EOL;
        }

        /**
         * Outputs a single authoring button
         * @param string $buttonType Type of authoring button
         * @param string $iconName Name of the materialicon to use
         */
        private function echo_message_authoring_button(string $buttonType, string $iconName): void {
            echo '                <div class="button-like unselectable ' . $buttonType . '" role="button">' . PHP_EOL;
            echo '                    <span class="material-icons">' . $iconName . '</span>' . PHP_EOL;
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

            // TODO: Only output this when user is authorized
            $this->echo_message_authoring_button('message-edit-button', 'edit');
            $this->echo_message_authoring_button('message-delete-button', 'delete');

            // End of footer
            echo '            </div>' . PHP_EOL;
        }

        /**
         * Outputs the page selector
         */
        private function echo_pager(): void {
            // Begin the pager
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

            echo '            <a class="' . $classList . '" href="/home?page=' . $page_number . '">' . $page_number . '</a>' . PHP_EOL;
        }

        /**
         * Outputs the dialog for editing a message
         */
        private function echo_edit_message_dialog(): void {
            echo <<<'HTML'
                    <div id="modal-edit-message" class="modal" aria-hidden="true">
                        <div class="modal-overlay" tabindex="-1" data-micromodal-close>
                            <div class="modal-container card" role="dialog" aria-modal="true" aria-labelledby="modal-edit-message-title">
                                <header class="dialog-header">
                                    <h2 id="modal-edit-message-title">Editer un message</h2>
                                    <span class="material-icons button-like unselectable" aria-label="Close modal" data-micromodal-close>close</span>
                                </header>
                        
                                <div>
                                    <form class="message-form" action="/postMessage" method="post">
                                        <input id="edit-message-id" name="messageId" type="hidden">
                                        <textarea id="edit-message-text" placeholder="Message" name="message"></textarea>
                                        <div class="message-form-buttons">
                                            <div>
                                                <span class="button-like unselectable beta-insert-button" role="button" data-for-textarea="edit-message-text">β</span>
                                            </div>
                                            <div>
                                                <span class="message-length-counter" data-for-textarea="edit-message-text">50</span>
                                                <input class="send-message-button input-button" type="submit" value="Post" data-for-textarea="edit-message-text">
                                            </div>
                                        </div>
                                    </form>
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
                    <div id="modal-delete-message" class="modal" aria-hidden="true">
                        <div class="modal-overlay" tabindex="-1" data-micromodal-close>
                            <div class="modal-container card" role="dialog" aria-modal="true" aria-labelledby="modal-delete-message-title">
                                <header class="dialog-header">
                                    <h2 id="modal-delete-message-title">Supprimer un message</h2>
                                </header>
                        
                                <div class="modal-delete-message-content">
                                    <p>Êtes-vous sûr de vouloir supprimer ce message ?</p>
                                    <p>Cette action est irréversible.</p>
                                </div>
                                
                                <form id="modal-delete-message-form" action="/deleteMessage" method="post">
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
         * Outputs the dialog for getting a maximum amount of money from the user
         */
        private function echo_donation_dialog(): void {
            echo <<<'HTML'
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