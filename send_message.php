<?php
require 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the request is a JSON request
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if (strpos($contentType, 'application/json') !== false) {
        // Receive the RAW post data
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        // Get sender, receiver details and message
        $sender_id = $data['sender_id'];
        $sender_type = $data['sender_type'];
        $receiver_id = $data['receiver_id'];
        $receiver_type = $data['receiver_type'];
        $message = $data['message'] ?? '';
        $message_type = 'text';
        $media_path = null;

        // Insert the message into the database using procedural MySQLi
        $query = "INSERT INTO messages (sender_id, sender_type, receiver_id, receiver_type, message, media_path, message_type)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "isissss", $sender_id, $sender_type, $receiver_id, $receiver_type, $message, $media_path, $message_type);

        // Execute the statement and send a JSON response
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
        }

        mysqli_stmt_close($stmt);

    } elseif (!empty($_FILES['media'])) {
        // Handle media upload (e.g., images, videos)
        $sender_id = $_POST['sender_id'];
        $sender_type = $_POST['sender_type'];
        $receiver_id = $_POST['receiver_id'];
        $receiver_type = $_POST['receiver_type'];
        $message = $_POST['message'] ?? '';

        $file = $_FILES['media'];
        $media_dir = 'uploads/';
        $file_name = time() . '_' . basename($file['name']);
        $file_path = $media_dir . $file_name;
        $file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            $media_path = $file_path;
            $message_type = in_array($file_type, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : 'video';

            // Insert the message with media into the database
            $stmt = $connection->prepare("INSERT INTO messages (sender_id, sender_type, receiver_id, receiver_type, message, media_path, message_type) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("isissss", $sender_id, $sender_type, $receiver_id, $receiver_type, $message, $media_path, $message_type);

            // Execute the statement and send a JSON response
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'media_path' => $media_path]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send message with media.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload media.']);
        }
    }
}

?>
