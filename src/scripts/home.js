/**
 * Script for the home page
 *
 * @author SOLLIER Alexandre
 */

(() => {
    window.addEventListener('load', () => {
        const messageLengthCounter = document.getElementById('message-length-counter');
        const sendMessageText = document.getElementById('send-message-text');
        const sendMessageButton = document.getElementById('send-message-button');

        if (messageLengthCounter !== null && sendMessageText !== null && sendMessageButton !== null) {
            const updateStates = () => {
                // Updates the length counter with the remaining count of chars available
                const MAX_MESSAGE_LENGTH = 50;
                let charsLeft = MAX_MESSAGE_LENGTH;
                if (sendMessageText.value.trim().length > 0) {
                    charsLeft -= sendMessageText.value.length;
                }

                messageLengthCounter.innerText = charsLeft.toString();

                // Change the counter color depending on the number of chars left
                if (charsLeft <= 0) {
                    messageLengthCounter.classList.add('critical-chars-left');
                    messageLengthCounter.classList.remove('warning-chars-left');
                } else if (charsLeft < 10) {
                    messageLengthCounter.classList.add('warning-chars-left');
                    messageLengthCounter.classList.remove('critical-chars-left');
                } else {
                    messageLengthCounter.classList.remove('warning-chars-left', 'critical-chars-left');
                }

                // Update button state
                sendMessageButton.disabled = (charsLeft === MAX_MESSAGE_LENGTH);
            };

            // Update the states on each input in the <textarea>
            sendMessageText.addEventListener('input', () => {
                updateStates();
            });

            // Update the states on load too
            updateStates();
        }

        // Add a click listener on every reaction button
        const messageReactionButtons = document.getElementsByClassName('message-footer-reaction');
        const onReactionClick = (event) => {
            // Grab the button container
            let buttonContainer = event.target;
            while (buttonContainer !== null && !buttonContainer.classList.contains('message-footer-reaction')) {
                buttonContainer = buttonContainer.parentElement;
            }

            // We couldn't grab the container, exit
            if (buttonContainer === null) return;

            // Check if the button is selected (user has reacted to this message)
            const isButtonSelected = buttonContainer.classList.contains('selected');
            const reactionCounterSpan = buttonContainer.children[buttonContainer.children.length - 1];
            const reactionCount = parseInt(reactionCounterSpan.innerHTML);

            // Grab message ID associated with the button
            let messageCard = buttonContainer.parentElement;
            while (messageCard !== null && !messageCard.dataset.messageId) {
                messageCard = messageCard.parentElement;
            }

            // We couldn't grab the message card, exit
            if (messageCard === null) return;

            // Store the message ID
            const messageID = messageCard.dataset.messageId;

            // TODO: XMLHttpRequest the message reaction endpoint
            if (isButtonSelected) {
                // Unselect the button
                buttonContainer.classList.remove('selected');
                if (!isNaN(reactionCount)) {
                    reactionCounterSpan.innerHTML = reactionCount - 1;
                }
            } else {
                // Select the button
                buttonContainer.classList.add('selected');
                if (!isNaN(reactionCount)) {
                    reactionCounterSpan.innerHTML = reactionCount + 1;
                }
            }
        };

        for (const button of messageReactionButtons) {
            button.addEventListener('click', onReactionClick);
        }
    });
})();