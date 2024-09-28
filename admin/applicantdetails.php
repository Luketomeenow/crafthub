<?php 
    include 'dbcon.php';
    if (isset($_GET['reg_id'])){
        $reg_id = mysqli_real_escape_string($connection, $_GET['reg_id']);

        $select_details = "
        SELECT 
            reg_id, lname, mname, fname, owner_add, shop_name, shop_email, shop_contactno, shop_municipality, shop_barangay, shop_street,
             business_permit, BIR_registration, BIR_0605, DTI_cert, status
        FROM 
            crafthub_merchant_applicant 
        WHERE 
            reg_id = '$reg_id'";

        $result = mysqli_query($connection, $select_details);

        if(!$result){
            die("Query Failed: " . mysqli_error($connection));
        } else {
            $row = mysqli_fetch_assoc($result);

        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--=============== BOXICONS ===============-->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <title>CraftHub: An Online Marketplace</title>
    <link rel="stylesheet" href="css/adminsidebar.css">
    <link rel="stylesheet" href="css/applicantdetails.css">
</head>
<body>
   <!--=============== SIDEBAR ===============-->
   <section id="sidebar">
		<a href="#" class="brand">
        <i class='bx bx-menu' ></i>
			<span class="text">CraftHub Admin</span>
		</a>
		<ul class="side-menu top">
			<li><a href="adminhomepage.php"><i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span></a>
			</li>
			<li class="active"> <a href="adminprocessing.php"><i class='bx bx-list-check'></i> 
                    <span class="text">Application Processing</span></a>
			</li>
			<li><a href="adminaccsetup.php"><i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Account Set Up</span></a>
			</li>			
		</ul>
		<ul class="side-menu">
			<li>				
			</li>
			<li>
				<a href="index2.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!--=============== END OF SIDEBAR ===============-->


    <!--=============== CONTENT ===============-->
    <section id="content">
        <!--=============== NAVBAR ===============-->
        <nav></nav>


        <!--=============== MAIN ===============-->
        <main>
        <div class="container">
                    <div class="mb-5 details"> <!--=============== USER/MERCHANT BASIC INFORMATION ===============-->
                        <div class="user-details">
                            <h5>Applicant's Information</h5>
                                <div class="applicant-details">
                                <h6 class="mt-5">
                                <span class="mb-4 applicant-input-id">Applicant ID Number: <?php echo $row['reg_id'] ?></span>
                                    </h6>
                                </div>
                        </div>
                        <div class="user-details">
                            <h6><label class="applicant-details">Business Owner Name</label></h6>
                                <div class="applicant-input">
                                            <span name="regid" class="mb-1" readonly><?php echo $row['fname'] .' '. $row['mname'] .' '. $row['lname']; ?></span>                                
                                </div>
                        </div>
                        <div class="user-details">
                            <h6><label class="applicant-details">Address</label></h6>
                                <div class="applicant-input">
                                    <span name="owner_add" class="mb-1" readonly><?php echo $row['owner_add'] ?></span>
                                </div>
                        </div>
                        
                        <div class="user-details">
                            <h6><label class="applicant-details">Business Name</label></h6>
                                <div class="applicant-input">
                                    <span name="regid" class="mb-1" readonly><?php echo $row['shop_name'] ?></span>
                                </div>
                        </div>
                        <div class="user-details">
                            <h6><label class="applicant-details">Business Email Address</label></h6>
                                <div class="applicant-input">
                                    <span name="regid" class="mb-1" readonly><?php echo $row['shop_email'] ?></span>
                                </div>
                        </div>
                        <div class="user-details">
                            <h6><label class="applicant-details">Business Phone Number</label></h6>
                                <div class="applicant-input">
                                    <span name="regid" class="mb-1" readonly><?php echo $row['shop_contactno'] ?></span>
                                </div>
                        </div>
                        <hr class="border-light m-2">
                       
                        <div class="user-details">
                            <h6><label class="applicant-details">Municipality</label></h6>
                                <div class="applicant-input">
                                    <span name="regid" class="mb-1" readonly><?php echo $row['shop_municipality'] ?></span>
                                </div>
                        </div>
                        <div class="user-details">
                            <h6><label class="applicant-details">Barangay</label></h6>
                                <div class="applicant-input">
                                    <span name="regid" class="mb-1" readonly><?php echo $row['shop_barangay'] ?></span>
                                </div>
                        </div>
                        <div class="user-details">
                            <h6><label class="applicant-details">Street</label></h6>
                                <div class="applicant-input">
                                    <span name="regid" class="mb-1" readonly><?php echo $row['shop_street'] ?></span>
                                </div>
                        </div>
                        <!--=============== REQUIREMENTS ===============-->
                        <div class="mt-5 requirements">
                            <hr class="border-light m-2">
                            <h5>Uploaded Requirements</h5>
                                <div class="evaluation">
                                    <div class="row">
                                        <div class="col-md-3" id="permit">
                                            <ul>
                                                <li>
                                                    <a href="<?php echo '../' . $row['business_permit'] ?>" class="btn btn-outline-primary" target="_blank">
                                                    View Business Permit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo '../' . $row['BIR_registration'] ?>" class="btn btn-outline-primary" target="_blank">
                                                        View BIR Registration
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo '../' . $row['BIR_0605'] ?>" class="btn btn-outline-primary" target="_blank">
                                                        View BIR 0605
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo '../' . $row['DTI_cert'] ?>" class="btn btn-outline-primary" target="_blank">
                                                        View DTI Certificate
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3" id="download">
                                            <ul>
                                                <li>
                                                    <a href="<?php echo '../' . $row['business_permit'] ?>" class="btn btn-primary" download>
                                                        Download Business Permit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo '../' . $row['BIR_registration'] ?>" class="btn btn-primary" download>
                                                        Download BIR Registration
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo '../' . $row['BIR_0605'] ?>" class="btn btn-primary" download>
                                                        Download BIR 0605
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo '../' . $row['DTI_cert'] ?>" class="btn btn-primary" download>
                                                        Download DTI Certificate
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        </div>
          
                        <form id="decisionForm" action="send_email.php" method="post">
                                

                                <input type="hidden" name="reg_id" value="<?php echo $row['reg_id']; ?>">
                                <input type="hidden" name="email" value="<?php echo $row['shop_email']; ?>">
                                <input type="hidden" name="name" value="<?php echo $row['fname'] . ' ' . $row['lname']; ?>">

                                <!-- Add comments textarea -->
                                <div class="applicant-note">
                                    <h5>Add Comment</h5>
                                    <textarea class="form-control" id="reqscomment" rows="3" name="comment"></textarea>
                                </div>

                                <!-- Decision buttons -->
                                <div class="decision">
                                    <button type="submit" name="decision" value="approve" class="btn btn-primary">Approve</button>
                                    <button type="submit" name="decision" value="reject" class="btn btn-danger">Reject</button>
                                </div>
                        </form>
                    </div>
               
            </div>

        </main>
    </section>
    
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="js/createacc.js"></script>
<script src="js/adminsidebar.js"></script>

</body>
</html>
