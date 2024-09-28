<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Chat</title>
    <link rel="stylesheet" href="chat_style.css">
</head>
<body>
    <div id="customer-chat-box">
        <h2>Customer Chat</h2>
        <div id="customer-chat-messages"></div>
        <form id="customer-message-form" enctype="multipart/form-data">
            <input type="text" id="customer-message-input" name="message" placeholder="Type a message" />
            <input type="file" id="customer-media-upload" name="media" accept="image/*,video/*" />
            <button type="submit">Send</button>
        </form>
    </div>
    <script src="customer_chat.js"></script>
</body>
</html>
