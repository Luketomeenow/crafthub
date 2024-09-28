
<?php 
    include 'dbcon.php';
    session_start();
    $user_id = $_SESSION['userID'];
    
    $to_pay = "SELECT
                o.*, 
                p.product_img, 
                p.product_name, 
                p.merchant_id,
                a.shop_name
            FROM 
                orders o
            JOIN 
                merchant_products p ON o.product_id = p.product_id
            JOIN 
                crafthub_merchant m ON p.merchant_id = m.merchant_id
            JOIN 
                crafthub_merchant_applicant a ON m.reg_id = a.reg_id
            WHERE 
                o.user_id = '$user_id' AND o.status = 'to pay'";


        $pay = $connection->query($to_pay);

        if (!$pay) {
            die("Query failed: " . $connection->error);
        }

    //for cancel orders
        $cancel_orders = "SELECT
                        o.*, 
                        p.product_img, 
                        p.product_name, 
                        p.merchant_id,
                        a.shop_name
                        FROM 
                            orders o
                        JOIN 
                            merchant_products p ON o.product_id = p.product_id
                        JOIN 
                            crafthub_merchant m ON p.merchant_id = m.merchant_id
                        JOIN 
                            crafthub_merchant_applicant a ON m.reg_id = a.reg_id
                        WHERE 
                            o.user_id = '$user_id' AND o.status = 'cancelled'";


            $cancelled = $connection->query($cancel_orders);

            if (!$pay) {
                die("Query failed: " . $connection->error);
            }


            //for to ship orders
                $to_ship = "SELECT
                            o.*, 
                            p.product_img, 
                            p.product_name, 
                            p.merchant_id,
                            a.shop_name
                            FROM 
                                orders o
                            JOIN 
                                merchant_products p ON o.product_id = p.product_id
                            JOIN 
                                crafthub_merchant m ON p.merchant_id = m.merchant_id
                            JOIN 
                                crafthub_merchant_applicant a ON m.reg_id = a.reg_id
                            WHERE 
                                o.user_id = '$user_id' AND o.status = 'preparing'";


                $result = $connection->query($to_ship);

                if (!$result) {
                die("Query failed: " . $connection->error);
                }

        //for shipped orders
        $shipped = "SELECT
                    o.*, 
                    p.product_img, 
                    p.product_name, 
                    p.merchant_id,
                    a.shop_name
                    FROM 
                        orders o
                    JOIN 
                        merchant_products p ON o.product_id = p.product_id
                    JOIN 
                        crafthub_merchant m ON p.merchant_id = m.merchant_id
                    JOIN 
                        crafthub_merchant_applicant a ON m.reg_id = a.reg_id
                    WHERE 
                        o.user_id = '$user_id' AND o.status = 'shipped'";


            $result1 = $connection->query($shipped);

            if (!$result1) {
            die("Query failed: " . $connection->error);
            }


            //for completed orders
                $completed = "SELECT
                o.*, 
                p.product_img, 
                p.product_name, 
                p.merchant_id,
                a.shop_name
                FROM 
                    orders o
                JOIN 
                    merchant_products p ON o.product_id = p.product_id
                JOIN 
                    crafthub_merchant m ON p.merchant_id = m.merchant_id
                JOIN 
                    crafthub_merchant_applicant a ON m.reg_id = a.reg_id
                WHERE 
                    o.user_id = '$user_id' AND o.status = 'order received'";


        $result2 = $connection->query($completed);

        if (!$result2) {
        die("Query failed: " . $connection->error);
        }
        //for returned orders
            $returned = "SELECT
            o.*, 
            p.product_img, 
            p.product_name, 
            p.merchant_id,
            a.shop_name
            FROM 
                orders o
            JOIN 
                merchant_products p ON o.product_id = p.product_id
            JOIN 
                crafthub_merchant m ON p.merchant_id = m.merchant_id
            JOIN 
                crafthub_merchant_applicant a ON m.reg_id = a.reg_id
            WHERE 
                o.user_id = '$user_id' AND o.status = 'return'";


        $result3 = $connection->query($returned);

        if (!$result3) {
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
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/mypurchase.css">
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

   <!--=============== NAVTABS ===============-->
    <div class="container-fluid">
         <!--=============== NAVTAB HEADERS ===============-->
         <ul class="nav nav-tabs nav-justified" id="responsive-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#to-pay">To Pay <span class="badge badge-custom">0</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#to-ship">To Ship <span class="badge badge-custom">0</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#to-receive">To Receive <span class="badge badge-custom">0</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#completed">Completed <span class="badge badge-custom">0</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#cancelled">Cancelled <span class="badge badge-custom">0</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#return">Return <span class="badge badge-custom">0</span></a>
            </li>
        </ul>
        <!--=============== END OF NAVTAB HEADERS ===============-->


        <!--=============== TAB PANES ===============-->
        <div id="common-content" class="tab-content active">
            <div class="tab-pane fade show active" id="to-pay">
                <div class="order-forms-container">
                    <!--=============== ORDER FORM ===============-->
                    <?php
                        while($topay = mysqli_fetch_assoc($pay)){
                    ?>
                    <div class="order-form">
                        <hr class="solid">
                        <div class="row">
                            <div class="col-12">
                                <div class="order-details"><?php echo $topay['shop_name']; ?></div>
                            </div>
                        </div>          
                        <div class="row">
                            <div class="col-12 col-md-1 text-center text-md-start">
                                <img src="<?php echo 'uploads/'. basename($topay['product_img']); ?>" id="product-image" alt="product image">
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="product-name"><?php echo $topay['product_name']; ?></div>
                                <div class="order-date">Order Date: <?php echo $topay['order_date']; ?></div>
                                <div class="order-note">Note: <input type="text" value="<?php echo $topay['user_note']; ?>" readonly></div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-variation">Color: <?php echo $topay['product_color']; ?></div>
                                <div class="product-variation">Size: <?php echo $topay['product_size']; ?></div>
                                <div class="product-variation">Quantity: <?php echo $topay['quantity']; ?></div>


                            </div>
                            <div class="col-6 col-md-2">
                                <div class="product-price">Total: <?php echo $topay['total']; ?></div>
                            </div>
                            <div class="col-6 col-md-2 product-actions">
                                <button type="button" class="btn btn-danger cancel-btn">
                                    <a href="cancel_order.php?order_id=<?php echo $topay['order_id']; ?>">Cancel</a>
                                </button>
                            </div>
                        </div>
                    
                    </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="to-ship">
                <div class="order-forms-container">
                    <!--=============== ORDER FORM ===============-->
                    <?php
                        while($toship = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="order-form">
                        <hr class="solid">
                        <div class="row">
                            <div class="col-12">
                                <div class="order-details"><?php echo $toship['shop_name']; ?></div>
                            </div>
                        </div>          
                        <div class="row">
                            <div class="col-12 col-md-1 text-center text-md-start">
                                <img src="<?php echo 'uploads/'. basename($toship['product_img']); ?>" id="product-image" alt="product image">
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="product-name"><?php echo $toship['product_name']; ?></div>
                                <div class="order-date">Order Date: <?php echo $toship['order_date']; ?></div>
                                <div class="order-note">Note: <input type="text" value="<?php echo $toship['user_note']; ?>" readonly></div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-variation">Color: <?php echo $toship['product_color']; ?></div>
                                <div class="product-variation">Size: <?php echo $toship['product_size']; ?></div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="product-price">Total: <?php echo $toship['total']; ?></div>
                            </div>
                            <div class="col-6 col-md-2 product-actions">
                                <p class="text-muted">The seller is preparing your order</p>
                            </div>
                        </div>
                        <hr class="solid4">
                    </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="to-receive">
                <div class="order-forms-container">
                    <!--=============== ORDER FORM ===============-->
                    <?php
                        while($ship = mysqli_fetch_assoc($result1)){
                    ?>
                    <div class="order-form">
                        <hr class="solid">
                        <div class="row">
                            <div class="col-12">
                                <div class="order-details"><?php echo $ship['shop_name']; ?></div>
                            </div>
                        </div>          
                        <div class="row">
                            <div class="col-12 col-md-1 text-center text-md-start">
                                <img src="<?php echo 'uploads/'. basename($ship['product_img']); ?>" id="product-image" alt="product image">
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="product-name"><?php echo $ship['product_name']; ?></div>
                                <div class="order-date">Order Date: <?php echo $ship['order_date']; ?></div>
                                <div class="order-note">Note: <input type="text" value="<?php echo $ship['user_note']; ?>" readonly></div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-variation">Color: <?php echo $ship['product_color']; ?></div>
                                <div class="product-variation">Size: <?php echo $ship['product_size']; ?></div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="product-price">Total: <?php echo $ship['total']; ?></div>
                            </div>
                            <div class="col-6 col-md-2 product-actions">
                                <button type="button" class="btn btn-success">
                                    <a href="received.php?order_id=<?php echo $ship['order_id']; ?>">Order Received</a>
                                </button>
                                <button type="button" class="btn btn-danger">
                                    <a href="return.php?order_id=<?php echo $ship['order_id']; ?>">Return/Refund</a>
                                </button>
                            </div>
                        </div>
                        <hr class="solid4">
                    </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="completed">
                <div class="order-forms-container">
                    <!--=============== ORDER FORM ===============-->
                    <?php
                        while($complete = mysqli_fetch_assoc($result2)){
                    ?>
                    <div class="order-form">
                        <hr class="solid">
                        <div class="row">
                            <div class="col-12">
                                <div class="order-details"><?php echo $complete['shop_name']; ?></div>
                            </div>
                        </div>          
                        <div class="row">
                            <div class="col-12 col-md-1 text-center text-md-start">
                                <img src="<?php echo 'uploads/'. basename($complete['product_img']); ?>" id="product-image" alt="product image">
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="product-name"><?php echo $complete['product_name']; ?></div>
                                <div class="order-date">Order Date: <?php echo $complete['order_date']; ?></div>
                                <div class="order-note">Note: <input type="text" value="<?php echo $complete['user_note']; ?>" readonly></div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-variation">Color: <?php echo $complete['product_color']; ?></div>
                                <div class="product-variation">Size: <?php echo $complete['product_size']; ?></div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="product-price">Total: <?php echo $complete['total']; ?></div>
                            </div>
                            <div class="col-6 col-md-2 product-actions">
                                <div class="d-flex justify-content-end">
                                    <a href="rateproduct.php?order_id=<?php echo $complete['order_id']; ?>" class="btn btn-primary me-2 rate-btn">Rate</a>
                                    <button type="button" class="btn btn-secondary refund-btn">Refund</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="cancelled">
                <div class="order-forms-container">
                    <!--=============== ORDER FORM ===============-->
                    <?php 
                        while($cancel = mysqli_fetch_assoc($cancelled)){
                    ?>
                    <div class="order-form">
                        <hr class="solid">
                        <div class="row">
                            <div class="col-12">
                                <div class="order-details"><?php echo $cancel['shop_name']; ?></div>
                            </div>
                        </div>          
                        <div class="row">
                            <div class="col-12 col-md-1 text-center text-md-start">
                                <img src="<?php echo 'uploads/'. basename($cancel['product_img']); ?>" id="product-image" alt="user image">
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="product-name"><?php echo $cancel['product_name']; ?></div>
                                <div class="order-date">Order Date: <?php echo $cancel['order_date']; ?></div>
                                <div class="order-note">Note: <input type="text" value="<?php echo $cancel['user_note']; ?>" readonly></div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-variation">Color: <?php echo $cancel['product_color']; ?></div>
                                <div class="product-variation">Size: <?php echo $cancel['product_size']; ?></div>
                                <div class="product-variation">Size: <?php echo $cancel['quantity']; ?></div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="product-price">Total: <?php echo $cancel['total']; ?></div>
                            </div>
                            <div class="col-6 col-md-2 product-actions">
                                <button type="button" class="btn btn-primary buy-again-btn">Buy Again</button>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>

            <div class="tab-pane fade" id="return">
                <div class="order-forms-container">
                <?php
                        while($returned = mysqli_fetch_assoc($result3)){
                    ?>
                    <div class="order-form">
                        <hr class="solid">
                        <div class="row">
                            <div class="col-12">
                                <div class="order-details"><?php echo $returned['shop_name']; ?></div>
                            </div>
                        </div>          
                        <div class="row">
                        <div class="col-12 col-md-1 text-center text-md-start">
                                <img src="<?php echo 'uploads/'. basename($returned['product_img']); ?>" id="product-image" alt="user image">
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="product-name"><?php echo $returned['product_name']; ?></div>
                                <div class="order-date">Order Date: <?php echo $returned['order_date']; ?></div>
                                
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-variation">Color: <?php echo $returned['product_color']; ?></div>
                                <div class="product-variation">Size: <?php echo $returned['product_size']; ?></div>
                                <div class="product-variation">Size: <?php echo $returned['quantity']; ?></div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="product-price">Total: <?php echo $returned['total']; ?></div>
                            </div>
                            <div class="col-6 col-md-2 product-actions">
                                <button type="button" class="btn btn-primary buy-again-btn">Buy Again</button>
                            </div>
                        </div>
                        <hr class="solid4">
                    </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
     <!--=============== END OF TAB CONTENT CONTAINER ===============-->
     


<script>
function updateSpanCounts() {
    const tabs = ['to-pay', 'to-ship', 'to-receive', 'completed', 'cancelled', 'return'];
    
    tabs.forEach(tab => {
        const container = document.querySelector(`#${tab} .order-forms-container`);
        const orderForms = container.querySelectorAll('.order-form').length;
        const badge = document.querySelector(`a[href="#${tab}"] .badge`);
        badge.textContent = orderForms;
    });
}
function updateSpanCounts() {
    const tabs = ['to-pay', 'to-ship', 'to-receive', 'completed', 'cancelled', 'return'];
    
    tabs.forEach(tab => {
        const container = document.querySelector(`#${tab} .order-forms-container`);
        const orderForms = container ? container.querySelectorAll('.order-form').length : 0;
        const badge = document.querySelector(`a[href="#${tab}"] .badge`);

        if (orderForms > 0) {
            badge.textContent = orderForms;
            badge.style.display = 'inline-flex'; // Ensure the badge is visible if count > 0
        } else {
            badge.style.display = 'none'; // Hide the badge if count is 0
        }
    });
}

function handleCancelButton(event) {
    const actionDiv = event.target.closest('.product-actions');
    actionDiv.innerHTML = `
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-success me-2 confirm-btn">Confirm</button>
            <button type="button" class="btn btn-secondary close-btn">Close</button>
        </div>
    `;
    
    const confirmBtn = actionDiv.querySelector('.confirm-btn');
    const closeBtn = actionDiv.querySelector('.close-btn');
    
    confirmBtn.addEventListener('click', handleConfirmButton);
    closeBtn.addEventListener('click', handleCloseButton);
}

function handleConfirmButton(event) {
    const orderForm = event.target.closest('.order-form');
    orderForm.remove();
    updateSpanCounts();
}

function handleCloseButton(event) {
    const actionDiv = event.target.closest('.product-actions');
    actionDiv.innerHTML = `
        <button type="button" class="btn btn-danger cancel-btn">Cancel</button>
    `;
    
    const cancelBtn = actionDiv.querySelector('.cancel-btn');
    cancelBtn.addEventListener('click', handleCancelButton);
}

// Call updateSpanCounts when the page loads
document.addEventListener('DOMContentLoaded', () => {
    updateSpanCounts();
    
    // Add event listeners to all cancel buttons
    const cancelButtons = document.querySelectorAll('.cancel-btn');
    cancelButtons.forEach(button => {
        button.addEventListener('click', handleCancelButton);
    });
});
</script>

</body>
</html>
