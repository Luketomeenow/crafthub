<?php
require 'dbcon.php';

$merchant_id = $_GET['merchant_id'];
$customer_id = $_GET['customer_id'];

$stmt = $connection->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at ASC");
$stmt->bind_param("iiii", $merchant_id, $customer_id, $customer_id, $merchant_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
