/**
 * Script for the home page
 *
 * @author SOLLIER Alexandre
 */

(() => {
    window.onload = () => {
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
    };
})();