<?php 
    include 'dbcon.php';
    session_start();
    
    $user_id = $_SESSION['userID'];
    

    if(isset($_GET['order_id'])){
        $order_id = $_GET['order_id'];

        $select = "SELECT
                    o.product_id,
                    o.order_id, 
                    p.product_img, 
                    p.product_name

                FROM 
                    orders o
                JOIN 
                    merchant_products p ON o.product_id = p.product_id
                WHERE 
                    o.order_id = '$order_id' AND o.status = 'order received'";

                    $result = mysqli_query($connection, $select);

                    if(!$result){
                        die("query Failed".mysqli_error($connection));
                    }else{
                        $row = mysqli_fetch_assoc($result);

                    }

                }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/rateproduct.css">
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
    <form action="process_feedback.php" method="post">
        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
        <!--=============== PRODUCT CONTAINER ===============-->
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="product-image-container">
                        <img id="product-image" class="product-image" src="<?php echo 'uploads/' . basename($row['product_img']); ?>" alt="Product Image">
                    </div>
                </div>
                <div class="col-md-9 product-details mt-5">
                    <h6>Product Name</h6>
                    <p><?php echo $row['product_name']; ?></p>
                </div>
            </div>
            <!--=============== END OF PRODUCT CONTAINER ===============-->
            
            <!--=============== PRODUCT REVIEW HEADER ===============-->
            <div class="review-header">
                Product Review
            </div>

           <!--=============== RATINGS AND FEEDBACK FORM ===============-->
           <div class="row">
                <div class="col-md-3">
                    <h6>Product Quality</h6> <!--=============== PRODUCT QUALITY ===============-->
                </div>
                <div class="col-md-9">
                    <div class="rating"> 
                        <input type="radio" name="quality-rating" value="5" id="quality-5"><label for="quality-5">☆</label>
                        <input type="radio" name="quality-rating" value="4" id="quality-4"><label for="quality-4">☆</label> 
                        <input type="radio" name="quality-rating" value="3" id="quality-3"><label for="quality-3">☆</label>
                        <input type="radio" name="quality-rating" value="2" id="quality-2"><label for="quality-2">☆</label>
                        <input type="radio" name="quality-rating" value="1" id="quality-1"><label for="quality-1">☆</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <h6>Product Price</h6> <!--=============== PRODUCT PRICE ===============-->
                </div>
                <div class="col-md-9">
                    <div class="rating"> 
                        <input type="radio" name="price-rating" value="5" id="price-5"><label for="price-5">☆</label> 
                        <input type="radio" name="price-rating" value="4" id="price-4"><label for="price-4">☆</label> 
                        <input type="radio" name="price-rating" value="3" id="price-3"><label for="price-3">☆</label> 
                        <input type="radio" name="price-rating" value="2" id="price-2"><label for="price-2">☆</label> 
                        <input type="radio" name="price-rating" value="1" id="price-1"><label for="price-1">☆</label> 
                    </div>
                </div>
            </div>

            <div class="row"> 
                <div class="col-md-3">
                    <h6>Seller Service</h6> <!--=============== SELLER SERVICE ===============-->
                </div>
                <div class="col-md-9">
                    <div class="rating"> 
                        <input type="radio" name="service-rating" value="5" id="service-5"><label for="service-5">☆</label>
                        <input type="radio" name="service-rating" value="4" id="service-4"><label for="service-4">☆</label>  
                        <input type="radio" name="service-rating" value="3" id="service-3"><label for="service-3">☆</label> 
                        <input type="radio" name="service-rating" value="2" id="service-2"><label for="service-2">☆</label> 
                        <input type="radio" name="service-rating" value="1" id="service-1"><label for="service-1">☆</label> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-3">
                    <textarea class="form-control" rows="3" id="notes" name="notes" placeholder="Enter your feedback here..."></textarea>
                </div>
            </div>

            <!--=============== SUBMIT FEEDBACK BUTTON ===============-->
            <div class="row mt-3">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success" id="submit-btn" name="submit" value="Submit Feedback">
                </div>
            </div>
            <!--=============== END OF SUBMIT FEEDBACK BUTTON ===============-->
        </div>
    </form>
    <!--=============== END OF FORM ===============-->
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
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>