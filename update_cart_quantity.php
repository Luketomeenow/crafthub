<?php
include 'dbcon.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['cart_id']) && isset($data['quantity'])) {
    $cart_id = $data['cart_id'];
    $newQuantity = $data['quantity'];

    // Update the quantity in the database
    $updateQuery = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param("ii", $newQuantity, $cart_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
?>
