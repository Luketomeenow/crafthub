<?php
session_start(); // Start the session

require 'dbcon.php'; // Your database connection

// Check if the merchant is logged in
if (!isset($_SESSION['merchant_id']) || $_SESSION['user_type'] != 'crafthub_merchant') {
    // Redirect to login page
    header('Location: /Crafthub/login.php'); // Adjust the path if needed
    exit();
}

// Get the current merchant's ID and type from the session
$current_user_id = $_SESSION['merchant_id'];
$current_user_type = $_SESSION['user_type']; // Should be 'crafthub_merchant'

// Get the chat partner's ID and type from URL parameters
$chat_partner_id = isset($_GET['chat_with_id']) ? intval($_GET['chat_with_id']) : null;
$chat_partner_type = isset($_GET['chat_with_type']) ? $_GET['chat_with_type'] : null;

if (!$chat_partner_id || !$chat_partner_type) {
    echo "No chat partner selected.";
    exit();
}

// Fetch chat partner's name
if ($chat_partner_type == 'user') {
    // Prepare the SQL query
    $query = "SELECT fname, lname FROM crafthub_user WHERE user_id = ?";

    // Initialize the prepared statement
    $stmt = mysqli_prepare($connection, $query);

    // Bind the parameter (user_id)
    mysqli_stmt_bind_param($stmt, "i", $chat_partner_id);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $first_name, $last_name);

    // Fetch the result
    mysqli_stmt_fetch($stmt);

    // Combine the first and last name
    $chat_partner_name = $first_name . ' ' . $last_name;

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Handle other types if necessary
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== REMIXICONS ==============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--=============== BOXICONS ==============-->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/mchatroom.css">
    <link rel="stylesheet" href="css/mnavigation.css">
</head>
<body>
   <!--=============== NAVIGATION ==============-->
<div class="flexMain sticky-top py-4" id="mainNavigation">
    <div class="flex3">
        <ul class="list-unstyled d-md-block">
            <li class="mx-4 d-inline-block"><a href="mdashboard.php" class="logo"><img src="images/navlogo.png"></a></li>
        </ul>
    </div>
    <div class="flex5">
        <ul class="list-unstyled navigation-menu">
            <li class="mx-4 d-inline-block"><a href="mdashboard.php">Dashboard</a></li>
            <li class="mx-4 d-inline-block"><a href="mprofile.php">Products</a></li>
            <li class="mx-4 d-inline-block"><a href="morders.php">Orders</a></li>
            <li class="mx-4 d-inline-block"><a href="mchatroom.php">Messages</a></li>
            <li class="mx-4 d-inline-block"><a href="maccount.php">Settings</a></li>
            <li class="mx-4 d-inline-block"><a href="index.php">Logout</a></li>
        </ul>
    </div>
    <nav class="responsive">
        <input type="checkbox" id="sidebar-active">
        <label for="sidebar-active" class="open-sidebar-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="42" viewBox="0 -960 960 960" width="32">
                <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
            </svg>
        </label>
        <label id="overlay" for="sidebar-active"></label>
        <div class="links-container">
            <label for="sidebar-active" class="close-sidebar-button">
                <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32">
                    <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                </svg>
            </label>
            <a href="mprofile.php">Profile</a>
            <a href="mchatroom.php">Messages</a>
            <a href="morders.php">Orders</a>
            <a href="maccount.php">Settings</a>
            <a href="index.php">Log out</a>
        </div>
    </nav>
