<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Import PHPMailer classes into the global namespace
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include 'dbcon.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reg_id = mysqli_real_escape_string($connection, $_POST['reg_id']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Insert the data into the crafthub_merchant table without hashing the password
    $insert_query = "INSERT INTO crafthub_merchant (reg_id, username, password) VALUES ('$reg_id', '$email', '$password')";

    if (mysqli_query($connection, $insert_query)) {
        // Update the status of the applicant to 'approved'
        $update_status_query = "UPDATE crafthub_merchant_applicant 
                                SET status = 'approved' 
                                WHERE reg_id = '$reg_id'";
        
        if (!mysqli_query($connection, $update_status_query)) {
            die("Status Update Failed: " . mysqli_error($connection));
        }

        // Email the applicant with their username and password
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mlgquindoy@bpsu.edu.ph'; // Your email
            $mail->Password = 'ojjscwizjqjioyur'; // Your email password or app-specific password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('mlgquindoy@bpsu.edu.ph', 'CraftHub Admin'); 
            $mail->addAddress($email);  // recipient

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your CraftHub Merchant Account Has Been Created';
            $mail->Body    = "<p>Dear Merchant,</p>
                              <p>Your account has been successfully created.</p>
                              <p>Here are your login details:</p>
                              <p><strong>Username:</strong> $email</p>
                              <p><strong>Password:</strong> $password</p>
                              <p>Please keep this information safe and secure.</p>
                              <p>Best regards,<br>CraftHub Team</p>";

            // Send the email
            $mail->send();
            echo "<script>alert('Merchant account created and email sent successfully.'); window.location.href = 'adminaccsetup.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Merchant account created, but email could not be sent. Error: {$mail->ErrorInfo}'); window.location.href = 'adminaccsetup.php';</script>";
        }
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
