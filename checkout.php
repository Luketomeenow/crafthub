<?php
    include 'dbcon.php';
    session_start();
    $user_id = $_SESSION['userID'];

    $product_id = $_POST['product_id'] ?? null;
    $merchant_id = $_POST['merchant_id'] ?? null;
    $product_name = $_POST['product_name'] ?? null;
    $product_desc = $_POST['product_desc'] ?? null;
    $product_image = $_POST['product_image'] ?? null;
    $size = $_POST['size'] ?? null;
    $color = $_POST['color'] ?? null;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.0;
    $total_price = $price * $quantity;

    $select_info = "SELECT * FROM `crafthub_user` WHERE `user_id` = '$user_id'";

    $result = mysqli_query($connection, $select_info);

    if (!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        $row = mysqli_fetch_assoc($result);
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
                <form action="place_order.php" method="POST">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?php echo htmlspecialchars($product_image); ?>" alt="Product Image" class="product-image" id="prod-img">
                            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product_image); ?>">
                        </div>
                        <div class="col-md-4">
                            <div class="product-details">
                                <p>Product Name:</p>
                                <p><?php echo htmlspecialchars($product_name); ?></p>
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="product-details">
                                <p>Price:</p>
                                <p id="price"><?php echo htmlspecialchars($price); ?></p>
                                <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-details">
                                <?php if ($size): ?>
                                    <div class="form-group">
                                        <label for="selected-size">Selected Size: <?php echo htmlspecialchars($size); ?></label>
                                        <input type="hidden" name="size" value="<?php echo htmlspecialchars($size); ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if ($color): ?>
                                    <div class="form-group">
                                        <label for="selected-color">Selected Color: <p><?php echo htmlspecialchars($color); ?></p></label>
                                        <input type="hidden" name="color" value="<?php echo htmlspecialchars($color); ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <div class="quantity-container">
                                        <button type="button" class="btn btn-primary" onclick="decrementQuantity()">-</button>
                                        <span id="quantity"><?php echo htmlspecialchars($quantity); ?></span> <!-- Changed from <p> to <span> -->
                                        <button type="button" class="btn btn-success" onclick="incrementQuantity()">+</button>
                                        <input type="hidden" name="quantity" id="quantity-input" value="<?php echo htmlspecialchars($quantity); ?>"> <!-- Ensure value is set initially -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-details">
                                <p>Sub total</p>
                                <span id="item-subtotal"><?php echo htmlspecialchars($total_price); ?></span>
                                <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total_price); ?>">
                            </div>
                            
                        </div>
                    </div>               
                    <hr class="dashed">
                    <!--=============== END OF PRODUCT ORDERED ===============-->


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

                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                    <input type="hidden" name="merchant_id" value="<?php echo htmlspecialchars($merchant_id); ?>">
                    <!--=============== PLACE ORDER ===============-->
                    <div class="card-button">
                        <button type="submit" class="btn btn-success" name="place_order">Place Order</button>
                    </div>
                    <!--=============== END OF PLACE ORDER ===============-->
                </form>
            </div>
        </div>
    </div>

    <!--=============== JAVASCRIPT FOR INCREMENT AND DECREMENT ===============-->
    <script>
        function incrementQuantity() {
            var quantityElement = document.getElementById('quantity');
            var quantityInput = document.getElementById('quantity-input');
            var currentQuantity = parseInt(quantityElement.textContent);
            var newQuantity = currentQuantity + 1;
            quantityElement.textContent = newQuantity;
            quantityInput.value = newQuantity;
            updateTotalAmount();
        }

        function decrementQuantity() {
            var quantityElement = document.getElementById('quantity');
            var quantityInput = document.getElementById('quantity-input');
            var currentQuantity = parseInt(quantityElement.textContent);
            if (currentQuantity > 1) {
                var newQuantity = currentQuantity - 1;
                quantityElement.textContent = newQuantity;
                quantityInput.value = newQuantity;
                updateTotalAmount();
            }
        }

        function updateTotalAmount() {
            var price = <?php echo $price; ?>;
            var quantity = parseInt(document.getElementById('quantity').textContent);
            var total = price * quantity;
            document.getElementById('item-subtotal').textContent = total.toFixed(2);
            document.getElementById('total-amount').textContent = total.toFixed(2);
        }
    </script>

</body>
</html>