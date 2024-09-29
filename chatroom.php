<?php
session_start(); // Start the session
echo !empty($_SESSION['userID']) ? "<script>console.log('"."userID: ".$_SESSION['userID']."')</script>" : "<script>console.log('empty console')</script>";
require 'dbcon.php'; // Your database connection

// Check if the user is logged in
if (!isset($_SESSION['userID']) || $_SESSION['user_type'] != 'user') {
    // Redirect to login page or show an error message
    header('Location: login.php');
    exit();
}

// Get the current user's ID and type from the session
$current_user_id = $_SESSION['userID'];
$current_user_type = $_SESSION['user_type']; // Should be 'user'

// Get the chat partner's ID and type from URL parameters
$chat_partner_id = isset($_GET['chat_with_id']) ? intval($_GET['chat_with_id']) : null;
$chat_partner_type = isset($_GET['chat_with_type']) ? $_GET['chat_with_type'] : null;

if (!$chat_partner_id || !$chat_partner_type) {
    echo "No chat partner selected.";
    exit();
}

if ($chat_partner_type == 'merchant') {
  $stmt = mysqli_prepare($connection, "SELECT username FROM crafthub_merchant WHERE merchant_id = ?");

if ($stmt) {
    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $chat_partner_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Bind the result variables
        mysqli_stmt_bind_result($stmt, $chat_partner_name);

        // Fetch the result
        if (mysqli_stmt_fetch($stmt)) {
            // Combine the first name and last name
            $chat_partner_name = $chat_partner_name;
        } else {
            // Handle case where no result is returned
            $chat_partner_name = "Unknown User";
        }
    } else {
        // Handle execution error
        echo "Error executing statement: " . mysqli_error($connection);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Handle preparation error
    echo "Error preparing statement: " . mysqli_error($connection);
}}
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
    <link rel="stylesheet" href="css/chatroom.css">
    <link rel="stylesheet" href="css/navigation.css">

</head>
<body>
    <!--=============== NAVIGATION ==============-->
    <div class="flexMain sticky-top py-4" id="mainNavigation">
        <div class="flex3">
            <ul class="list-unstyled d-md-block">
                <li class="mx-4 d-inline-block"><a href="homepage.php" class="logo"><img src="images/navlogo.png"> </a></li>
            </ul>
        </div>
        <div class="flex2">
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
        </div>
        <div class="flex4" id="icons">
            <ul class="list-unstyled">
                <li class="hideAtCustom mx-4 d-inline-block"><a href="chatroom.php"><i class="ri-chat-2-line"></i></a></li>
                <li class="hideAtCustom mx-4 d-inline-block"><a href="cart.php"><i class="ri-shopping-cart-line"></i></a></li>
            </ul>
        </div>
        <div class="flex5">
            <div class="dropdown">
                <button class="dropbtn">Menu</button>
                <div class="dropdown-content">
                    <a href="accountsettings.php">Account</a>
                    <a href="mypurchase.php">My Purchases</a>
                    <a href="location.php">Store Map</a>
                    <a href="index.php">Log Out</a>
                </div>
            </div>
        </div>
        <nav class="responsive">
            <input type="checkbox" id="sidebar-active">
            <label for="sidebar-active" class="open-sidebar-button">
                <svg xmlns="http://www.w3.org/2000/svg" height="42" padding-top="20px" viewBox="0 -960 960 960" width="32">
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
                <a href="homepage.php">Home</a>
                <a href="chatroom.php?chat_with_id=10&chat_with_type=merchant&merchant_id=10">Messages</a>
                <a href="cart.php">Cart</a>
                <a href="accountsettings.php">Account</a>
                <a href="mypurchase.php">My Purchase</a>
                <a href="storemap.php">Store Map</a>
                <a href="index.php">Log out</a>
            </div>
        </nav>
    </div>
    <!--=============== END NAVIGATION ==============-->

     <!--=============== CHAT CONTAINER ===============-->
     <div class="container">
        <div class="row">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search"> <!--=============== SEARCH ===============-->
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0" id="tabList">
                        <?php
                            // Include your database connectio
                            // Start the session if not already started
                            $result = mysqli_query($connection, "SELECT merchant_id, username FROM crafthub_merchant");
                            // Check if the result is valid
                            if ($result) {

                            while ($merchant = mysqli_fetch_assoc($result)) {
                                $isActive = $merchant['merchant_id'] == $chat_partner_id ? 'active' : '';

                                echo '<li class="clearfix '.$isActive.'">';
                                echo '<a href="chatroom.php?chat_with_id=' . $merchant['merchant_id'] . '&chat_with_type=merchant">';
                                echo '<img src="images/user.png" alt="avatar">';
                                echo '<div class="about">';
                                echo '<div class="name">' . htmlspecialchars($merchant['username']) . '</div>';
                                echo '<div class="status"> <i class="fa fa-circle online"></i> online </div>';
                                echo '</div>';
                                echo '</a>';
                                echo '</li>';
                            }
                            // Free the result set
                            mysqli_free_result($result);
                            } else {
                                // Handle error
                                echo "Failed to retrieve results: " . mysqli_error($connection);
                            }
                        ?>
                    </ul>
                </div>
                <div class="chat"> <!--=============== CHAT CONTENT ===============-->
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="images/user.png" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <h5 class="m-b-0"><?php echo htmlspecialchars($chat_partner_name); ?></h5>
                                    <small>Last seen: 1 hour ago</small>
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
                            <!--=============== MESSAGES FOR TAB 1 WILL BE ADDED HERE ===============-->
                            <?php

                            $merchant_id = $_GET['chat_with_id']; // Merchant's user ID
                            $customer_id = $_SESSION['userID'];// Customer's user ID

                            // Fetch messages between the merchant and the customer
                            $stmt = $connection->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at ASC");
                            $stmt->bind_param("iiii", $customer_id, $merchant_id, $customer_id, $merchant_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $messages = [];
                            while ($row = $result->fetch_assoc()) {
                              $messages[] = $row;
                            }

                            // Return messages as JSON
                            if (!empty($messages))
                            {
                                $messages;
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="chat-message clearfix">
                        <div class="input-group mt-auto">
                            <textarea id="messageInput" class="form-control" rows="2" placeholder="Enter a message"></textarea> <!--=============== ENTER MESSAGE ===============-->
                            <div class="input-group-append">
                                <button id="sendMessageBtn" type="button" class="btn btn-outline-secondary"><i class="fa fa-send"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--=============== END OF CHAT CONTAINER ===============-->

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
            chatHistory.innerHTML = '';
            console.log('sender_id: '+sender_id+'sender_type: '+sender_type+'receiver_id: '+receiver_id+'receiver_type: '+receiver_type);

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
