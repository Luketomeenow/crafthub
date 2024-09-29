<?php
require 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON input and decode it
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Extract the data from the decoded JSON
    $sender_id = $data['sender_id'];
    $sender_type = $data['sender_type'];
    $receiver_id = $data['receiver_id'];
    $receiver_type = $data['receiver_type'];

    // Prepare the SQL statement using mysqli procedural style
    $query = "
        SELECT * FROM messages
        WHERE
            (sender_id = ? AND sender_type = ? AND receiver_id = ? AND receiver_type = ?) OR
            (sender_id = ? AND sender_type = ? AND receiver_id = ? AND receiver_type = ?)
        ORDER BY created_at ASC
    ";

    // Initialize the prepared statement
    $stmt = mysqli_prepare($connection, $query);

    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param(
        $stmt,
        "isisisis",
        $sender_id, $sender_type, $receiver_id, $receiver_type,
        $receiver_id, $receiver_type, $sender_id, $sender_type
    );

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result set from the prepared statement
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
