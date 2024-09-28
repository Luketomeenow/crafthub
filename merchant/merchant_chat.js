document.getElementById('merchant-message-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    let sender_id = 1; // Example merchant ID. Replace with dynamic merchant ID.
    let receiver_id = 2; // Example customer ID. Replace with dynamic customer ID.
    formData.append('sender_id', sender_id);
    formData.append('receiver_id', receiver_id);

    fetch('send_message.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Handle the server response
        loadMessages(sender_id, receiver_id); // Refresh messages after sending
    })
    .catch(error => console.error('Error:', error));
});

// Function to load messages
function loadMessages(merchant_id, customer_id) {
    fetch(`get_messages.php?merchant_id=${merchant_id}&customer_id=${customer_id}`)
        .then(response => response.json())
        .then(messages => {
            let chatBox = document.getElementById('merchant-chat-messages');
            chatBox.innerHTML = ''; // Clear chat box before loading new messages

            messages.forEach(msg => {
                let messageElement = document.createElement('div');

                // Check if the message was sent by the merchant or the customer
                if (msg.sender_id == merchant_id) {
                    messageElement.classList.add('merchant-message'); // Style for merchant's messages
                } else {
                    messageElement.classList.add('customer-message'); // Style for customer's messages
                }

                if (msg.message_type === 'text') {
                    let p = document.createElement('p');
                    p.textContent = msg.message;
                    messageElement.appendChild(p);
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
        })
        .catch(error => console.error('Error:', error));
}


// Poll messages every 2 seconds
setInterval(() => {
    let merchant_id = 1; // Example merchant ID. Replace with dynamic merchant ID.
    let customer_id = 2; // Example customer ID. Replace with dynamic customer ID.
    loadMessages(merchant_id, customer_id);
}, 2000);