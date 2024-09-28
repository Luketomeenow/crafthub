<?php
session_start();
include 'dbcon.php';

$user_id = $_SESSION['userID']; // Ensure 'userID' is set in the session, typically at login

// Fetch user details
$query = "SELECT * FROM crafthub_user WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    exit("No user found.");
}

$row = mysqli_fetch_assoc($result);
$current_profile_image = $row['user_profile'] ?? 'images/user.png';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update profile info
    if (isset($_POST['update'])) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
        $middle_name = mysqli_real_escape_string($connection, $_POST['middle_name']);
        $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
        $birthday = mysqli_real_escape_string($connection, $_POST['birthday']);
        $contact_no = mysqli_real_escape_string($connection, $_POST['contact']);
        $address = mysqli_real_escape_string($connection, $_POST['address']);

        // Handle profile image upload
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
            $target_directory = "uploads/"; // Ensure this path is accessible
            $profile_image = basename($_FILES["profile_image"]["name"]);
            $target_file = $target_directory . $profile_image;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["profile_image"]["tmp_name"]);

            if ($check && $_FILES["profile_image"]["size"] <= 1000000 || 
                in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif']) ||
                move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                // Update profile image in the database
                $update_image_query = "UPDATE crafthub_user SET user_profile = '$profile_image' WHERE user_id = '$user_id'";
                mysqli_query($connection, $update_image_query);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Update user information in the database
        $update_query = "UPDATE crafthub_user 
                        SET username = '$username', email = '$email', fname = '$first_name', 
                            mname = '$middle_name', lname = '$last_name', bday = '$birthday', 
                            contact_no = '$contact_no', user_adds = '$address' 
                        WHERE user_id = '$user_id'";
        if (mysqli_query($connection, $update_query)) {
            header("Refresh:0"); // Refresh page to show updated data
        } else {
            echo "Error updating profile: " . mysqli_error($connection);
        }
    }

    // Change password
    if (isset($_POST['save_pass'])) {
        $current_password_input = mysqli_real_escape_string($connection, $_POST['current_password']);
        $new_password = mysqli_real_escape_string($connection, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

        // Fetch current password from the database
        $password_query = "SELECT user_pass FROM crafthub_user WHERE user_id = '$user_id'";
        $password_result = mysqli_query($connection, $password_query);

        if ($password_result && mysqli_num_rows($password_result) > 0) {
            $stored_password = mysqli_fetch_assoc($password_result)['user_pass'];

            // Check if the current password matches
            if ($current_password_input === $stored_password && $new_password === $confirm_password) {
                $update_password_query = "UPDATE crafthub_user SET user_pass = '$new_password' WHERE user_id = '$user_id'";
                mysqli_query($connection, $update_password_query);
                echo "<script>alert('Password updated successfully!');</script>";
            } else {
                echo "<script>alert('Password mismatch or incorrect current password.');</script>";
            }
        }
    }
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
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/account.css">
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
    <!--=============== ACCOUNT SETTINGS CONTENT ===============-->
    <!--=============== ACCOUNT SETTINGS CONTENT ===============-->
    <div class="container light-style flex-grow-1 container-p-y" id="accsettings">
        <div class="card overflow-hidden"> 
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-bs-toggle="tab" href="#account-general">User Profile</a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#account-change-password">Change password</a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#account-privacy-settings">Privacy Settings</a>
                        </div>
                </div>              
                <div class="col-md-9 border-start">
                    <div class="tab-content">
                        <!--ACCOUNT GENERAL-->
                        <div class="tab-pane fade show active" id="account-general">
                            <form action="" method="post" id="userProfileForm" enctype="multipart/form-data">
                                    <div class="card-body media align-items-center">
                                    <img id="profileImage" src="<?php echo 'uploads/' .  $current_profile_image; ?>" alt class="d-block ui-w-80">
                                        <div class="media-body ml-4" id="uploadimgbtn">
                                            <label class="btn btn-outline-primary d-none" id="uploadButton"> Upload new photo
                                            <input type="file" class="account-settings-fileinput" id="uploadImageInput" name="profile_image" accept="image/*">
                                            </label> &nbsp;
                                            <button type="button" class="btn btn-outline-secondary d-none" id="resetImage">Reset</button> 
                                        </div>                                    
                                        <div class="text-right">  
                                            <button type="button" class="btn btn-primary" id="editButton">Edit</button>
                                            <button type="submit" name="update" class="btn btn-success d-none" id="saveButton">Save changes</button>
                                            <button type="button" class="btn btn-danger d-none" id="cancelButton">Cancel</button>
                                        </div>
                                    </div>                                                                       
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input name="username" type="text" class="form-control mb-1" value="<?php echo htmlspecialchars($row['username']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input name="first_name" type="text" class="form-control" value="<?php echo htmlspecialchars($row['fname']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Middle Name</label>
                                        <input name="middle_name" type="text" class="form-control" value="<?php echo htmlspecialchars($row['mname']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input name="last_name" type="text" class="form-control" value="<?php echo htmlspecialchars($row['lname']); ?>">
                                    </div>
                                    <hr class="border-light m-3">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input name="email" type="text" class="form-control mb-1" value="<?php echo htmlspecialchars($row['email']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Birthday</label>
                                        <input type="text" name="birthday" class="form-control" value="<?php echo htmlspecialchars($row['bday']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="number" name="contact" class="form-control" value="<?php echo htmlspecialchars($row['contact_no']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($row['user_adds']); ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--END ACCOUNT GENERAL-->
                        <!--CHANGE PASS-->
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" name="current_password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" name="new_password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Confirm new password</label>
                                        <input type="password" name="confirm_password" class="form-control" required>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" name="save_pass" class="btn btn-primary">Save changes</button>
                                        <button type="button" class="btn btn-danger">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--END CHANGE PASS-->
                        <!--PRIVACY SETTINGS-->
                        <div class="tab-pane fade" id="account-privacy-settings">
                            <div class="card-body pb-2" id="accdeletion">
                                <div class="form-group">
                                    <label class="form-label">Account Deletion Request</label>
                                </div>
                                <button type="button" class="btn btn-danger">Delete Account</button>
                            </div>
                        </div>
                        <!--END PRIVACY SETTINGS-->
                    </div>
                </div>
            </div>
        </div>
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

       
    <script>
                document.getElementById('uploadImageInput').addEventListener('change', function(event) {
            var reader = new FileReader();
            
            reader.onload = function(){
                var imgElement = document.getElementById('profileImage');
                imgElement.src = reader.result;
            };
            
            reader.readAsDataURL(event.target.files[0]);
            document.getElementById('resetImage').addEventListener('click', function() {
            document.getElementById('profileImage').src = '<?php echo $current_profile_image; ?>';
            document.getElementById('uploadImageInput').value = null;
        });
        });
    </script>
    <script src="js/editbtn.js"></script>
</body>
</html>
