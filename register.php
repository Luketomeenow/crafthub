<?php 
    session_start();
    include 'dbcon.php'
?>
<?php
    if(isset($_POST['register'])){
        $lastname =$_POST['lastName'];
        $firstname = $_POST['firstName'];
        $middlename = $_POST['middleName'];
        $address = $_POST['address'];
        $bday = $_POST['bday'];
        $phonenumber = $_POST['phoneNumber'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];

        $queryselect = "SELECT * FROM `crafthub_user` WHERE `email` = '$email'";

        $result = mysqli_query($connection, $queryselect);

        if(mysqli_num_rows($result) > 0){
            echo "<script> alert('Email Address Already Exists!') </script>";
            
        }else{
          if($password != $confirmpassword){
            echo "<script> alert('Password does not matched!') </script>";

          }else{
              $queryinsert = "INSERT INTO `crafthub_user`(`username`,`email`,`user_pass`,`fname`, `mname`, `lname`, `bday`, `contact_no`, `user_adds`) 
              VALUES ('$username','$email','$password','$firstname','$middlename','$lastname','$bday','$phonenumber','$address')";

                $result1 = mysqli_query($connection, $queryinsert);

                if(!$result1){
                  die("Query Failed".mysqli_error($connection));
                }else{ 
                  echo "<script> alert('User Registration Successfuly!'); document.location.href = 'login.php'; </script>";
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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
</head>
<body>
    <!-- REGISTRATION -->
    <img src="images/craftsbg.png" alt="register image" class="register__img">
    <div class="container">
        <h1 class="register__title">CraftHub Registration</h1>
        <form action="" method="POST">
            <div class="registration__form">
                <div class="user_info">
                    <!-- Last Name -->
                    <div class="user-input-box">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastname" name="lastName" placeholder="Enter Last Name" required />
                    </div>
                    <!-- First Name -->
                    <div class="user-input-box">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstname" name="firstName" placeholder="Enter First Name" required />
                    </div>
                    <!-- Middle Name -->
                    <div class="user-input-box">
                        <label for="middleName">Middle Name</label>
                        <input type="text" id="middlename" name="middleName" placeholder="Enter Middle Name" required />
                    </div>
                </div>
                <div class="user_info2">
                    <!-- Address -->
                    <div class="user-input-box2 address">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Enter Address" required />
                    </div>
                </div>
                <div class="user_info3">
                    <!-- Birthday -->
                    <div class="user-input-box3">
                        <label for="bday">Birthday</label>
                        <input type="date" id="bday" name="bday" required />
                    </div>
                    <div class="user-input-box3">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" id="phonenumber" name="phoneNumber" placeholder="Enter Phone Number" maxlength="11" required oninput="validatePhoneNumber(this)" />
                    </div>
                                       
                    <!-- Email -->
                    <div class="user-input-box3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" required />
                    </div>
                </div>
                <div class="user_info4">
                    <!-- Username -->
                    <div class="user-input-box4">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter Username" required />
                    </div>
                    <!-- Password -->
                    <div class="user-input-box4">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" required/>
                    </div>
                    <!-- Confirm Password -->
                    <div class="user-input-box4">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required />
                    </div>
                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="register__check">
                <div class="register__check-group">
                    <input type="checkbox" class="register__check-input" id="register-check" required>
                    <label for="register-check" class="register__check-label">Terms & Conditions</label>
                </div>
            </div>
            <!-- Create Account Button -->
            <div class="register__button">
                <input type="submit" name="register" value="Register">
            </div>
            <p class="login__register">
                Already have an account? <a href="login.php">Log in</a>
            </p>
        </form>
    </div>

<!-- END OF REGISTRATION -->


    <!-- AGREE TERMS AND CONDITIONS MODAL -->
    <div class="modal fade" id="iagreeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><b>Introduction</b></p>
                    <p>Welcome to CraftHub, an online platform targeting buyers of handcrafted products and handmade crafts. 
                    When you access our systems and use the facilities made available to you on this website, 
                    you are bound by these terms and conditions. It is important that you take a few moments of your time to read these 
                    carefully to make sure that you understand your duties as well as rights when it comes to use of our services.</p></br>
                    <p><b>Terms and Conditions</b></p>
                    <p>Terms and Conditions of Use Upon creating an account or using CraftHub Inc. in any manner, 
                    you shall solely be bound to these terms and conditions. This agreement is a legally enforceable contract between you, 
                    the user, and CraftHub. Our platform is available to you on the condition that you will agree to the following terms 
                    and conditions As a result, if you do not accept these terms, it is recommended that you should not use our platform. 
                    CraftHub application requires the continued use by the user to signify their consent to any changes that we may make 
                    to these terms as and when necessary.</p></br>
                    <p><b>Definition of Terminology</b></p>
                    <p>For the purposes of these terms and conditions, the following definitions apply: Use refers to any individual 
                    who uses the services of CraftHub, whether as a buyer or a seller. The term ‘Seller’ in this context describes those 
                    who use the platform to offer handmade items for sale. For the purpose of this paper, a “Buyer” is defined as a user 
                    who is seeking to acquire a product from a seller. “Content” refers to all files that may be uploaded to the CraftHub 
                    platform, and this covers textual content, images, and product descriptions. Using the context of this particular project, 
                    the term “Platform” is defined as the CraftHub website and all sorts of services connected to it.</p></br>
                    <p><b>Intellectual Property Rights</b></p>
                    <p>Everything on CraftHub, such as texts, graphics, logos, and images is the property of CraftHub or the data’s owner 
                    and protected by laws from copyright. As for the content, it remains the property of its owner but users provide 
                    CraftHub with a non-exclusive license for using, public display, and distribution of content as a part of the services 
                    provided. Access to the website or parts of it is strictly prohibited if not duly authorized by CraftHub and it may 
                    infringe trademark as well as copyright law and all other applicable laws.</p></br>
                </div>
                <div class="modal-footer">
                    <input type="checkbox" class="agreeCheckbox" id="agreeCheckbox">
                    <label for="agreeCheckbox">I Agree to the Terms & Conditions</label>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF AGREE TERMS AND CONDITIONS MODAL -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- JAVASCRIPT FOR TERMS AND CONDITIONS -->
<script src="js/termsandconditions.js"></script>

</body>
</html>
