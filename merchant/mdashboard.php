<?php
    include 'dbcon.php';
    session_start();
    $merchant_id = $_SESSION['merchant_id'];

    //complete orders
    $countCompletedOrders = "SELECT COUNT(*) AS total_completed
                            FROM orders o
                            JOIN merchant_products mp ON o.product_id = mp.product_id
                            WHERE mp.merchant_id = '$merchant_id' AND o.status = 'order received'";

                        $countResult = mysqli_query($connection, $countCompletedOrders);

                        if ($countResult) {
                            $countRow = mysqli_fetch_assoc($countResult);
                            $totalCompleted = $countRow['total_completed'];
                        } else {
                            die("Query Failed: " . mysqli_error($connection));
                        }

     //pending orders
$countPendingOrders = "SELECT COUNT(*) AS total_pending
                        FROM orders o
                        JOIN merchant_products mp ON o.product_id = mp.product_id
                        WHERE mp.merchant_id = '$merchant_id' AND o.status = 'to pay'";

                    $countResult1 = mysqli_query($connection, $countPendingOrders);

                    if ($countResult1) {
                        $countRow1 = mysqli_fetch_assoc($countResult1);
                        $totalPending = $countRow1['total_pending'];
                    } else {
                        die("Query Failed: " . mysqli_error($connection));
                    }

$countToShipOrders = "SELECT COUNT(*) AS total_ship
                    FROM orders o
                    JOIN merchant_products mp ON o.product_id = mp.product_id
                    WHERE mp.merchant_id = '$merchant_id' AND o.status = 'preparing'";

                $countResult2 = mysqli_query($connection, $countToShipOrders);

                if ($countResult2) {
                    $countRow2 = mysqli_fetch_assoc($countResult2);
                    $totalShip = $countRow2['total_ship'];
                } else {
                    die("Query Failed: " . mysqli_error($connection));
                }

$countCancelledOrders = "SELECT COUNT(*) AS total_cancelled
                FROM orders o
                JOIN merchant_products mp ON o.product_id = mp.product_id
                WHERE mp.merchant_id = '$merchant_id' AND o.status = 'cancelled'";

            $countResult3 = mysqli_query($connection, $countCancelledOrders);

            if ($countResult3) {
                $countRow3 = mysqli_fetch_assoc($countResult3);
                $totalCancel = $countRow3['total_cancelled'];
            } else {
                die("Query Failed: " . mysqli_error($connection));
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
    <link rel="stylesheet" href="css/mdashboard.css">
    <link rel="stylesheet" href="css/mfooter.css">
    <link rel="stylesheet" href="css/mnavigation.css">
</head>
<body>
        <!--=============== NAVIGATION ==============-->
<div class="flexMain sticky-top py-4" id="mainNavigation">
    <div class="flex3">
        <ul class="list-unstyled d-md-block">
            <li class="mx-4 d-inline-block"><a href="mhomepage.php" class="logo"><img src="images/navlogo.png"></a></li>
        </ul>
    </div>
    <div class="flex5">
        <ul class="list-unstyled navigation-menu">
            <li class="mx-4 d-inline-block"><a href="mdashboard.php">Dashboard</a></li>
            <li class="mx-4 d-inline-block"><a href="mprofile.php">Products</a></li>
            <li class="mx-4 d-inline-block"><a href="mchatroom.php?chat_with_id=4&chat_with_type=user&user_id=4">Messages</a></li>
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
            <a href="">Messages</a>
            <a href="maccount.php">Settings</a>
            <a href="../index.php">Log out</a>
        </div>
    </nav>
</div>
<!--=============== END NAVIGATION ==============-->

<!--=============== DASHBOARD ==============-->
<div class="container">
    <div class="row">
        <h1 class="dashboard-title"><i class="ri-dashboard-line" id="dashboard"></i>Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-md-4">
            <a href="mdashboardcomplete.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                    <i class="fa-solid fa-table-list" id="complete"></i>
                        <h5 class="card-title">Completed Orders</h5>
                        <p class="card-text">All completed orders</p>
                        <div class="card-footer">
                            <div class="card-text">
                                <div><?php echo $totalCompleted; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="mdashboardpending.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <i class="fa-regular fa-clock" id="pending"></i>
                        <h5 class="card-title">Pending Orders</h5>
                        <p class="card-text">All pending orders</p>
                        <div class="card-footer">
                            <div class="card-text">
                                <div><?php echo $totalPending; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="mdashboardtoship.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                    <i class="fa-solid fa-truck" id="ship"></i>
                        <h5 class="card-title">Shipped Orders</h5>
                        <p class="card-text">All shipped orders</p>
                        <div class="card-footer">
                            <div class="card-text">
                                <div><?php echo $totalShip; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="mdashboardcancelled.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                    <i class="fa-regular fa-rectangle-xmark" id="cancel"></i>
                        <h5 class="card-title">Cancelled Orders</h5>
                        <p class="card-text">All cancelled orders</p>
                        <div class="card-footer">
                            <div class="card-text">
                                <div><?php echo $totalCancel; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="mdashboardreturn.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                    <i class="fa-solid fa-rotate-left" id="return"></i>
                        <h5 class="card-title">Returned Orders</h5>
                        <p class="card-text">All returned orders</p>
                        <div class="card-footer">
                            <div class="card-text">
                                <div>52</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="mdashboardallproducts.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <i class='bx bxl-product-hunt' id="all"></i>
                        <h5 class="card-title">Product Ratings</h5>
                        <p class="card-text">Feedback & Ratings</p>
                        <div class="card-footer">
                            <div class="card-text">
                                <div>10,129</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!--=============== END OF DASHBOARD ==============-->

</body>
</html>
