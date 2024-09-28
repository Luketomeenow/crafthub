<?php 
    include 'dbcon.php';
    session_start();
    $merchant_id = $_SESSION['merchant_id'];

    $select = "SELECT 
                o.*, 
                cu.fname, 
                cu.mname, 
                cu.lname,
                cu.user_adds,
                cu.contact_no,
                mp.product_img,
                mp.product_name
                
            FROM 
                orders o
            JOIN 
                crafthub_user cu ON o.user_id = cu.user_id
            JOIN 
                merchant_products mp ON o.product_id = mp.product_id
            WHERE 
                mp.merchant_id = '$merchant_id' AND o.status = 'to pay'";
                

        $result = $connection->query($select);

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
    <!-- REMIXICONS -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/mfooter.css">
    <link rel="stylesheet" href="css/mnavigation.css">
</head>
<div>
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
            <a href="">Messages</a>
            <a href="maccount.php">Settings</a>
            <a href="index.php">Log out</a>
        </div>
    </nav>
</div>
<!--=============== END NAVIGATION ==============-->

<div class="container">
    <div class="row">
    <h1 class="card-title"><i class="fa-regular fa-clock" id="pending"></i> All Pending Orders</h1>
    </div>
    <div class="row">

                    <form action="#">
                    <div class="form-input">
                                <input type="search" id="search"name="searchbar" placeholder="Search...">
                                <button type="submit" class="search-btn" name="btnsearch"><i class='bx bx-search'></i></button>
                            </div>
                    </form>
                
                <hr class="solid1">
                </div>

        <?php
            while($row = mysqli_fetch_assoc($result)){

        ?>
            <div class="prod-container">
                   
                <div class="row">
                    <div class="col-md-10">
                        <div class="d-flex align-items-center">
                            <div class="order-details"><?php echo $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']. '  ' ; ?> <?php echo $row['contact_no']; ?>
                            <p><?php echo $row['user_adds']; ?></p>
                            
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="order-id-container">
                            <div class="order-id"><?php echo 'Order ID:   ' . $row['order_id']; ?></div>
                        </div>
                    </div>
                    </div>
                <div class="row">
                <div class="col-md-1">
                    <img src="<?php echo '../uploads/' . $row['product_img']; ?>" id="product-image" alt="user image">
                </div>
                <div class="col-md-2">
                    <div class="product-name"><?php echo $row['product_name']; ?></div>
                    <div class="order-date"><?php echo 'Order Date:   ' . $row['order_date']; ?></div>
                </div>
                <div class="col-md-2">
                    <div class="product-variation"><?php echo 'Size: ' . $row['product_size'] . ' |  Color: ' . $row['product_color']; ?></div>
                    <div class="product-quantity"><?php echo $row['quantity']; ?></div>
                </div>
                <div class="col-md-3">
                    <div class="order-note">Note: <input type="text" placeholder="Note to Customer" value = "<?php echo $row['user_note']; ?>" readonly></div>
                </div>
                <div class="col-md-3">
                    <div class="product-status">To Ship</div>
                </div>
                <div class="col-md-1">
                    <div class="product-price"><?php echo 'Total Price:   ' . $row['total']; ?></div>
                    <div class="product-detail">
                        <button type="button" class="btn btn-success delete-btn"><a href="update_order.php?order_id=<?php echo $row['order_id'] ?>">Prepare Order</a></button>
                    </div>
                </div>
                <hr class="solid4">
                </div>
            </div>

            <?php 
            }
            ?>
</div>


</body>
</html>