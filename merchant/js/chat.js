

// Function to capture video from the camera
document.getElementById('captureBtn').addEventListener('click', function() {
    // Check if getUserMedia is available
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Open the camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                var video = document.getElementById('videoElement');
                // Display the video stream
                video.srcObject = stream;
                video.play();
                // Show the video element
                video.style.display = 'block';
            })
            .catch(function(error) {
                console.error('Error accessing camera:', error);
                // Handle error here
            });
    } else {
        console.error('getUserMedia is not supported');
        // Handle error here if getUserMedia is not supported
    }
});

// Function to handle click event on the upload icon
document.getElementById('uploadBtn').addEventListener('click', function() {
    // Trigger the file input when the icon is clicked
    document.getElementById('imageUploadInput').click();
});

// Function to filter tabs based on search input
document.getElementById('searchInput').addEventListener('input', function() {
    var input = this.value.toLowerCase(); // Get the input value in lowercase
    var tabs = document.querySelectorAll('#tabList li');

    tabs.forEach(function(tab) {
        var name = tab.querySelector('.about .name').innerText.toLowerCase(); // Get the name of the tab in lowercase
        if (name.includes(input)) {
            tab.style.display = 'block'; // Show the tab if the name matches the input
        } else {
            tab.style.display = 'none'; // Hide the tab if the name doesn't match the input
        }
    });
});

// Function to show default chat and chat-history
function showDefaultChat() {
    var defaultTab = document.querySelector('#tabList li:first-child');
    if (defaultTab) {
        defaultTab.classList.add('active');
        var defaultUserName = defaultTab.querySelector('.about .name').innerText;
        document.querySelector('.chat-header h6').innerText = defaultUserName;
        var defaultMessageDataTime = document.querySelector('.chat-history .message-data-time.user');
        if (defaultMessageDataTime) {
            defaultMessageDataTime.innerText = defaultUserName;
        }
        var defaultMessageInput = document.getElementById('messageInput');
        var defaultSendMessageBtn = document.getElementById('sendMessageBtn');
        defaultMessageInput.style.display = 'block';
        defaultSendMessageBtn.style.display = 'block';
        var defaultChatHistory = document.querySelector('.chat-history');
        if (defaultChatHistory) {
            defaultChatHistory.style.display = 'block';
        }
    }
}

// Call the function to show default chat and chat-history
//showDefaultChat();

// Function to switch tabs and clear chat histories
function switchTab(event, tabIndex) {
    // Remove the "active" class from all tab list items
    var tabListItems = document.querySelectorAll('#tabList li');
    tabListItems.forEach(function(item) {
        item.classList.remove('active');
    });

    // Add the "active" class to the clicked tab list item
    event.currentTarget.classList.add('active');

    // Hide all chat histories
    var chatHistories = document.querySelectorAll('.chat-history');
    chatHistories.forEach(function(chatHistory) {
        chatHistory.style.display = 'none';
    });

    // Show the chat history corresponding to the clicked tab
    var chatHistoryId = 'chatHistory' + tabIndex;
    var chatHistory = document.getElementById(chatHistoryId);
    chatHistory.style.display = 'block';

    // Get the name of the user associated with the clicked tab
    var userName = document.querySelectorAll('#tabList li')[tabIndex].querySelector('.about .name').innerText;

    // Update the user name in the chat header
    document.querySelector('.chat-header h6').innerText = userName;

    // Update the user name in the message data time
    var messageDataTime = document.querySelector('.chat-history .message-data-time.user');
    if (messageDataTime) {
        messageDataTime.innerText = userName;
    }

    // Show the message input area and send button
    var messageInput = document.getElementById('messageInput');
    var sendMessageBtn = document.getElementById('sendMessageBtn');
    messageInput.style.display = 'block';
    sendMessageBtn.style.display = 'block';
}

// Send message functionality
function sendMessage() {
    var messageInput = document.getElementById('messageInput');
    var message = messageInput.value.trim();

    if (message !== '') {
        // Get sender and receiver IDs and types from hidden inputs or session variables
        var sender_id = CURRENT_USER_ID; // Set this variable accordingly
        var sender_type = CURRENT_USER_TYPE; // 'user' or 'merchant'
        var receiver_id = CURRENT_CHAT_PARTNER_ID; // Set this variable accordingly
        var receiver_type = CURRENT_CHAT_PARTNER_TYPE; // 'user' or 'merchant'

        // Send the message to the server using AJAX
        fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                sender_id: sender_id,
                sender_type: sender_type,
                receiver_id: receiver_id,
                receiver_type: receiver_type,
                message: message
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update the chat history
                addMessageToChatHistory(message, 'outgoing', 'text');
                messageInput.value = '';
            } else {
                console.error('Failed to send message:', data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
}

function addMessageToChatHistory(messageContent, direction, messageType) {
    var chatHistory = document.querySelector('.chat-history ul');

    var listItem = document.createElement('li');
    listItem.classList.add('clearfix');

    var messageContainer = document.createElement('div');
    messageContainer.classList.add('message');

    if (direction === 'outgoing') {
        messageContainer.classList.add('other-message', 'float-right');
    } else {
        messageContainer.classList.add('my-message');
    }

    if (messageType === 'text') {
        messageContainer.innerText = messageContent;
    } else if (messageType === 'image') {
        var img = document.createElement('img');
        img.src = messageContent;
        img.style.maxWidth = '200px';
        messageContainer.appendChild(img);
    } else if (messageType === 'video') {
        var video = document.createElement('video');
        video.src = messageContent;
        video.controls = true;
        video.style.maxWidth = '200px';
        messageContainer.appendChild(video);
    }

    listItem.appendChild(messageContainer);
    chatHistory.appendChild(listItem);
}


document.getElementById('sendMessageBtn').addEventListener('click', sendMessage);

document.getElementById('imageUploadInput').addEventListener('change', function() {
    var fileInput = this;
    var file = fileInput.files[0];

    if (file) {
        var formData = new FormData();
        formData.append('media', file);

        // Get sender and receiver IDs and types
        formData.append('sender_id', CURRENT_USER_ID);
        formData.append('sender_type', CURRENT_USER_TYPE);
        formData.append('receiver_id', CURRENT_CHAT_PARTNER_ID);
        formData.append('receiver_type', CURRENT_CHAT_PARTNER_TYPE);

        fetch('send_message.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update the chat history
                addMessageToChatHistory(data.media_path, 'outgoing', file.type.startsWith('image/') ? 'image' : 'video');
            } else {
                console.error('Failed to send media:', data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
});

// Listen for "Enter" key press in the message input field
document.getElementById('messageInput').addEventListener('keydown', function(event) {
    if (event.keyCode === 13) { // "Enter" key code
        sendMessage();
    }
});
