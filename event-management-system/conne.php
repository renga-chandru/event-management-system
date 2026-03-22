<?php
// Database connection details
$servername = "localhost";  // Server name (default for XAMPP is localhost)
$username = "root";         // Default username for XAMPP
$password = "";             // Default password for XAMPP (leave blank)
$dbname = "chandru";         // Name of your database

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Uncomment the below line to debug and verify connection
// echo "Connected successfully to the 'orders' database.";
?>
