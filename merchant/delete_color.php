<?php
include 'dbcon.php';

$data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $color_id = $data['id'];
        $query = "DELETE FROM product_color WHERE color_id = '$color_id'";

        if (mysqli_query($connection, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($connection)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid ID']);
    }
?>
