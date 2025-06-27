<?php
$servername = "127.0.0.1"; // Replace 'localhost' with your MySQL server hostname
$username = "root"; // Replace 'root' with your MySQL username
$password = ""; // Replace '' with your MySQL password
$database = "event_db"; // Replace 'your_database' with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the connection is successful, you can use $conn to perform database operations.
// Example: $result = $conn->query("SELECT * FROM your_table");
?>