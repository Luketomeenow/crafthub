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
    <form action="" method="POST">
        <div class="registration__form">
            <div class="user_info2">
                <!--=============== BUSINESS INFO ===============-->
                <div class="user-input-box2 address">
                    <label for="businessname">Business Name</label>
                    <input type="text" id="businessname" name="businessname" placeholder="Enter Business Name" required />
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter Email Address" required />

                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter Address" required />
                </div>
            </div>
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
            <div class="user_info4">
                <div class="user-input-box2">
                    <label for="number">Business Phone Number</label>
                    <input type="text" id="number" name="number" placeholder="Enter Business Phone Number" maxlength="11" required oninput="validatePhoneNumber(this)" />
                </div>
            </div>

              <!--=============== FILE UPLOADS ===============-->
            <div class="file-upload-container">
                <div class="file-upload">
                    <label for="dti_certificate">DTI Certificate</label>
                    <input type="file" id="dti_certificate" name="dti_certificate" accept=".pdf,.doc,.docx">
                </div>

                <div class="file-upload">
                    <label for="business_permit">Business Permit</label>
                    <input type="file" id="business_permit" name="business_permit" accept=".pdf,.doc,.docx">
                </div>

                <div class="file-upload">
                    <label for="bir_registration">BIR Registration</label>
                    <input type="file" id="bir_registration" name="bir_registration" accept=".pdf,.doc,.docx">
                </div>

                <div class="file-upload">
                    <label for="bir_0605">BIR 0605</label>
                    <input type="file" id="bir_0605" name="bir_0605" accept=".pdf,.doc,.docx">
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

</body>
</html>