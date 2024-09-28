<?php 
    session_start();
    include 'dbcon.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!--=============== BOXICONS ===============-->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/adminsidebar.css">
    <link rel="stylesheet" href="css/adminaccsetup2.css">
</head>
<body>

    <!--=============== SIDEBAR ===============-->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bx-menu'></i>
            <span class="text">CraftHub Admin</span>
        </a>
        <ul class="side-menu top">
            <li><a href="adminhomepage.php"><i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span></a>
            </li>
            <li> <a href="adminprocessing.php"><i class='bx bx-list-check'></i> 
                    <span class="text">Application Processing</span></a>
            </li>
            <li class="active">
                <a href="adminaccsetup.php"><i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Account Set Up</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
            </li>
            <li>
                <a href="index2.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!--=============== END OF SIDEBAR ===============-->

    <!--=============== CONTENT ===============-->
    <section id="content">
        <nav></nav>



        <!--=============== MAIN ===============-->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Merchant Account Set Up</h1>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Approved Applicants</h3>
                        <div class="search-input">
                            <input type="search" class="form-control" placeholder="Search...">
                            <button type="button" class="search-btn btn btn-primary"><i class='bx bx-search'></i></button>
                        </div>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Shop Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
								$selectall = "SELECT mp.reg_id,
										mp.fname,
										mp.mname,
										mp.lname,
										mp.shop_name,
										mp.shop_email,
										mp.date,
										mp.status
										FROM crafthub_merchant_applicant mp
										WHERE mp.status = 'processing'";

										
										$result = mysqli_query($connection, $selectall);

										if (!$result) {
										die("Query Failed: " . mysqli_error($connection));
										}else{
									
										while($row = mysqli_fetch_assoc($result)){
											?>
											<tr>
												<td><?php echo $row['reg_id']?></td>
												<td><?php echo $row['fname'].' '. $row['mname'].' '. $row['lname'];?></td>
												<td><?php echo $row['shop_name']?></td>
												<td><?php echo $row['shop_email']?></td>
												<td><?php echo $row['status']?></td>
                                                <td>
                                                <button type="button" class="create-btn btn btn-primary" 
                                                        id="createAccountBtn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#newMerchantModal" 
                                                        data-email="<?php echo $row['shop_email']; ?>" 
                                                        data-regid="<?php echo $row['reg_id']; ?>">
                                                    Create Account
                                                </button>
                                            </td>											
                                        </tr>
											<?php
										}
								
										}
									?>
                            <tr>
                                
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!--=============== END OF MAIN ===============-->
    </section>
    <!--=============== END OF CONTENT ===============-->


    
        <!--=============== MODAL FOR CREATE NEW MERCHANT ACCOUNT ===============-->
        <div class="modal fade" id="newMerchantModal" tabindex="-1" aria-labelledby="newMerchantModalLabel" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="newMerchantModalLabel">Create New Merchant Account</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="create_merchant.php" method="POST">
                            <div class="mb-3">
                                <label for="merchantRegId" class="form-label"></label>
                                <input type="hidden" class="form-control" id="merchantRegId" name="reg_id" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="merchantEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="merchantEmail" name="email" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="merchantPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="merchantPassword" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="merchantConfirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="merchantConfirmPassword" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--=============== END OF MODAL FOR CREATE NEW MERCHANT ACCOUNT ===============-->

            <!--=============== END OF MODAL FOR CREATE NEW MERCHANT ACCOUNT ===============-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var createAccountBtn = document.querySelectorAll('#createAccountBtn');
    
    createAccountBtn.forEach(function(button) {
        button.addEventListener('click', function() {
            var email = button.getAttribute('data-email');
            var reg_id = button.getAttribute('data-regid');
            
            document.getElementById('merchantEmail').value = email;
            document.getElementById('merchantRegId').value = reg_id;
        });
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="js/adminsidebar.js"></script>


</body>
</html>
