function loadMessages(merchant_id, customer_id) {
    fetch(`get_messages.php?merchant_id=${merchant_id}&customer_id=${customer_id}`)
        .then(response => response.json())
        .then(messages => {
            let chatBox = document.getElementById('merchant-chat-messages'); // Or customer-chat-messages
            chatBox.innerHTML = ''; // Clear chat box before reloading

            messages.forEach(msg => {
                let messageElement = document.createElement('div');
                if (msg.message_type === 'text') {
                    messageElement.textContent = msg.message;
                } else if (msg.message_type === 'image') {
                    let img = document.createElement('img');
                    img.src = msg.media_path;
                    messageElement.appendChild(img);
                } else if (msg.message_type === 'video') {
                    let video = document.createElement('video');
                    video.src = msg.media_path;
                    video.controls = true;
                    messageElement.appendChild(video);
                }
                chatBox.appendChild(messageElement);
            });
        });
}

// Poll every 2 seconds to check for new messages
setInterval(() => loadMessages(merchant_id, customer_id), 2000);
