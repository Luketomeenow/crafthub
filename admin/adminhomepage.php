<?php
include 'dbcon.php'; 

// Query to get the number of new applicants
$new_applicants_query = "SELECT COUNT(*) as count FROM crafthub_merchant_applicant WHERE status = 'pending'";
$new_applicants_result = mysqli_query($connection, $new_applicants_query);
$new_applicants_count = mysqli_fetch_assoc($new_applicants_result)['count'];

// Query to get the number of approved merchants
$approved_merchants_query = "SELECT COUNT(*) as count FROM crafthub_merchant";
$approved_merchants_result = mysqli_query($connection, $approved_merchants_query);
$approved_merchants_count = mysqli_fetch_assoc($approved_merchants_result)['count'];

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--=============== BOXICONS ===============-->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <title>CraftHub: An Online Marketplace</title>
    <link rel="stylesheet" href="css/adminsidebar.css">
    <link rel="stylesheet" href="css/adminhomepage.css">
</head>
<body>
    <!--=============== SIDEBAR ===============-->
    <section id="sidebar">
        <a href="adminhomepage.php" class="brand">
            <i class='bx bx-menu'></i>
            <span class="text">CraftHub Admin</span>
        </a>
        <ul class="side-menu top">
            <li class="active"><a href="#"><i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span></a>
            </li>
            <li><a href="adminprocessing.php"><i class='bx bx-list-check'></i>
                    <span class="text">Application Processing</span></a>
            </li>
            <li><a href="adminaccsetup.php"><i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Account Set Up</span></a>
            </li>
        </ul>
        <ul class="side-menu">
            <li></li>
            <li>
                <a href="index2.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!--=============== END OF SIDEBAR ===============-->

    <section id="content">
        <!--=============== CONTENT ===============-->
        <nav></nav>
        <!--=============== NAVBAR ===============-->

        <!--=============== MAIN ===============-->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-folder-plus'></i>
                    <div class="info-content">
                        <div class="info-header">
                            <h3>New Applicants <span class="info-number"><?php echo $new_applicants_count; ?></span></h3>
                        </div>
                    </div>
                </li>
                <li>
                    <i class='bx bx-folder-open'></i>
                    <div class="info-content">
                        <div class="info-header">
                            <h3>Merchants <span class="info-number"><?php echo $approved_merchants_count; ?></span></h3>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="charts">
                <div class="charts-card">
                    <h2 class="chart-title">Sales</h2>
                    <div id="bar-chart"></div>
                </div>

                <div class="charts-card">
                    <h2 class="chart-title">Purchase and Sales Orders</h2>
                    <div id="line-chart"></div>
                </div>
            </div>
        </main>
    </section>
    <!--=============== END OF CONTENT ===============-->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybiiZ9zWnyPp6pBfQ5e1K6p0JjxOu/tV5aFUbJg5p6nAyKGGk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Pw60HXBs2E/B15z6tRXBbmEpnf4lmyj6VdU5zuF0KNUgF6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <script src="js/adminhomepagechart.js"></script>
    <script src="js/adminsidebar.js"></script>
</body>
</html>
