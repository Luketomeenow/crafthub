<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant Chat</title>
    <link rel="stylesheet" href="chat_style.css">
</head>
<body>
    <div id="merchant-chat-box">
        <h2>Merchant Chat</h2>
        <div id="merchant-chat-messages"></div>
        <form id="merchant-message-form" enctype="multipart/form-data">
            <input type="text" id="merchant-message-input" name="message" placeholder="Type a message" />
            <input type="file" id="merchant-media-upload" name="media" accept="image/*,video/*" />
            <button type="submit">Send</button>
        </form>
    </div>
    <script src="merchant_chat.js"></script>
</body>
</html>
