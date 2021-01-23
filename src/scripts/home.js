/**
 * Script for the home page
 *
 * @author SOLLIER Alexandre
 */

(() => {
    window.addEventListener('load', () => {
        // Init the modal lib
        MicroModal.init();

        // Update states of message length counters and send message buttons based on their textareas
        const MAX_MESSAGE_LENGTH = 50;
        const messageLengthCounters = document.getElementsByClassName('message-length-counter');
        const sendMessageButtons = document.getElementsByClassName('send-message-button');

        for (const counter of messageLengthCounters) {
            const targetTextarea = document.getElementById(counter.dataset.forTextarea);
            if (targetTextarea !== null) {
                function updateCounterState() {
                    // Updates the length counter with the remaining count of chars available
                    let charsLeft = MAX_MESSAGE_LENGTH;
                    if (targetTextarea.value.trim().length > 0) {
                        charsLeft -= targetTextarea.value.length;
                    }

                    counter.innerText = charsLeft.toString();

                    // Change the counter color depending on the number of chars left
                    if (charsLeft <= 0) {
                        counter.classList.add('critical-chars-left');
                        counter.classList.remove('warning-chars-left');
                    } else if (charsLeft < 10) {
                        counter.classList.add('warning-chars-left');
                        counter.classList.remove('critical-chars-left');
                    } else {
                        counter.classList.remove('warning-chars-left', 'critical-chars-left');
                    }
                }

                // Update the counter state on each input in their textarea
                targetTextarea.addEventListener('input', updateCounterState);

                // Update the counter state on load too
                updateCounterState();
            }
        }

        for (const button of sendMessageButtons) {
            const targetTextarea = document.getElementById(button.dataset.forTextarea);
            if (targetTextarea !== null) {
                const updateButtonState = () => {
                    // Updates the length counter with the remaining count of chars available
                    let charsLeft = MAX_MESSAGE_LENGTH;
                    if (targetTextarea.value.trim().length > 0) {
                        charsLeft -= targetTextarea.value.length;
                    }

                    // Update button state
                    button.disabled = (charsLeft === MAX_MESSAGE_LENGTH || charsLeft < 0);
                };

                // Update the button state on each input in their textarea
                targetTextarea.addEventListener('input', updateButtonState);

                // Update the button state on load too
                updateButtonState();
            }
        }

        // Add a click listener on every beta insert button
        const betaInsertButtons = document.getElementsByClassName('beta-insert-button');
        for (const button of betaInsertButtons) {
            const targetTextarea = document.getElementById(button.dataset.forTextarea);
            if (targetTextarea !== null) {
                button.addEventListener('click', () => {
                    // Insert the character where the cursor is
                    const cursorPos = targetTextarea.selectionStart;
                    targetTextarea.value = targetTextarea.value.substring(0, cursorPos) + 'β' + targetTextarea.value.substring(cursorPos);

                    // (Re)focus the textarea
                    targetTextarea.focus();
                    targetTextarea.setSelectionRange(cursorPos + 1, cursorPos + 1);

                    // Dispatch the input event to update the counter
                    targetTextarea.dispatchEvent(new InputEvent('input'));
                });
            }
        }

        function getMessageIdFromButton(button) {
            // Begin with the parent button and start going up from here
            let messageCard = button.parentElement;
            while (messageCard !== null && !messageCard.dataset.messageId) {
                messageCard = messageCard.parentElement;
            }

            // We couldn't grab the message card, exit
            if (messageCard === null) return;

            // Store the message ID
            return messageCard.dataset.messageId;
        }

        // Add a click listener on every reaction button
        const messageReactionButtons = document.getElementsByClassName('message-footer-reaction');

        function onReactionClick(event) {
            // Grab the button container
            let clickedReactionContainer = event.target;
            while (clickedReactionContainer !== null && !clickedReactionContainer.classList.contains('message-footer-reaction')) {
                clickedReactionContainer = clickedReactionContainer.parentElement;
            }

            // We couldn't grab the container, exit
            if (clickedReactionContainer === null) return;

            // Grab data associated with the button
            const messageID = getMessageIdFromButton(clickedReactionContainer);
            const reactionType = clickedReactionContainer.dataset.reactionType;

            // We couldn't grab the required data, exit
            if (!messageID || !reactionType) return;

            function setReactionContainerSelected(container, state) {
                // Get reaction count
                const reactionCounterSpan = container.children[container.children.length - 1];
                const reactionCount = parseInt(reactionCounterSpan.innerHTML);

                if (state) {
                    // Select the container
                    container.classList.add('selected');
                    if (!isNaN(reactionCount)) {
                        reactionCounterSpan.innerHTML = reactionCount + 1;
                    }
                } else {
                    // Unselect the container
                    container.classList.remove('selected');
                    if (!isNaN(reactionCount)) {
                        reactionCounterSpan.innerHTML = reactionCount - 1;
                    }
                }
            }

            // TODO: XMLHttpRequest the message reaction endpoint
            // TODO: Show donate dialog if needed
            // Unselect the currently selected reaction
            const selectedReactionContainer = document.querySelector('article[data-message-id="' + messageID + '"] .message-footer-reaction.selected');
            if (selectedReactionContainer) {
                setReactionContainerSelected(selectedReactionContainer, false);
            }

            // Select the clicked reaction, if it wasn't the one already selected
            if (selectedReactionContainer !== clickedReactionContainer) {
                setReactionContainerSelected(clickedReactionContainer, true);
            }

            console.log('Message #' + messageID + ' reacted with ' + reactionType);
        }

        for (const button of messageReactionButtons) {
            button.addEventListener('click', onReactionClick);
        }

        // Add a click listener on every message edit button
        const editMessageText = document.getElementById('edit-message-text');

        if (editMessageText !== null) {
            // Add a click listener on every message edit button
            const editMessageId = document.getElementById('edit-message-id');

            if (editMessageId !== null) {
                const messageEditButtons = document.getElementsByClassName('message-edit-button');

                function onEditClick(event) {
                    // Grab message ID associated with the button
                    const messageID = getMessageIdFromButton(event.target);
                    if (!messageID) return;

                    // Set dialog values
                    const messageText = document.querySelector('article[data-message-id="' + messageID + '"] > .post-message');
                    if (!messageText) return;

                    editMessageText.value = messageText.innerText;
                    editMessageText.dispatchEvent(new InputEvent('input'));
                    editMessageId.value = messageID;

                    const editMessageFile = document.getElementById('edit-message-file');
                    if (editMessageFile !== null) {
                        // Reset the file input of the dialog
                        editMessageFile.value = '';
                        editMessageFile.dispatchEvent(new Event('change'));
                    }

                    // Show the message edit modal
                    MicroModal.show('modal-edit-message');
                }

                for (const button of messageEditButtons) {
                    button.addEventListener('click', onEditClick);
                }
            }

            // Add a click listener on every message delete button
            const deleteMessageId = document.getElementById('delete-message-id');

            if (deleteMessageId !== null) {
                const messageDeleteButtons = document.getElementsByClassName('message-delete-button');

                function onDeleteClick(event) {
                    // Grab message ID associated with the button
                    const messageID = getMessageIdFromButton(event.target);
                    if (!messageID) return;

                    // Set dialog values
                    deleteMessageId.value = messageID;

                    // Show the message delete modal
                    MicroModal.show('modal-delete-message');
                }

                for (const button of messageDeleteButtons) {
                    button.addEventListener('click', onDeleteClick);
                }
            }

            // Add a click listener on every message image remove button
            const removeMessageImageId = document.getElementById('remove-message-image-id');

            if (removeMessageImageId !== null) {
                const messageRemoveImageButtons = document.getElementsByClassName('message-remove-image-button');

                function onRemoveImageClick(event) {
                    // Grab message ID associated with the button
                    const messageID = getMessageIdFromButton(event.target);
                    if (!messageID) return;

                    // Set dialog values
                    removeMessageImageId.value = messageID;

                    // Show the message delete modal
                    MicroModal.show('modal-remove-image-message');
                }

                for (const button of messageRemoveImageButtons) {
                    button.addEventListener('click', onRemoveImageClick);
                }
            }

            // Add a change listener on every message form file input
            const messageFormFileInputs = document.getElementsByClassName('message-form-file');

            for (const input of messageFormFileInputs) {
                const inputLabel = input.parentElement.querySelector('label[for="' + input.id + '"]');
                const inputRemoveButton = input.parentElement.querySelector('.message-form-file-remove[data-for-input="' + input.id + '"]');

                if (inputLabel !== null && inputRemoveButton !== null) {
                    input.addEventListener('change', (event) => {
                        if (event.currentTarget.files.length > 0) {
                            // Set the icon of the label to an image icon, and enable the button for removing the image
                            inputLabel.innerHTML = 'image';

                            inputRemoveButton.classList.remove('disabled');
                            inputRemoveButton.setAttribute('aria-disabled', 'false');
                        } else {
                            // Set the icon of the label to an icon of an image with a plus, and disable the button for removing the image
                            inputLabel.innerHTML = 'add_photo_alternate';

                            inputRemoveButton.classList.add('disabled');
                            inputRemoveButton.setAttribute('aria-disabled', 'true');
                        }
                    });
                }
            }

            // Add a click listener on every message form image remove button
            const messageFormFileRemoveButtons = document.getElementsByClassName('message-form-file-remove');

            for (const button of messageFormFileRemoveButtons) {
                const input = document.getElementById(button.dataset.forInput);

                if (input !== null) {
                    button.addEventListener('click', () => {
                        if (button.classList.contains('disabled')) return;

                        // Clear the input files
                        input.value = '';
                        input.dispatchEvent(new Event('change'));
                    });
                }
            }
        }
    });
})();