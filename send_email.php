<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_GET['email']) && isset($_GET['name'])) {
    $email = $_GET['email'];
    $name = $_GET['name'];

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
        $mail->addAddress($email, $name);  // Add recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Merchant Application Submitted';
        $mail->Body    = "<p>Dear $name,</p><p>Thank you for registering with CraftHub! Your application has been successfully submitted and is currently under review.</p><p>We will notify you once it's processed.</p>";

        // Send the email
        $mail->send();
        echo "<script>alert('Email sent successfully!'); window.location.href='login.php';</script>";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Email or Name not set!";
}
?>
