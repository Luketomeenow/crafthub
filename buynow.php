
<?php 
session_start();
include 'dbcon.php';

$product_sizes = [];
$product_color = [];
$merchant_id = null; 
$merchant_profile = 'images/user.png'; // Default profile image
$shop_name = '';
$product_count = 0;

if (isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($connection, $_GET['product_id']);

    // Query to get product details, sizes, colors, and merchant_id
    $select = mysqli_query($connection, "
        SELECT mp.*, ps.sizes, ps.price as size_price, pc.color, cm.merchant_profile, cm.merchant_id, cma.shop_name
        FROM `merchant_products` mp
        LEFT JOIN `product_sizes` ps ON mp.product_id = ps.product_id
        LEFT JOIN `product_color` pc ON mp.product_id = pc.product_id
        LEFT JOIN `crafthub_merchant` cm ON mp.merchant_id = cm.merchant_id
        LEFT JOIN `crafthub_merchant_applicant` cma ON cm.reg_id = cma.reg_id
        WHERE mp.product_id = '$product_id'
    ");

    if (!$select) {
        die('Query failed: ' . mysqli_error($connection));
    }

    if (mysqli_num_rows($select) > 0) {
        $seen_sizes = []; // Track seen sizes
        $seen_colors = []; // Track seen colors
        while ($row = mysqli_fetch_assoc($select)) {
            $fetch = $row;
            $merchant_id = $row['merchant_id']; // Get the merchant_id
            $merchant_profile = !empty($row['merchant_profile']) ? $row['merchant_profile'] : $merchant_profile;
            $shop_name = $row['shop_name'];
            $price = isset($_POST['price']) ? (float) $_POST['price'] : 0.0;

            if (!empty($row['sizes']) && !in_array($row['sizes'], $seen_sizes)) {
                $product_sizes[] = ['size' => $row['sizes'], 'price' => $row['size_price']];
                $seen_sizes[] = $row['sizes']; // Mark this size as seen
            }
            if (!empty($row['color']) && !in_array($row['color'], $seen_colors)) {
                $product_color[] = $row['color'];
                $seen_colors[] = $row['color']; // Mark this color as seen
            }
        }
    }
    if (!empty($product_sizes)) {
        // Extract the price values from the product sizes
        $prices = array_column($product_sizes, 'price');

        // Calculate the minimum and maximum price
        $min_price = min($prices);
        $max_price = max($prices);
    }

    // Count the number of products the merchant has
    $count_query = mysqli_query($connection, "SELECT COUNT(*) as product_count FROM merchant_products WHERE merchant_id = '$merchant_id'");
    if ($count_query && mysqli_num_rows($count_query) > 0) {
        $count_row = mysqli_fetch_assoc($count_query);
        $product_count = $count_row['product_count'];
    }
}
// Query to get the average rating for the product
$rating_query = mysqli_query($connection, "
    SELECT 
        AVG((quality_rating + price_rating) / 2) as average_rating, 
        COUNT(*) as total_ratings 
    FROM 
        product_feedback 
    WHERE 
        product_id = '$product_id'
");

$average_rating = 0;
$total_ratings = 0;

if ($rating_query && mysqli_num_rows($rating_query) > 0) {
    $rating_row = mysqli_fetch_assoc($rating_query);
    $average_rating = round($rating_row['average_rating'], 1); // Round to 1 decimal place
    $total_ratings = $rating_row['total_ratings'];
}
// Query to get the average service rating for the shop
$service_rating_query = mysqli_query($connection, "
    SELECT AVG(service_rating) as average_service_rating, 
           COUNT(*) as total_service_ratings
    FROM product_feedback pf
    INNER JOIN merchant_products mp ON pf.product_id = mp.product_id
    WHERE mp.merchant_id = '$merchant_id'
");

$average_service_rating = 0;
$total_service_ratings = 0;

if ($service_rating_query && mysqli_num_rows($service_rating_query) > 0) {
    $service_rating_row = mysqli_fetch_assoc($service_rating_query);
    $average_service_rating = round($service_rating_row['average_service_rating'], 1); // Round to 1 decimal place
    $total_service_ratings = $service_rating_row['total_service_ratings'];
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
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--=============== BOXICONS ===============-->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <!--=============== FONT AWESOME ===============-->
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/buynow.css">
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
                      
                        <li class="hideAtCustom mx-4 d-inline-block"><a href="chatroom.php?chat_with_id=10&chat_with_type=merchant&merchant_id=10"><i class="ri-chat-2-line"></i></a></li>
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

    <!--=============== PRODUCT CONTAINER ===============-->
    
    <form action="checkout.php" method="post" id="checkoutForm">
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($fetch['product_id']); ?>">
        <input type="hidden" name="merchant_id" value="<?php echo htmlspecialchars($fetch['merchant_id']); ?>">
        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch['product_name']); ?>">
        <input type="hidden" name="product_desc" value="<?php echo htmlspecialchars($fetch['product_desc']); ?>">
        <input type="hidden" name="product_image" value="<?php echo htmlspecialchars('uploads/' . basename($fetch['product_img'])); ?>">
        <input type="hidden" name="price" id="price" value="<?php echo htmlspecialchars($fetch['price']); ?>">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="product-image-container">
                        <img src="<?php echo 'uploads/'. basename($fetch['product_img']); ?>" alt="Product Image" class="product-image">
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="product-name"> <!--=============== PRODUCT NAME ===============-->
                        <h3><?php echo $fetch['product_name']; ?></h3>
                        <div class="row">
                            <div class="col-md-9">
                                <span class="star-rating"> 
                                    <?php 
                                    $filled_stars = floor($average_rating);
                                    $half_star = $average_rating - $filled_stars >= 0.5;
                                    $empty_stars = 5 - $filled_stars - ($half_star ? 1 : 0);

                                    // Filled stars
                                    for ($i = 0; $i < $filled_stars; $i++) {
                                        echo '<i class="ri-star-fill"></i>';
                                    }

                                    // Half star
                                    if ($half_star) {
                                        echo '<i class="ri-star-half-fill"></i>';
                                    }

                                    // Empty stars
                                    for ($i = 0; $i < $empty_stars; $i++) {
                                        echo '<i class="ri-star-line"></i>';
                                    }
                                    ?>
                                    <span class="rating-number"><?php echo $average_rating; ?> (<?php echo $total_ratings; ?> ratings)</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="price">
                        <label for="product-price"></label>
                        <p id="product-price">
                            <?php if (!empty($product_sizes)): ?>
                                <?php echo number_format($min_price, 2); ?> - <?php echo number_format($max_price, 2); ?>
                            <?php else: ?>
                                <?php echo number_format((float)str_replace(',', '', $fetch['price']), 2); ?> <!-- Format and sanitize the price -->
                            <?php endif; ?>
                        </p>
                    </div>


                    <?php if (!empty($product_sizes)): ?>
                        <!--=============== SIZES ===============-->
                        <div class="size-options">
                            Sizes:
                            <select id="size" name="size" class="custom-select" onchange="updatePrice()">
                                
                                <?php foreach ($product_sizes as $size): ?>
                                    <option value="<?php echo htmlspecialchars($size['size']); ?>" data-price="<?php echo $size['price']; ?>">
                                        <?php echo htmlspecialchars($size['size']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_color)): ?>
                        <!--=============== COLORS ===============-->
                        <div class="color-options">
                            Colors:
                            <select id="color" name="color" class="custom-select">
                                
                                <?php foreach ($product_color as $color): ?>
                                    <option value="<?php echo htmlspecialchars($color); ?>">
                                        <?php echo htmlspecialchars($color); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                        <!--=============== QUANTITY ===============-->
                        <div class="row" id="beforebtn">
                        <div class="col-md-6 product-quantity">
                            <div class="d-flex align-items-center">
                                Quantity: 
                                <div class="input-group qty-input"> 
                                    <button type="button" class="quantity-btn qty-count" onclick="decrementQuantity()">-</button>
                                    <input type="text" id="quantity" name="quantity" class="product-qty" value="1">
                                    <button type="button" class="quantity-btn qty-count" onclick="incrementQuantity()">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--=============== BUY NOW & ADD TO CART ===============-->
                    <div class="row" id="btn">
                        <div class="product-button">
                            <div class="button-group">
                                <button type="submit" id="buyNowLink" class="buy-btn">Buy Now</button>
                                <button type="button" id="addToCartBtn" class="buy-btn">Add to cart</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </form>  
    <!--=============== END PRODUCT CONTAINER ===============-->

   <!--=============== SHOP PROFILE CONTAINER ===============-->
            <div class="container-shop">
                <div class="row"> 
                    <div class="col-3 col-md-1 shop-profile"> 
                        <img src="<?php echo 'uploads/'. basename($fetch['merchant_profile']); ?>" id="shop-profile" alt="shop profile">  
                    </div> 
                    <div class="col-9 col-md-4 name"> 
                        <div class="shop-name mb-1">
                            <span><?php echo $fetch['shop_name']; ?></span>
                        </div> 
                        <div class="button-container d-flex align-items-center">
                            <a href="chatroom.php?chat_with_id=<?php echo $merchant_id;?>&chat_with_type=merchant&merchant_id=<?php echo $merchant_id;?>"><button type="submit" class="chat-btn">Chat Now</button></a>
                            <button type="submit" class="view-btn">View Shop</button>
                        </div>
                    </div> 
                    <div class="col-12 col-md-5 shop-rate">
                        <div class="seller-rate">
                            <p>Ratings: 
                            <span class="star-rating"> 
                                <?php 
                                $filled_stars = floor($average_service_rating);
                                $half_star = $average_service_rating - $filled_stars >= 0.5;
                                $empty_stars = 5 - $filled_stars - ($half_star ? 1 : 0);

                                // Filled stars
                                for ($i = 0; $i < $filled_stars; $i++) {
                                    echo '<i class="ri-star-fill"></i>';
                                }

                                // Half star
                                if ($half_star) {
                                    echo '<i class="ri-star-half-fill"></i>';
                                }

                                // Empty stars
                                for ($i = 0; $i < $empty_stars; $i++) {
                                    echo '<i class="ri-star-line"></i>';
                                }
                                ?>
                                <span class="rating-number"><?php echo $average_service_rating; ?> (<?php echo $total_service_ratings; ?> ratings)</span>
                            </span></p>
                            <p>Product Count: <span id="products-count"><?php echo $product_count; ?></span></p>
                        </div>
                    </div>
                </div> 
            </div>

            <!--=============== END SHOP PROFILE CONTAINER ===============-->

        <div class="container-description">
            <div class="row"> 
                <div class="col-md-12 product-info"> 
                    <div class="product-specs">
                        <div class="specs">Product Specification</div>
                        <hr class="solid"> 
                        <div class="specs-info">
                            <p>Category: <?php echo $fetch['category']; ?></p>
                            <p>Material: <?php echo $fetch['material']; ?></p>
                            <p>Stock: <?php echo $fetch['stock']; ?></p>
                        </div>
                    </div>
                    <div class="product-description mt-4"> 
                        <div class="description">Product Description</div> 
                        <hr class="solid"> 
                        <p><?php echo $fetch['product_desc']; ?></p>
                    </div> 
                </div> 
            </div> 
        </div>
        


    <!--=============== PRODUCT FEEDBACKS ===============-->
    <div class="container-feedback"> 
        <div class="row"> 
            <div class="col-md-12"> 
                <div class="product-feedback"> 
                    <div class="feedback">Feedbacks</div> 
                    <hr class="solid"> 
                </div> 
            </div> 
        </div> 

        <?php
        // Fetch feedback and user profiles
        $select_feedback = mysqli_query($connection, "
            SELECT f.*, cu.username, cu.user_profile 
            FROM product_feedback f 
            INNER JOIN crafthub_user cu ON f.user_id = cu.user_id 
            WHERE f.product_id = '$product_id'
        ") or die('Query failed: ' . mysqli_error($connection));

        while ($feedback = mysqli_fetch_assoc($select_feedback)) {
            // Determine the profile image to use
            $profile_image = !empty($feedback['user_profile']) ? 'uploads/' . $feedback['user_profile'] : 'images/user.png';
            ?>

        <!--=============== CUSTOMER DETAILS ===============-->
        <div class="row"> 
            <div class="col-md-1 user-and-ratings"> 
            <img src="<?php echo htmlspecialchars($profile_image); ?>" id="user-profile" alt="User Profile Image">              </div> 
            <div class="name mt-3 mb-3"> 
                <div class="customer-name">
                    <span>Name:</span> <?php echo htmlspecialchars($feedback['username']); ?>
                </div> 
                <div class="order-date">
                    <span>Date:</span> <?php echo htmlspecialchars($feedback['feedback_date']); ?>
                </div> 
                <div class="note">
                    <span>Note:</span> <?php echo htmlspecialchars($feedback['feedback_notes']); ?>
                </div>  
            </div> 
        </div> 
        <!--=============== PRODUCT RATING ===============-->
        <div class="user-details-container">
            <div class="user-details">
                Quality Rating:
                <span class="star-rating">
                    <?php echo str_repeat('<i class="ri-star-fill"></i>', $feedback['quality_rating']); ?>
                    <?php echo str_repeat('<i class="ri-star-line"></i>', 5 - $feedback['quality_rating']); ?>
                </span>
            </div>
            <div class="user-details">
                Service Rating:
                <span class="star-rating">
                    <?php echo str_repeat('<i class="ri-star-fill"></i>', $feedback['service_rating']); ?>
                    <?php echo str_repeat('<i class="ri-star-line"></i>', 5 - $feedback['service_rating']); ?>
                </span>
            </div>
            <div class="user-details">
                Price Rating:
                <span class="star-rating">
                    <?php echo str_repeat('<i class="ri-star-fill"></i>', $feedback['price_rating']); ?>
                    <?php echo str_repeat('<i class="ri-star-line"></i>', 5 - $feedback['price_rating']); ?>
                </span>
            </div>
        </div>     
        <hr class="solid"> 
        <?php
            }
        ?> 
    </div> 

    <!--=============== END PRODUCT FEEDBACKSS ===============-->

<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="js/homepage.js"></script>

        <script>
            function updatePrice() {
                const sizeSelect = document.getElementById('size');
                const priceDisplay = document.getElementById('product-price');
                const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
                const price = selectedOption.getAttribute('data-price');

                if (price) {
                    priceDisplay.textContent = parseFloat(price).toFixed(2);
                } else {
                    // If no size is selected, you may want to reset the price to the original range
                    const minPrice = '<?php echo number_format($min_price, 2); ?>';
                    const maxPrice = '<?php echo number_format($max_price, 2); ?>';
                    priceDisplay.textContent = `${minPrice} - ${maxPrice}`;
                }
                
                document.getElementById('price').value = price ? price.replace(/,/g, '') : '';
            }


            function incrementQuantity() {
                const quantityInput = document.getElementById('quantity');
                quantityInput.value = parseInt(quantityInput.value) + 1;
            }

            function decrementQuantity() {
                const quantityInput = document.getElementById('quantity');
                if (quantityInput.value > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                updatePrice();
            });

            document.getElementById('addToCartBtn').addEventListener('click', function() {
                const form = document.getElementById('checkoutForm');
                form.action = 'add_to_cart.php';
                form.method = 'post';
                form.submit();
            });

        </script>

</body>
</html>

        