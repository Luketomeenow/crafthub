<?php 
session_start();
include 'dbcon.php';

if (!isset($_SESSION['merchant_id'])) {
    exit("Merchant ID is not set in session.");
}
$merchant_id = $_SESSION['merchant_id'];

$query = "SELECT reg_id, merchant_profile FROM crafthub_merchant WHERE merchant_id = '$merchant_id'";
$result = mysqli_query($connection, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    exit("No registration ID found for this merchant.");
}
$row = mysqli_fetch_assoc($result);
$reg_id = $row['reg_id'];
$current_profile_image = $row['merchant_profile'] ?? 'images/user.png';

$query = "SELECT * FROM crafthub_merchant_applicant WHERE reg_id = '$reg_id'";
$result = mysqli_query($connection, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    exit("No data found.");
}
$applicant_data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $shopname = mysqli_real_escape_string($connection, $_POST['shopname']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $contact = mysqli_real_escape_string($connection, $_POST['contact']);
        $municipality = mysqli_real_escape_string($connection, $_POST['municipality']);
        $barangay = mysqli_real_escape_string($connection, $_POST['barangay']);
        $street = mysqli_real_escape_string($connection, $_POST['street']);

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
            $target_directory = "../uploads/";
            $profile_image = basename($_FILES["profile_image"]["name"]);
            $target_file = $target_directory . $profile_image;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
            
            if (!$check || $_FILES["profile_image"]["size"] > 1000000 || 
                !in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif']) ||
                !move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                echo "<script>alert('Error uploading file.');</script>";
            } else {
                $update_image_query = "UPDATE crafthub_merchant SET merchant_profile = '$target_file' WHERE merchant_id = '$merchant_id'";
                mysqli_query($connection, $update_image_query);
            }
        }

        $update_query = "UPDATE crafthub_merchant_applicant 
                        SET shop_name = '$shopname', shop_email = '$email', shop_contactno = '$contact', 
                            shop_municipality = '$municipality', shop_barangay = '$barangay', shop_street = '$street' 
                        WHERE reg_id = '$reg_id'";
        if (mysqli_query($connection, $update_query)) {
            echo "<script>alert('Profile updated successfully!');</script>";
        } else {
            echo "Error updating profile: " . mysqli_error($connection);
        }
    }

    if (isset($_POST['save_pass'])) {
        $current_password_input = mysqli_real_escape_string($connection, $_POST['current_password']);
        $new_password = mysqli_real_escape_string($connection, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

        $password_query = "SELECT password FROM crafthub_merchant WHERE merchant_id = '$merchant_id'";
        $password_result = mysqli_query($connection, $password_query);
        if ($password_result && mysqli_num_rows($password_result) > 0) {
            $stored_password = mysqli_fetch_assoc($password_result)['password'];
            if ($current_password_input === $stored_password && $new_password === $confirm_password) {
                $update_password_query = "UPDATE crafthub_merchant SET password = '$new_password' WHERE merchant_id = '$merchant_id'";
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
    <link rel="stylesheet" href="css/maccount.css">
    <link rel="stylesheet" href="css/mnavigation.css">
    <link rel="stylesheet" href="css/mfooter.css">
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
            <li class="mx-4 d-inline-block"><a href="mchatroom.php">Messages</a></li>
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
            <a href="mchatroom.php">Messages</a>
            <a href="morders.php">Orders</a>
            <a href="maccount.php">Settings</a>
            <a href="index.php">Log out</a>
        </div>
    </nav>
    </div>
    <!--=============== MERCHANT ACCOUNT SETTINGS ===============-->
    <div class="container light-style" id="accsettings">
        <div class="card overflow-hidden"> 
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-bs-toggle="tab" href="#account-general">User Profile</a>
                        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#account-change-password">Change password</a>
                        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#account-privacy-settings">Privacy Settings</a>
                    </div>
                </div>
                
                <!--=============== TAB CONTENT ===============-->
                <div class="col-md-9 border-start">
                    <div class="tab-content">
                       <!--=============== GENERAL MERCHANT ACCOUNT CONTENT ===============-->
                        <div class="tab-pane fade show active" id="account-general">
                            <div class="card-body media align-items-center">
                            

                                    <form action="" method="post" id="userProfileForm" enctype="multipart/form-data">
                                    <img id="profileImage" src="<?php echo '../uploads/' .  $current_profile_image; ?>" alt class="d-block ui-w-80">
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
                        
                            <div class="card-body">
                             
                                    <div class="form-group">
                                        <label class="form-label">Shop Name</label>
                                        <input name="shopname" type="text" class="form-control mb-1" value="<?php echo $applicant_data['shop_name']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input name="email" type="text" class="form-control mb-1" value="<?php echo $applicant_data['shop_email']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="contact" class="form-control" value="<?php echo $applicant_data['shop_contactno']; ?>" readonly>
                                    </div>
                                    <hr class="border-light m-2">
                                    
                                    <!--=============== ADDRESS ===============-->
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <div class="select_option">
                                            <select class="form-select Municipality" id="municipality_select" name="municipality" disabled>
                                                <option value="<?php echo $applicant_data['shop_municipality']; ?>" selected><?php echo $applicant_data['shop_municipality']; ?></option>
                                            </select>

                                            <select class="form-select Barangay" id="barangay_select" name="barangay" disabled>
                                                <option value="<?php echo $applicant_data['shop_barangay']; ?>" selected><?php echo $applicant_data['shop_barangay']; ?></option>
                                            </select>

                                            <label class="form-label">Street</label>
                                            <input type="text" class="form-control" name="street" value="<?php echo $applicant_data['shop_street']; ?>" readonly>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>  
                        <!--=============== END OF GENERAL MERCHANT ACCOUNT CONTENT ===============-->
                        <!--=============== CHANGE PASS ===============-->
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
                        <!--=============== END OF CHANGE PASS ===============-->                  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--=============== END OF MERCHANT ACCOUNT SETTINGS CONTENT ===============-->

    <script>
                document.getElementById('uploadImageInput').addEventListener('change', function(event) {
            var reader = new FileReader();
            
            reader.onload = function(){
                var imgElement = document.getElementById('profileImage');
                imgElement.src = reader.result;
            };
            
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
<script>
// Define municipality and barangay data
var municipalities = ["Abucay", "Bagac", "Dinalupihan", "Hermosa", "Limay", "Mariveles", "Morong", "Orani", "Orion", "Pilar", "Samal", "Balanga City"];
var barangays = {
    "Abucay": ["Bangkal", "Calaylayan", "Gabon", "Laon", "Mabatang", "Omboy", "Poblacion", "Salian", "Wawa"],
    "Bagac": ["Bagumbayan", "Banawang", "Binuangan", "Ibaba", "Poblacion", "Salvacion", "Saysayin"],
    "Dinalupihan": ["Colo", "Daang Bago", "Luakan", "Mabini", "Pag-asa", "Payangan", "Pita", "San Benito", "San Jose", "San Ramon", "Santa Isabel", "Santiago", "Sapang Balas", "Tortugas"],
    "Balanga City": ["Bagong Silang", "Bagumbayan", "Bagumbayan North", "Bagumbayan South", "Cabog-cabog", "Camacho", "Central", "Ibayo", "Poblacion", "Puerto Rivas Ibaba", "Puerto Rivas Itaas", "San Jose", "Sibacan", "Tenejero"],
    "Hermosa": ["Almacen", "Anting", "Bagumbayan", "Balsic", "Mambog", "Palihan", "Poblacion", "San Pedro", "Santa Catalina", "Sumalo"],
    "Limay": ["Alangan", "Alas-asin", "Bacong", "Kitang II", "Kitang I", "Lamao", "Poblacion", "Townsite", "Wawa"],
    "Mariveles": ["Alas-asin", "Baseco", "Batangas Dos", "Batangas Uno", "Biaan", "Camaya", "Ipag", "Lamao", "Lucanin", "Malaya", "Maligaya", "Poblacion", "San Isidro", "San Jose", "Sisiman", "Townsite"],
    "Morong": ["Binaritan", "Mabayo", "Poblacion", "Sabang"],
    "Orani": ["Apollo", "Bagong Bayan", "Balut", "Bilolo", "Calero", "Centro", "General Luna", "Kalayaan", "Mulawin", "Palihan", "Pantalan Bago", "Pantalan Luma", "Parang Parang", "Poblacion", "Talimundoc"],
    "Orion": ["Arellano", "Bagumbayan", "Balut", "Calungusan", "Camachile", "Daan Bilolo", "Daang Pare", "General Lim", "Kapunitan", "Lusungan", "Puting Buhangin", "Sabatan", "San Vicente", "Santo Domingo"],
    "Pilar": ["Bagumbayan", "Balut I", "Balut II", "Cabcaben", "Del Rosario", "Liyang", "Poblacion", "Nagwaling", "Pantingan","Sta. Rosa"],
    "Samal": ["East Daang Bago", "Gugo", "Palili", "San Juan", "Santa Lucia", "Tabing Ilog", "West Daang Bago"]
};

// Populate municipalities on page load
function populateMunicipalities() {
    var municipalitySelect = document.getElementById("municipality_select");
    municipalitySelect.innerHTML = "";

    municipalities.forEach(function(municipality) {
        var option = document.createElement("option");
        option.value = municipality;
        option.text = municipality;
        if (municipality === "<?php echo $applicant_data['shop_municipality']; ?>") {
            option.selected = true;
        }
        municipalitySelect.appendChild(option);
    });
}

// Populate barangays based on selected municipality
function populateBarangays() {
    var municipalitySelect = document.getElementById("municipality_select");
    var barangaySelect = document.getElementById("barangay_select");

    var selectedMunicipality = municipalitySelect.value;
    barangaySelect.innerHTML = "";

    if (selectedMunicipality && barangays[selectedMunicipality]) {
        barangays[selectedMunicipality].forEach(function(barangay) {
            var option = document.createElement("option");
            option.value = barangay;
            option.text = barangay;
            if (barangay === "<?php echo $applicant_data['shop_barangay']; ?>") {
                option.selected = true;
            }
            barangaySelect.appendChild(option);
        });
    }
}

// Initialize the form on page load
document.addEventListener("DOMContentLoaded", function() {
    populateMunicipalities();
    populateBarangays();
});

// Event listener for municipality change
document.getElementById("municipality_select").addEventListener("change", populateBarangays);
</script>

<script src="js/editbtn.js"></script>
</body>
</html>