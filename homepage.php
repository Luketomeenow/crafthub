<?php
    session_start();
    include 'dbcon.php';
    $user_id = $_SESSION['userID'];

   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--=============== BOXICONS ===============-->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/homepage.css">
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
            <a href="mchatroom.php?chat_with_id=4&chat_with_type=user&user_id=4">Messages</a>
            <a href="cart.php">Cart</a>
            <a href="accountsettings.php">Account</a>
            <a href="mypurchase.php">My Purchase</a>
            <a href="storemap.php">Store Map</a>
            <a href="index.php">Log out</a>
        </div>
    </nav>
</div>
<!--=============== END NAVIGATION ==============-->

    <!--=============== HOMEPAGE HEADER ==============-->

    <section class="header">
        <div class="header_container">
            <div id="headerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/slide1.jpeg" alt="Header Image 1">
                    </div>
                    <div class="carousel-item">
                        <img src="images/slide2.jpeg" alt="Header Image 2">
                    </div>
                    <div class="carousel-item">
                        <img src="images/slide3.jpeg" alt="Header Image 3">
                    </div>
                    <div class="carousel-item">
                        <img src="images/slide4.jpeg" alt="Header Image 4">
                    </div>
                </div>
            </div>
            <div class="header-content">
                <h1 class="header-title">CraftHub</h1>
                <h5 class="header-description">Where Creativity Meets Community</h5>
                <p class="subtitle">Connecting Creators and Collectors</p>
                <button id="shopNowBtn" class="shop-now-btn">Shop Now</button>
            </div>
        </div>
    </section>
    <!--=============== END OF HOMEPAGE HEADER ==============-->

        <!--=============== PRODUCT CONTAINER ===============-->
        <div class="container-fluid">

            <?php
            // Assuming you're fetching categories and products dynamically from the database
            $selectCategories = "SELECT DISTINCT category FROM merchant_products ORDER BY category ASC";
            $categories = $connection->query($selectCategories);

            if ($categories->num_rows > 0) {
                while ($category = $categories->fetch_assoc()) {
                    $categoryName = $category['category'];
                    echo "<div class='category-header my-4'><h1>" . $categoryName . "</h1></div>";

                    // Fetch products for this category
                    $selectProducts = "SELECT * FROM merchant_products  WHERE category = '$categoryName'";
                    $products = $connection->query($selectProducts);

                    if ($products->num_rows > 0) {
                        echo "<div class='row'>"; // Start a row for product cards
                        while ($product = $products->fetch_assoc()) {
                            ?>

                            <!-- Dynamic Product Card -->
                            <div class="col-md-3 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="<?php echo 'uploads/' . $product['product_img']; ?>" alt="Product Image" class="img-fluid">
                                    </div>
                                    <div class="product-details">
                                        <h5 class="product-name"><?php echo $product['product_name']; ?></h5>
                                        <a href="buynow.php?product_id=<?php echo $product['product_id']; ?>">
                                            <button class="buybtn" name="buy-now">View Product</button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                        echo "</div>"; // Close the row
                    } else {
                        echo "<p>No products available in this category.</p>";
                    }
                }
            } else {
                echo "<p>No categories found.</p>";
            }

            ?>
        </div>
        <!--=============== END PRODUCT CONTAINER ===============-->

    <!--=============== FOOTER ===============-->
    <footer>
        <div class="row">
            <div class="col-md-4 column1">
                <h1>Information</h1>
                <hr class="solid">
                <ul>
                    <li><a href="">About Us</a></li>
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
    <!--=============== END FOOTER ===============-->

<!--=============== SCRIPTS ===============-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybAIXeBDSQRdXpTWoE1lYapOdr9cGldeu/fla/hZ7Am4p6pDl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-HoA6Hk6t7nU+2D8ID2Faz+7Cl4jPYI4H2k6AEfOZlO4LBp3+NUDqqr0R3lRYAMSs" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="js/homepage.js"></script>

</body>
</html>
