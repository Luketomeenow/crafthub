<?php

session_start();
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['place_order'])) {
    header('Location: checkout.php');
    exit;
}

if (!isset($_POST['cart_items']) || !is_array($_POST['cart_items'])) {
    // Redirect to cart if no items were selected
    header('Location: cart.php');
    exit;
}

$cart_items = $_POST['cart_items']; // Array of selected cart item IDs
$user_id = $_SESSION['userID'];
$msg = isset($_POST['msg']) ? mysqli_real_escape_string($connection, $_POST['msg']) : '';
$payment_method = mysqli_real_escape_string($connection, $_POST['payment_method']);

// Fetch the details of the selected cart items
$items = [];
foreach ($cart_items as $cart_id) {
    $query = "SELECT c.*, p.product_name 
            FROM cart c 
            JOIN merchant_products p ON c.product_id = p.product_id 
            WHERE c.cart_id = '$cart_id' AND c.user_id = '$user_id' AND c.status = 'cart'";
    $result = mysqli_query($connection, $query);
    
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    if (mysqli_num_rows($result) > 0) {
        $items[] = mysqli_fetch_assoc($result);
    } else {
        die("Invalid cart item: $cart_id");
    }
}

// Insert order items into the orders table
foreach ($items as $item) {
    $product_id = $item['product_id'];
    $product_color = $item['product_color'];
    $product_size = $item['product_size'];
    $quantity = $item['quantity'];
    $price = $item['price']; // Fetching price from cart

    $order_query = "INSERT INTO orders (user_id, product_id, product_color, product_size, quantity, total, payment_method, user_note, status) 
                    VALUES ('$user_id', '$product_id', '$product_color', '$product_size', '$quantity', '$price', '$payment_method', '$msg', 'to pay')";

    if (!mysqli_query($connection, $order_query)) {
        die("Order insertion failed: " . mysqli_error($connection));
    }
}

// Update cart status
$update_cart_query = "UPDATE cart SET status = 'ordered' WHERE cart_id IN ('" . implode("','", $cart_items) . "') AND user_id = '$user_id'";

if (!mysqli_query($connection, $update_cart_query)) {
    die("Cart update failed: " . mysqli_error($connection));
}

// Redirect to order confirmation page or display a success message
echo "<script>
    alert('Order placed successfully! Thank you for shopping with us.');
    setTimeout(function() {
        window.location.href = 'mypurchase.php';
    }, 2000); // redirect after 2 seconds
    </script>";
exit;
?>
