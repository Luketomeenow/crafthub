<?php 
session_start();
include 'dbcon.php';

    if(isset($_POST['register'])){
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $owner_add = $_POST['owner_add'];
        $shop_name = $_POST['shop_name'];
        $busi_email = $_POST['busi_email'];
        $busi_contact = $_POST['busi_contact'];
        $municipality = $_POST['municipality'];
        $barangay = $_POST['barangay'];
        $street = $_POST['street'];
        
        
        // Handle file uploads
        $dti_cert_path = uploadFile('dti_cert');
        $busi_permit_path = uploadFile('busi_permit');
        $bir_reg_path = uploadFile('bir_reg');
        $bir_0605_path = uploadFile('bir_0605');

        // Insert data into database
        $queryinsert = "INSERT INTO 
        `crafthub_merchant_applicant`(`lname`,`fname`,`mname`,`owner_add`,`shop_name`, `shop_email`, `shop_contactno`, `shop_municipality`, `shop_barangay`, `shop_street`, `business_permit`, `BIR_registration`, `BIR_0605`, `DTI_cert`, `status`) 
        VALUES ('$lname','$fname','$mname','$owner_add','$shop_name','$busi_email','$busi_contact','$municipality','$barangay','$street','$busi_permit_path','$bir_reg_path','$bir_0605_path','$dti_cert_path','pending')";

        $result1 = mysqli_query($connection, $queryinsert);

        if(!$result1){
            die("Query Failed: " . mysqli_error($connection));
        } else { 
            header("Location: send_email.php?email=$busi_email&name=$fname");
        }  
    }

    function uploadFile($input_name) {
        $target_dir = "uploads/"; // Directory where uploaded files will be saved
        $target_file = $target_dir . basename($_FILES[$input_name]["name"]); // Get the filename of the uploaded file
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if file is a PDF
        if($fileType != "pdf") {
            echo "Sorry, only PDF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $target_file)) {
                return $target_file; // Return the path of the uploaded file
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    function sendEmail($data) {
        // Initiate cURL session to send email via POST to send_email.php
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "send_email.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="css/mregister.css" rel="stylesheet">
</head>
<body>
   <!--=============== REGISTER CONTENT ===============-->
<img src="images/craftsbg.png" alt="register image" class="register__img">
<div class="container">
    <h1 class="register__title">CraftHub Merchant Registration</h1>
    <form action=""  method="POST" enctype="multipart/form-data">
        <div class="registration__form">
        <h5>Business Owner Information</h5>
            <div class="user_info3">
                
                <!--=============== ADDRESS ===============-->
                <div class="user-input-box3">
                    
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastname" name="lname" placeholder="Enter Last Name" required />
                </div>
                <div class="user-input-box3">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstname" name="fname" placeholder="Enter First Name" required />
                </div>
                <div class="user-input-box3">
                    <label for="middleName">Middle Name</label>
                    <input type="text" id="middlename" name="mname" placeholder="Enter Middle Name" required />
                </div>
            </div>
            <div class="user_info2">
                
                
                <!--=============== BUSINESS INFO ===============-->
                <div class="user-input-box2 address">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="owner_add" placeholder="Enter Address" required />
                    <label for="businessname">Business Name</label>
                    <input type="text" id="businessname" name="shop_name" placeholder="Enter Business Name" required />
                    
                    <label for="email">Business Email Address</label>
                    <input type="text" id="email" name="busi_email" placeholder="Enter Email Address" required />
                    
                </div>
                <div class="user_info4">
                <div class="user-input-box2">
                    <label for="number">Business Phone Number</label>
                    <input type="text" id="number" name="busi_contact" placeholder="Enter Business Phone Number" maxlength="11" required oninput="validatePhoneNumber(this)" />
                </div>
            </div>
            </div>
            <label >Business Address</label>
            <div class="user_info3">
                
                <!--=============== ADDRESS ===============-->
                <div class="user-input-box3">
                    <label for="municipality">Municipality</label>
                    <input type="text" id="municipality" name="municipality" placeholder="Enter Municipality" required />
                </div>
                <div class="user-input-box3">
                    <label for="barangay">Barangay</label>
                    <input type="text" id="barangay" name="barangay" placeholder="Enter Barangay" required />
                </div>
                <div class="user-input-box3">
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" placeholder="Enter Street Name" required />
                </div>
            </div>
            

              <!--=============== FILE UPLOADS ===============-->
            <div class="file-upload-container">
                <div class="file-upload">
                    <label for="dti_certificate">DTI Certificate</label>
                    <input type="file" id="dti_cert" name="dti_cert" accept="application/pdf" required onchange="previewPDF(this, 'dti_cert')">
                    
                </div>

                <div class="file-upload">
                    <label for="business_permit">Business Permit</label>
                    <input type="file" id="busi_permit" name="busi_permit" accept="application/pdf" required onchange="previewPDF(this, 'busi_permit')">
                   
                </div>

                <div class="file-upload">
                    <label for="bir_registration">BIR Registration</label>
                    <input type="file" id="bir_reg" name="bir_reg" accept="application/pdf" required onchange="previewPDF(this, 'bir_reg')">
                    
                </div>

                <div class="file-upload">
                    <label for="bir_0605">BIR 0605</label>
                    <input type="file" id="bir_0605" name="bir_0605" accept="application/pdf" required onchange="previewPDF(this, 'bir_0605')">
                    
                </div>
            </div>


            <!--=============== TERMS AND CONDITIONS ===============-->
            <div class="register__check">
                <div class="register__check-group">
                    <input type="checkbox" class="register__check-input" id="register-check" required>
                    <label for="register-check" class="register__check-label">I agree to the Terms & Conditions</label>
                </div>
            </div>
            <!--=============== REGISTER BUTTON ===============-->
            <div class="register__button">
                <input type="submit" name="register" value="Register">
            </div>
            <p class="login__register">
                Already have an account? <a href="login.php">Log in</a>
            </p>
        </div>
    </form>
</div>
<!--=============== END OF REGISTER CONTENT ===============-->

   <!-- Modal for pdf -->
   <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>                   
                </div>
                <div class="modal-body">
                    <iframe class="pdf-preview" id="pdfPreviewFrame" data-input-id=""></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="removePDF()">Delete PDF</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--=============== TERMS AND CONDITIONS MODAL ===============-->
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
<!--=============== END OF TERMS AND CONDITIONS MODAL ===============-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/termsandconditions.js"></script>
<script src="js/previewpdf.js"></script>
</body>
</html>