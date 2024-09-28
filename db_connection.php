<?php
$servername = "localhost";
$username = "root"; // Default user for XAMPP/MAMP
$password = ""; // No password by default for XAMPP/MAMP
$dbname = "chat_system"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
