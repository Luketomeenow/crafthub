<?php
require 'dbcon.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receive the raw post data.
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Extract data from JSON
    $sender_id = $data['sender_id'];
    $sender_type = $data['sender_type'];
    $receiver_id = $data['receiver_id'];
    $receiver_type = $data['receiver_type'];
    echo $sender_id;
    echo $sender_type;
    echo $receiver_id;
    echo $receiver_type;

    // Prepare the SQL query
    $query = "
        SELECT * FROM messages
        WHERE
            (sender_id = ? AND sender_type = ? AND receiver_id = ? AND receiver_type = ?) OR
            (sender_id = ? AND sender_type = ? AND receiver_id = ? AND receiver_type = ?)
        ORDER BY created_at ASC
    ";

    // Initialize the prepared statement
    $stmt = mysqli_prepare($connection, $query);

    // Bind the parameters
    mysqli_stmt_bind_param(
        $stmt,
        "isisisis",
        $sender_id, $sender_type, $receiver_id, $receiver_type,
        $receiver_id, $receiver_type, $sender_id, $sender_type
    );

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the data and store it in an array
    $messages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }

    // Send the messages as a JSON response
    echo json_encode(['messages' => $messages]);

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>
