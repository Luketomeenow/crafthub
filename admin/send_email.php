<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Import PHPMailer classes into the global namespace
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include 'dbcon.php'; // Include your database connection

if (isset($_POST['decision'])) {
    $decision = $_POST['decision'];
    $reg_id = $_POST['reg_id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];

    // If the decision is to approve, update the status to "processing"
    if ($decision == 'approve') {
        $update_status_query = "
        UPDATE crafthub_merchant_applicant 
        SET status = 'processing' 
        WHERE reg_id = '$reg_id'";

        $update_result = mysqli_query($connection, $update_status_query);

        if (!$update_result) {
            die("Status Update Failed: " . mysqli_error($connection));
        }
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mlgquindoy@bpsu.edu.ph'; 
        $mail->Password = 'ojjscwizjqjioyur';    
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('mlgquindoy@bpsu.edu.ph', 'CraftHub Admin'); 
        $mail->addAddress($email, $name);  // recipient

        // Email content
        $mail->isHTML(true);

        if ($decision == 'approve') {
            $mail->Subject = 'Congratulations! Your Application has been Approved';
            $mail->Body    = "<p>Dear $name,</p><p>Your application (ID: $reg_id) has been approved and is now being processed. Welcome to CraftHub!</p>";
        } elseif ($decision == 'reject') {
            $mail->Subject = 'Application Rejection';
            $mail->Body    = "<p>Dear $name,</p><p>We regret to inform you that your application (ID: $reg_id) has been rejected.</p><p>Comment: $comment</p>";
        }

        // Send the email
        $mail->send();
        echo "<script>alert('Email has been sent successfully.'); window.location.href = 'adminprocessing.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Email could not be sent. Error: {$mail->ErrorInfo}');</script>";
    }
}
?>
