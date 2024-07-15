function sendMessage() {
    var userInput = document.getElementById('user-input').value.trim();

    if (userInput === '') {
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'chat.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    displayMessage(response.user_message, 'user');
                    displayMessage(response.gpt_answer, 'gpt');
                    document.getElementById('user-input').value = ''; // Clear input field
                    scrollToBottom(); // Scroll to bottom of chat
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            } else {
                console.error('Error:', xhr.status);
            }
        }
    };
    xhr.send('message=' + encodeURIComponent(userInput));
}

function displayMessage(message, sender) {
    var messageContent = '<div class="message ' + (sender === 'user' ? 'user-message' : 'ai-message') + '"><div class="message-text">' + message + '</div></div>';

    var messagesContainer = document.querySelector('.messages-content');
    messagesContainer.innerHTML += messageContent;

    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}
