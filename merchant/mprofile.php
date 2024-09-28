<?php 
    include 'dbcon.php';
    session_start();
    $merchant_id = $_SESSION['merchant_id'];

    $query = "SELECT reg_id, merchant_profile FROM crafthub_merchant WHERE merchant_id = '$merchant_id'";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $reg_id = $row['reg_id'];
            $current_profile_image = $row['merchant_profile'];
        } else {    
            echo "No registration ID found for this merchant.";
            $current_profile_image = 'images/user.png'; 
            exit;
        }
        
    $selectproduct = "SELECT * FROM merchant_products WHERE merchant_id = '$merchant_id'";
    $product = $connection->query($selectproduct);

    $product_count = $product->num_rows;
    
    $shopQuery = "
        SELECT cma.shop_name 
        FROM crafthub_merchant cm
        JOIN crafthub_merchant_applicant cma ON cm.reg_id = cma.reg_id
        WHERE cm.merchant_id = '$merchant_id'
    ";
    $shopResult = $connection->query($shopQuery);

    if ($shopResult && $shopResult->num_rows > 0) {
        $shopRow = $shopResult->fetch_assoc();
        $shop_name = $shopRow['shop_name'];
    } else {
        $shop_name = "Unknown Shop"; 
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--=============== BOXICONS ===============-->
	  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/mprofile.css">
    <link rel="stylesheet" href="css/mnavigation.css">
    <link rel="stylesheet" href="css/mfooter.css">
    
</head>
<body>
   <!--=============== NAVIGATION ==============-->
   <div class="flexMain sticky-top py-4" id="mainNavigation">
    <div class="flex3">
        <ul class="list-unstyled d-md-block">
            <li class="mx-4 d-inline-block"><a href="mdashboard.php" class="logo"><img src="images/navlogo.png"></a></li>
        </ul>
    </div>
    <div class="flex5">
        <ul class="list-unstyled navigation-menu">
            <li class="mx-4 d-inline-block"><a href="mdashboard.php">Dashboard</a></li>
            <li class="mx-4 d-inline-block"><a href="mprofile.php">Products</a></li>
            <li class="mx-4 d-inline-block"><a href="mchatroom.php">Messages</a></li>
            <li class="mx-4 d-inline-block"><a href="maccount.php">Settings</a></li>
            <li class="mx-4 d-inline-block"><a href="../login.php">Logout</a></li>
        </ul>
    </div>
    <nav class="responsive">
        <input type="checkbox" id="sidebar-active">
        <label for="sidebar-active" class="open-sidebar-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="42" viewBox="0 -960 960 960" width="32">
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
            <a href="mprofile.php">Profile</a>
            <a href="mchatroom.php">Messages</a>
            <a href="maccount.php">Settings</a>
            <a href="index.php">Log out</a>
        </div>
    </nav>
</div>
<!--=============== END NAVIGATION ==============-->


 <!--=============== HEADER ===============-->
    <div class="container-fluid">
        <div class="row position-relative">
            <img src="images/craftsbg.png" id="header-image" alt="header-image" class="img">
            <div class="merchant-info">
                <img src="<?php echo '../uploads/' .  $current_profile_image; ?>" id="merchant-image" alt="merchant-image">
                <div class="merchant-details">
                    <p class="merchant-name"><?php echo $shop_name; ?></p>
                    <div class="shop-rating">
                    <span class="rating">Shop Rating</span>
                            <span class="rating-stars"> 
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
                                <span class="rating-text"><?php echo $average_service_rating; ?> (<?php echo $total_service_ratings; ?> ratings)</span>
                            </span></p>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--=============== END HEADER ===============-->



        <!--=============== PRODUCTS ===============-->
            <div class="container-fluid">
                <div class="row position-relative">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="heading-with-count">My Products <span class="product-count"><?php echo $product_count; ?></span></h4>
                            <!--=============== SEARCH BAR ===============-->
                            <div class="search-bar">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search product...">
                                    <span class="input-group-text"><i class='bx bx-search'></i></span>
                                </div>
                            </div>
                        </div>
                            <div class="line-container">
                                <hr class="line">
                            </div>
                                <!--=============== ADD PRODUCT BUTTON ===============-->
                                <div class="btnupload">
                                    <button class="uploadbtn"><a href="maddproduct.php">Add Product</a></button>
                                </div>
                                    <div class="product-container">
                                        <!--=============== PRODUCT CARDS WILL GO HERE ===============-->
                                        <?php 
                                            while($row = mysqli_fetch_assoc($product)){
                                        ?>
                                                <div class="product-card">
                                                    <div class="product-image">
                                                        <img src="<?php echo '../uploads/' . $row['product_img']; ?>" alt="Product Image">
                                                    </div>
                                                    <div class="product-details">
                                                        <h2 class="product-name"><?php echo $row['product_name'];   ?></h2>
                                                        <button class="updatebtn"><a href="meditproduct.php?product_id=<?php echo $row['product_id'] ?>">Update</a></button>
                                                    </div>
                                                </div>

                                                <?php 
                                                }
                                            ?>
                                    </div>
                    </div>
                </div>
            </div>
<!--=============== END OF PRODUCTS ===============-->


    <!--=============== FOOTER ===============-->
    <footer>
            <div class ="row">
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
<!--=============== END FOOTER ===============-->
   
<!--=============== SCRIPTS ===============-->
<script src="js/imgpreviewproducts.js"></script>
<script src="js/deleteproduct.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybAIXeBDSQRdXpTWoE1lYapOdr9cGldeu/fla/hZ7Am4p6pDl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-HoA6Hk6t7nU+2D8ID2Faz+7Cl4jPYI4H2k6AEfOZlO4LBp3+NUDqqr0R3lRYAMSs" crossorigin="anonymous"></script>

</body>
</html>
