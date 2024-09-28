<?php 
    include 'dbcon.php';
    session_start();
    $user_id = $_SESSION['userID'];
    
    $carts = "SELECT
                c.*, 
                p.product_img, 
                p.product_name 

            FROM 
                cart c
            JOIN 
                merchant_products p ON c.product_id = p.product_id
            WHERE 
                c.user_id = '$user_id' AND c.status = 'cart'";


        $result = $connection->query($carts);

        if (!$result) {
            die("Query failed: " . $connection->error);
        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--=============== BOXICONS ===============-->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!--=============== FONT AWESOME ===============-->
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/navigation.css">
    <link rel="stylesheet" href="css/footer.css">
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

<!--=============== CART ===============-->
        <div class="container">
            <div class="row">
                <form method="post" action="cartcheckout.php">
                    <h2>My Cart</h2>
                    <hr class="line">

                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <!-- Start cart item -->
                        <div class="cart-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Checkbox -->
                                <input type="checkbox" class="option__check-input" id="option-check" name="cart_items[]" value="<?php echo $row['cart_id']; ?>">

                                <!-- Product Image -->
                                <img src="<?php echo 'uploads/' . basename($row['product_img']); ?>" class="rounded" height="90" width="120">

                                <!-- Product Name -->
                                <div><h6><?php echo $row['product_name']; ?></h6></div>

                                <!-- Product Quantity with Buttons -->
                                <div>
                                    <h6>Quantity: </h6>
                                    <div class="product-quantity">
                                        <!-- Increment and Decrement buttons with data-unit-price -->
                                        <button type="button" class="btn btn-sm btn-secondary minus-btn" data-unit-price="<?php echo $row['price']; ?>" onclick="decrementQuantity(this, <?php echo $row['price']; ?>)">-</button>
                                        <p class="quantity"><?php echo $row['quantity']; ?></p>
                                        <button type="button" class="btn btn-sm btn-primary add-btn" data-unit-price="<?php echo $row['price']; ?>" onclick="incrementQuantity(this, <?php echo $row['price']; ?>)">+</button>

                                    </div>
                                </div>

                                <!-- Unit Price (Hidden) -->
                                <div class="unit-price" style="display: none;"><?php echo $row['price']; ?></div>

                                <!-- Total Price -->
                                <div><h6>Total Price: </h6> <p class="total-price"><?php echo $row['price'] * $row['quantity']; ?></p></div>

                                <!-- Size -->
                                <div><h6>Size: </h6> <p><?php echo $row['product_size']; ?></p></div>

                                <!-- Color -->
                                <div><h6>Color: </h6> <p><?php echo $row['product_color']; ?></p></div>
                                <!-- Remove Button -->
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-danger remove-product" data-product-id="<?php echo $row['cart_id']; ?>">Remove</button>
                                </div>
                            </div>
                            <hr class="line">
                        </div>
                        <!-- End cart item -->

                    <?php } ?>

                    <button type="submit" class="btn btn-success" id="buybtn" name="btnall">Proceed to Checkout</button>
                </form>
            </div>
        </div>
<!--=============== END OF CART ===============-->

<!--=============== FOOTER ===============-->
    <footer>
        <div class="row">
            <div class="col-md-4 column1">
                <h1>Information</h1>
                <hr class="solid">
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div> 
            <div class="col-md-4 column2">
                <h1>Contact Us</h1>
                <hr class="solid">
                <ul>
                    <li>Mobile Phone: +63 000 0000 000</li>
                    <li>Landline/Hotline: 633 - 000</li>
                    <li>Email: crafthub@gmail.com</li>
                    <li>Address: 1234 Balanga City, Bataan</li>
                </ul>
            </div>
            <div class="col-md-2 column3">
                <h1>Location</h1>
                <hr class="solid">
                <ul>
                    <li><a href="#">Store Map</a></li>
                </ul>
            </div>
            <div class="col-md-2 column4">
                <h1>Follow Us</h1>
                <hr class="solid">
                <ul class="icon-list">
                    <li><i class="ri-facebook-circle-fill icon"></i> Facebook</li>
                    <li><i class="ri-instagram-fill icon"></i> Instagram</li>
                    <li><i class="ri-google-fill icon"></i> Gmail</li>
                </ul>
            </div>    
        </div>
    </footer>
    <!--=============== END OF FOOTER ===============-->

<!--=============== JAVASCRIPT ===============-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all the remove buttons
        const removeButtons = document.querySelectorAll('.remove-product');
        const incrementButtons = document.querySelectorAll('.add-btn');
        const decrementButtons = document.querySelectorAll('.minus-btn');

        // Handle product removal
        removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = button.getAttribute('data-product-id');
            const cartItem = button.closest('.cart-item'); 

            // Debugging log
            console.log('Product ID to remove:', productId);

            fetch('remove_from_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ cart_id: productId }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response from server:', data);

                if (data.success) {
                    // Remove the product element from the DOM
                    cartItem.remove();
                } else {
                    console.log('Failed to remove product. Error: ', data.error);
                    alert('Failed to remove the product.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

        // Handle incrementing quantity
        incrementButtons.forEach(button => {
            button.addEventListener('click', function() {
                const unitPrice = parseFloat(button.getAttribute('data-unit-price'));
                incrementQuantity(button, unitPrice);
            });
        });

        // Handle decrementing quantity
        decrementButtons.forEach(button => {
            button.addEventListener('click', function() {
                const unitPrice = parseFloat(button.getAttribute('data-unit-price'));
                decrementQuantity(button, unitPrice);
            });
        });

        // Increment quantity function
        function incrementQuantity(button, unitPrice) {
            var quantityElement = button.parentElement.querySelector('.quantity');
            var currentQuantity = parseInt(quantityElement.textContent);

            // Update the quantity
            quantityElement.textContent = currentQuantity + 1;

            // Update the total price based on the new quantity
            updatePrice(button, unitPrice);

            // Get the product ID for updating the database
            const productId = button.closest('.cart-item').querySelector('.remove-product').getAttribute('data-product-id');

            // Call the function to update the quantity in the database
            updateQuantityInDatabase(productId, currentQuantity + 1);
        }

        // Decrement quantity function
        function decrementQuantity(button, unitPrice) {
            var quantityElement = button.parentElement.querySelector('.quantity');
            var currentQuantity = parseInt(quantityElement.textContent);

            if (currentQuantity > 1) {
                // Update the quantity
                quantityElement.textContent = currentQuantity - 1;

                // Update the total price based on the new quantity
                updatePrice(button, unitPrice);

                // Get the product ID for updating the database
                const productId = button.closest('.cart-item').querySelector('.remove-product').getAttribute('data-product-id');

                // Call the function to update the quantity in the database
                updateQuantityInDatabase(productId, currentQuantity - 1);
            }
        }

        // Update price function
        function updatePrice(button, unitPrice) {
            // Get the quantity
            var quantityElement = button.parentElement.querySelector('.quantity');
            var currentQuantity = parseInt(quantityElement.textContent);

            // Calculate the new total price
            var newTotalPrice = currentQuantity * unitPrice;

            // Find the closest .total-price element and update its value
            var totalPriceElement = button.closest('.cart-item').querySelector('.total-price');
            totalPriceElement.textContent = newTotalPrice;

            // Optionally, update the total price in the database (can be done via AJAX)
        }

        // Update quantity in the database
        function updateQuantityInDatabase(productId, newQuantity) {
            // Send AJAX request to update quantity in the database
            fetch('update_cart_quantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ cart_id: productId, quantity: newQuantity }),
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Failed to update the quantity in the database.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
</script>

</body>
</html>
