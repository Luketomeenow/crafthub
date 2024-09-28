<?php 
    session_start();
    include 'dbcon.php';
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
    <title>CraftHub: An Online Marketplace</title>
    <link rel="stylesheet" href="css/adminsidebar.css">
    <link rel="stylesheet" href="css/adminprocessing.css">
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
		<nav>		
		</nav>

		<!--=============== MAIN ===============-->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Application Processing</h1>
				</div>
			</div>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Merchant Applicants</h3>
						<div class="form-input">
							<input type="search" placeholder="Search...">
							<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
							</div>
								<i class='bx bx-filter' ></i>
							</div>
							<table>
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Business Name</th>
										<th>Email</th>
										<th>Application Date</th>
										<th>Status</th>
										
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
										WHERE mp.status = 'pending'";

										
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
												<td><?php echo $row['date']?></td>
												<td><a href="applicantdetails.php?reg_id=<?php echo $row['reg_id']?>" class = "btn btn-danger">Pending</a></td>
											</tr>
											<?php
										}
								
										}
									?>
								
								</tbody>
							</table>
						</div>
					</div>
			</div>
	</main>
	<!--=============== END OF MAIN ===============-->
</section>


<script src="js/adminsidebar.js"> </script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>