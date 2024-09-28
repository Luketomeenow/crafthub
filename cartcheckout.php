<?php
session_start();
include 'dbcon.php';

    if (!isset($_POST['cart_items'])) {
        // Redirect to cart if no items were selected
        header('Location: cart.php');
        exit;
    }

    $cart_items = $_POST['cart_items']; // Array of selected cart item IDs
    $user_id = $_SESSION['userID'];

    // Fetch the details of the selected cart items
    $items = [];
    foreach ($cart_items as $cart_id) {
        $query = "SELECT c.*, p.product_img, p.product_name 
                FROM cart c 
                JOIN merchant_products p ON c.product_id = p.product_id 
                WHERE c.cart_id = '$cart_id' AND c.user_id = '$user_id' AND c.status = 'cart'";
        $result = mysqli_query($connection, $query);
        
        if (!$result) {
            // Log the error
            die("Query failed: " . mysqli_error($connection));
        }

        if (mysqli_num_rows($result) > 0) {
            $items[] = mysqli_fetch_assoc($result);
        }
    }

    $selectuser = "SELECT * FROM crafthub_user WHERE user_id = '$user_id'";
    $result1 = mysqli_query($connection, $selectuser);
        
    if (!$result1) {
        // Log the error
        die("Query failed: " . mysqli_error($connection));
    }

    if (mysqli_num_rows($result1) > 0) {
        $row = mysqli_fetch_assoc($result1);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== REMIXICONS ==============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--=============== BOXICONS ==============-->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/checkout.css">
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
        <form id="searchForm" action="searchpage.php" method="get">
            <div class="form-input">
                <input type="search" name="searchbar" id="searchbar" placeholder="Search...">
                <button type="submit" class="search-btn" name="btnsearch"><i class='bx bx-search'></i></button>
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
            <button class="dropbtn"> Menu </button>
            <div class="dropdown-content">
                <a href="accountsettings.php">Account</a>
                <a href="mypurchase.php">My Purchases</a>
                <a href="storemap.php">Store Map</a>
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
            <a href="chatroom.php">Messages</a>
            <a href="cart.php">Cart</a>
            <a href="accountsettings.php">Account</a>
            <a href="mypurchase.php">My Purchase</a>
            <a href="storemap.php">Store Map</a>
            <a href="index.php">Log out</a>
        </div>
    </nav>
</div>
<!--=============== END NAVIGATION ==============--> 

    <!--=============== CHECKOUT CONTENT PAGE ===============-->
    <div class="container">
    <div class="row">
        <header class="header">
            <h1>Checkout</h1>
        </header>
    </div>
    <hr class="solid">

    <!--=============== DELIVERY DETAILS ===============-->
    <div class="row">
        <div class="delivery-header">
            <div>
                <h2><i class="fas fa-map-marker-alt"></i> Delivery Address</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="delivery-details">
                <p>Full Name: <?php echo $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']; ?></p>
                <p>Address: <?php echo $row['user_adds']; ?></p>
                <span>Phone Number: <?php echo $row['contact_no']; ?></span>
            </div>
        </div>
    </div>
    <hr class="dashed">
    <!--=============== END OF DELIVERY DETAILS ===============-->

    <!--=============== PRODUCT ORDERED ===============-->
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div>
                    <h2>Product Ordered</h2>
                </div>
            </div>
        </div>
        <form action="process_order.php" method="POST">
            <?php foreach ($items as $item) { ?>  <!-- Loop through each cart item -->
            <div class="row">
                <div class="col-md-2">
                    <img src="<?php echo htmlspecialchars('uploads/' . basename($item['product_img'])); ?>" alt="Product Image" class="product-image" id="prod-img">
                    <input type="hidden" name="product_images[]" value="<?php echo htmlspecialchars($item['product_img']); ?>">
                </div>
                <div class="col-md-4">
                    <div class="product-details">
                        <p>Product Name:</p>
                        <p><?php echo htmlspecialchars($item['product_name']); ?></p>
                        <input type="hidden" name="product_names[]" value="<?php echo htmlspecialchars($item['product_name']); ?>">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="product-details">
                        <p>Price:</p>
                        <p id="price"><?php echo htmlspecialchars($item['price']); ?></p>
                        <input type="hidden" name="prices[]" value="<?php echo htmlspecialchars($item['price']); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-details">
                        <?php if ($item['product_size']): ?>
                            <div class="form-group">
                                <label for="selected-size">Selected Size: <?php echo htmlspecialchars($item['product_size']); ?></label>
                                <input type="hidden" name="sizes[]" value="<?php echo htmlspecialchars($item['product_size']); ?>">
                            </div>
                        <?php endif; ?>
                        <?php if ($item['product_color']): ?>
                            <div class="form-group">
                                <label for="selected-color">Selected Color: <p><?php echo htmlspecialchars($item['product_color']); ?></p></label>
                                <input type="hidden" name="colors[]" value="<?php echo htmlspecialchars($item['product_color']); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <div class="quantity-container">
                                <button type="button" class="btn btn-primary" onclick="decrementQuantity(<?php echo $item['cart_id']; ?>)">-</button>
                                <span id="quantity-<?php echo $item['cart_id']; ?>"><?php echo htmlspecialchars($item['quantity']); ?></span>
                                <button type="button" class="btn btn-success" onclick="incrementQuantity(<?php echo $item['cart_id']; ?>)">+</button>
                                <input type="hidden" name="quantities[]" id="quantity-input-<?php echo $item['cart_id']; ?>" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="product-details">
                        <p>Sub total</p>
                        <span id="item-subtotal-<?php echo $item['cart_id']; ?>"><?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></span>
                        <input type="hidden" name="subtotals[]" value="<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?>">
                    </div>
                </div>
            </div>
            <hr class="dashed">
            <?php } ?> <!-- End of loop for multiple products -->
            
            <!--=============== MESSAGE AND SHIPPING ===============-->
            <div class="row custom-row">
                <div class="col-md-4 message-seller">
                    Message for Seller:
                    <input type="text" class="form-control" name="msg" placeholder="Enter your message here">
                </div>
            </div>
            <hr class="dashed">
            <!--=============== END OF MESSAGE AND SHIPPING ===============-->

            <!--=============== PAYMENT METHOD ===============-->
            <div class="row payment-header">
                <div class="form-group">
                    <label for="payment-method">Payment Method:</label>
                    <select id="payment-method" name="payment_method" class="form-control">
                        <option value="cash">Cash on delivery</option>
                        <option value="gcash">Gcash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select>
                </div>
            </div>
            <hr class="solid">
            <!--=============== END OF PAYMENT METHOD ===============-->
            <input type="hidden" name="cart_items[]" value="<?php echo $item['cart_id']; ?>">
            <input type="hidden" name="merchant_id" value="<?php echo htmlspecialchars($merchant_id); ?>">
            <!--=============== PLACE ORDER ===============-->
            <div class="card-button">
                <button type="submit" class="btn btn-success" name="place_order">Place Order</button>
            </div>
            <!--=============== END OF PLACE ORDER ===============-->
        </form>
    </div>
</div>

<!--=============== JAVASCRIPT FOR INCREMENT AND DECREMENT ===============-->
<script>
    function incrementQuantity(cartId) {
        var quantityElement = document.getElementById('quantity-' + cartId);
        var quantityInput = document.getElementById('quantity-input-' + cartId);
        var currentQuantity = parseInt(quantityElement.textContent);
        var newQuantity = currentQuantity + 1;
        quantityElement.textContent = newQuantity;
        quantityInput.value = newQuantity;
        updateTotalAmount(cartId);
    }

    function decrementQuantity(cartId) {
        var quantityElement = document.getElementById('quantity-' + cartId);
        var quantityInput = document.getElementById('quantity-input-' + cartId);
        var currentQuantity = parseInt(quantityElement.textContent);
        if (currentQuantity > 1) {
            var newQuantity = currentQuantity - 1;
            quantityElement.textContent = newQuantity;
            quantityInput.value = newQuantity;
            updateTotalAmount(cartId);
        }
    }

    function updateTotalAmount(cartId) {
        var price = parseFloat(document.getElementById('price').textContent);
        var quantity = parseInt(document.getElementById('quantity-' + cartId).textContent);
        var total = price * quantity;
        document.getElementById('item-subtotal-' + cartId).textContent = total.toFixed(2);
        // Optionally update the overall total if you have multiple products
    }
</script>


</body>
</html>