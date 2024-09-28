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
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/mdashboardallproducts.css">
    <link rel="stylesheet" href="css/mfooter.css">
    <link rel="stylesheet" href="css/mnavigation.css">
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
            <li class="mx-4 d-inline-block"><a href="morders.php">Orders</a></li>
            <li class="mx-4 d-inline-block"><a href="mchatroom.php">Messages</a></li>
            <li class="mx-4 d-inline-block"><a href="maccount.php">Settings</a></li>
            <li class="mx-4 d-inline-block"><a href="index.php">Logout</a></li>
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
            <a href="morders.php">Orders</a>
            <a href="maccount.php">Settings</a>
            <a href="index.php">Log out</a>
        </div>
    </nav>
</div>
<!--=============== END NAVIGATION ==============-->

<!--=============== ALL PRODUCTS CONTENT ===============-->
    <div class="container">
        <div class="row">
            <h1 class="card-title"><i class='bx bxl-product-hunt' id="all"></i> All Orders</h1>
        </div>
        <div class="row">
            <form action="#">
                <div class="form-input">
                    <input type="search" id="search" name="searchbar" placeholder="Search...">
                    <button type="submit" class="search-btn" name="btnsearch"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <hr class="solid1">
        </div>
        <!--=============== USER FEEDBACK AND RATINGS ===============-->
        <div class="row">
            <div class="col-md-1">
                <img src="images/craftsbg.png" id="product-image" alt="user image">
            </div>
            <div class="col">
                <div class="product-name">Product Name</div>
                <div class="product-desc">Product Description</div>
            </div>
            <div class="col">
                <div class="product-rating">Ratings <span class="star-ratings">★★★★★</span></div>
            </div>
            <hr class="solid1">
        </div>
        <div class="row">
            <div class="col-md-4 user-and-ratings">
                <img src="images/user.png" id="user-profile" alt="Product Image"> 
            </div>
            <div class="customer-name">Juliana Ysabelle Acena</div>
            <div class="variation">Variation: <span>Black, Brown</span></div>
            <div class="row">
                <div class="order-note"><input type="text" placeholder="Feedback Message" readonly></div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="user-details">
                        <div class="quality-rating">Product Quality</div>
                        <div class="rating">
                            <input type="radio" name="feedback1-rating" value="5" id="feedback1-5"><label for="feedback1-5"></label> 
                            <input type="radio" name="feedback1-rating" value="4" id="feedback1-4"><label for="feedback1-4"></label> 
                            <input type="radio" name="feedback1-rating" value="3" id="feedback1-3"><label for="feedback1-3"></label> 
                            <input type="radio" name="feedback1-rating" value="2" id="feedback1-2"><label for="feedback1-2"></label> 
                            <input type="radio" name="feedback1-rating" value="1" id="feedback1-1"><label for="feedback1-1"></label> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="user-details">
                        <div class="quality-rating">Seller Service</div>
                        <div class="rating">
                            <input type="radio" name="feedback2-rating" value="5" id="feedback2-5"><label for="feedback2-5"></label> 
                            <input type="radio" name="feedback2-rating" value="4" id="feedback2-4"><label for="feedback2-4"></label> 
                            <input type="radio" name="feedback2-rating" value="3" id="feedback2-3"><label for="feedback2-3"></label> 
                            <input type="radio" name="feedback2-rating" value="2" id="feedback2-2"><label for="feedback2-2"></label> 
                            <input type="radio" name="feedback2-rating" value="1" id="feedback2-1"><label for="feedback2-1"></label> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="user-details">
                        <div class="quality-rating">Delivery Speed</div>
                        <div class="rating">
                            <input type="radio" name="feedback3-rating" value="5" id="feedback3-5"><label for="feedback3-5"></label> 
                            <input type="radio" name="feedback3-rating" value="4" id="feedback3-4"><label for="feedback3-4"></label> 
                            <input type="radio" name="feedback3-rating" value="3" id="feedback3-3"><label for="feedback3-3"></label> 
                            <input type="radio" name="feedback3-rating" value="2" id="feedback3-2"><label for="feedback3-2"></label> 
                            <input type="radio" name="feedback3-rating" value="1" id="feedback3-1"><label for="feedback3-1"></label> 
                        </div>
                    </div>
                </div>
                <!--=============== ATTACHED IMAGES ===============-->
                <div class="row">
                    <div class="image-attachment">Attached Images</div>
                    <div class="col-md-1 buyer-img">
                        <img src="images/craftsbg.png" id="buyerimg" alt="user image">
                    </div>
                </div>
            </div>
            <hr class="solid1">
        </div>
    </div>
    
</body>
</html>
