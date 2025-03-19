<?php
$host = "localhost";
$db_username = "root"; // Your MySQL username
$db_password = ""; // Your MySQL password (empty for XAMPP default)
$db_name = "login"; // Replace with your actual database name

$conn = new mysqli($host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