</div>
<!--=============== END NAVIGATION ==============-->

    <!--=============== CHAT CONTENT ===============-->
    <div class="container">
        <div class="row">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0" id="tabList">
    <?php
    // Include your database connection

    // Start the session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Get the current merchant's ID
    $current_user_id = $_SESSION['merchant_id'];

    // Fetch the list of users who have messaged the merchan

  // Initialize the prepared statement
    $result = mysqli_query($connection, "SELECT DISTINCT crafthub_user.user_id, crafthub_user.first_name, crafthub_user.last_name
    FROM messages
    INNER JOIN crafthub_user ON crafthub_user.user_id = messages.sender_id
    WHERE messages.receiver_id = ? AND messages.receiver_type = 'merchant'
    AND messages.sender_type = 'user'");
  // Bind the parameter (receiver_id)
  if ($result) {
      while ($merchant = mysqli_fetch_assoc($result)) {
      $user_name = $user['fname'] . ' ' . $user['lname'];

      echo '<li class="clearfix">';
      echo '<a href="mchatroom.php?chat_with_id=' . $user['user_id'] . '&chat_with_type=user">';
      echo '<img src="images/user.png" alt="avatar">';
      echo '<div class="about">';
      echo '<div class="name">' . htmlspecialchars($user_name) . '</div>';
      echo '<div class="status"> <i class="fa fa-circle online"></i> online </div>';
      echo '</div>';
      echo '</a>';
      echo '</li>';
  }}
    ?>
</ul>

                </div>
                <div class="chat">
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="images/user.png" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <h6 class="m-b-0"><?php echo htmlspecialchars($chat_partner_name); ?></h6>
                                    <small>Last seen: 2 hours ago</small>
                                </div>
                            </div>
                            <div class="col-lg-6 hidden-sm text-right">
                                <div class="btn-group">
                                    <a href="javascript:void(0);" class="btn btn-outline-primary" id="captureBtn"><i class="fa fa-camera"></i></a>
                                    <div id="cameraContainer" class="camera-container">
                                        <video id="videoElement" style="width: 100%; height: auto;"></video>
                                    </div>
                                    <input type="file" id="imageUploadInput" class="btn btn-outline-secondary" style="display: none;" accept="image/*">
                                    <a href="javascript:void(0);" class="btn btn-outline-secondary" id="uploadBtn"><i class="fa fa-image"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history" id="chatHistory0">
                        <!--=============== CHAT HISTORY FOR TAB 1 ===============-->
                        <ul class="m-b-0">
                            <!--=============== MESSAGES WILL BE ADDED HERE ===============-->
                        </ul>
                    </div>
                    <div class="chat-history" id="chatHistory1">
                        <!--=============== CHAT HISTORY FOR TAB 2 ===============-->
                        <ul class="m-b-0">
                            <!--=============== MESSAGES WILL BE ADDED HERE ===============-->
                        </ul>
                    </div>
                    <div class="chat-message clearfix">
                        <div class="input-group mt-auto">
                            <textarea id="messageInput" class="form-control" rows="2" placeholder="Enter a message"></textarea> <!--=============== ENTER MESSAGE ===============-->
                            <div class="input-group-append">
                                <button id="sendMessageBtn" type="button" class="btn btn-outline-secondary"><i class="fa fa-send"></i></button> <!--=============== SEND BUTTON ===============-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--=============== END OF CHAT CONTENT ===============-->

<!--=============== CAPTURE, UPLOAD AND SEND MESSAGE JAVASCRIPT ===============-->
<script>
    var CURRENT_USER_ID = <?php echo json_encode($current_user_id); ?>;
    var CURRENT_USER_TYPE = <?php echo json_encode($current_user_type); ?>;
    var CURRENT_CHAT_PARTNER_ID = <?php echo json_encode($chat_partner_id); ?>;
    var CURRENT_CHAT_PARTNER_TYPE = <?php echo json_encode($chat_partner_type); ?>;
</script>
<script src="js/chat.js"></script>
<script>
    function fetchMessages() {
        var sender_id = CURRENT_USER_ID;
        var sender_type = CURRENT_USER_TYPE;
        var receiver_id = CURRENT_CHAT_PARTNER_ID;
        var receiver_type = CURRENT_CHAT_PARTNER_TYPE;
        console.log(sender_id);
        console.log(sender_type);
        console.log(receiver_id);
        console.log(receiver_type);

        fetch('fetch_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                sender_id: sender_id,
                sender_type: sender_type,
                receiver_id: receiver_id,
                receiver_type: receiver_type,
            }),
        })
        .then(response => response.json())
        .then(data => {
            var chatHistory = document.querySelector('.chat-history ul');
            console.log(data.messages);
            //chatHistory.innerHTML = '';

            data.messages.forEach(function(message) {
                var direction = (message.sender_id == sender_id && message.sender_type == sender_type) ? 'outgoing' : 'incoming';
                addMessageToChatHistory(message.message_type === 'text' ? message.message : message.media_path, direction, message.message_type);
            });
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }

    // Fetch messages every 5 seconds
    setInterval(fetchMessages, 5000);

    // Initial fetch
    fetchMessages();
    </script>
</body>
</html>
