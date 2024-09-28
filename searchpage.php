<?php

include 'dbcon.php';

// Initialize the base query
$query = "SELECT * FROM merchant_products WHERE 1=1";

// Check if a search query is present in the URL (GET request)
if (isset($_GET['searchbar']) && !empty($_GET['searchbar'])) {
    $searchQuery = mysqli_real_escape_string($connection, $_GET['searchbar']);
    
    // Modify the query to search both product_name and product_desc
    $query .= " AND (product_name LIKE '%$searchQuery%' OR product_desc LIKE '%$searchQuery%')";
}

// Execute the query
$result = mysqli_query($connection, $query);

// Check if the query failed
if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
}

// Display the search input field with the existing keyword
$existingSearchQuery = isset($_GET['searchbar']) ? htmlspecialchars($_GET['searchbar']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--=============== REMIXICONS ==============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--=============== BOXICONS ==============-->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="css/searchpage.css" rel="stylesheet">
    <link href="css/navigation.css" rel="stylesheet">
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
                            <input type="search" name="searchbar" id="searchbar"  value="<?php echo $existingSearchQuery; ?>"  placeholder="Search...">
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
    <!--=============== BACKGROUND WALLPAPER ==============-->
    <img src="images/searchbg.jpg" alt="Background Image" class="background-image">




    <!--=============== SEARCH ==============-->
        <div class="input-group" id="categ">        
    <!--=============== BUTTONS ===============-->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-light category-btn" data-category="Accessories">Accessories</button>
                <button type="button" class="btn btn-light category-btn" data-category="Coasters">Coasters</button>
                <button type="button" class="btn btn-light category-btn" data-category="Dining">Dining</button>
                <button type="button" class="btn btn-light category-btn" data-category="Decors">Decors</button>
                <button type="button" class="btn btn-light category-btn" data-category="Furniture">Furniture</button>
                
                <button type="button" class="btn btn-light category-btn" data-category="Lighting">Lighting</button>
                <button type="button" class="btn btn-light category-btn" data-category="Kitchen">Kitchen</button>
                

                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    <span id="category_search_concept">Others</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu scrollable-dropdown" role="menu"> <!--=============== DROPDOWN MENU ===============-->
                    <li><a href="#" class="dropdown-item category-item">Rugs</a></li> 
                    <li><a href="#" class="dropdown-item category-item">Tables</a></li>
                    <li><a href="#" class="dropdown-item category-item">Storage</a></li>
                    
                    <li><a href="#" class="dropdown-item category-item">Trays</a></li>
                    <li><a href="#" class="dropdown-item category-item">Other Products</a></li>
                </ul>
            </div>
        </div>
<!--=============== SEARCH RESULTS ===============-->
    <div class="search-results">
         <p id="search-results-text">Search Results for: </p>
         <p id="selected-category-text"></p>
    </div>
    <!--=============== END OF NAV TABS ==============-->



<!--=============== PRODUCT CARDS ===============-->
    <div id="product-container">
    <?php
    // Fetch and display the products
    while ($row = mysqli_fetch_assoc($result)) {
        $imagePath = 'uploads/' . basename($row['product_img']);

        echo '<div class="product-card">';
        echo '    <div class="product-image">';
        echo '        <img src="' . htmlspecialchars($imagePath) . '" alt="Product Image">';
        echo '    </div>';
        echo '    <div class="product-details">';
        echo '        <h5 class="product-name">' . htmlspecialchars($row['product_name']) . '</h5>';
        echo '        <a href="buynow.php?product_id=' . $row['product_id'] . '">';
        echo '            <button class="buybtn" name="buy-now">View Product</button>';
        echo '        </a>';
        echo '    </div>';
        echo '</div>';
    }

    // Close the connection
    mysqli_close($connection);
    ?>
    </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


  <!--=============== JAVASCRIPT FOR DROPDOWN AND SEARCH ==============-->
  <script>
$(document).ready(function() {
    // Function to handle category filtering
    function fetchProducts(category) {
        $.ajax({
            type: "POST",
            url: "fetch_products.php",
            data: { category: category },
            success: function(response) {
                $("#product-container").html(response); // Replace the product container with the fetched products
            },
            error: function(xhr, status, error) {
                console.error('Error fetching products:', error);
            }
        });
    }

    // When a category button is clicked
    $(".category-btn").click(function() {
        var selectedCategory = $(this).data("category"); // Get the category from the data attribute
        fetchProducts(selectedCategory); // Call the fetchProducts function with the selected category
    });

    // When a dropdown category is clicked
    $(".dropdown-item").click(function() {
        var selectedCategory = $(this).text(); // Get the category from the dropdown text
        fetchProducts(selectedCategory); // Call the fetchProducts function with the selected category
    });
});
</script>


</body>
</html>
