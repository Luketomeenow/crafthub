<?php
include 'dbcon.php';

$data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $size_id = $data['id'];
        $query = "DELETE FROM product_sizes WHERE size_id = '$size_id'";

        if (mysqli_query($connection, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($connection)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid ID']);
    }
?>
