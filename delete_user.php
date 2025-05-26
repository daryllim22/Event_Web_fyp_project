<?php
// Check if user_id is provided in URL
if (!isset($_GET['user_id'])) {
    echo "User ID not provided.";
    exit;
}

$user_id = $_GET['user_id'];

// Connect to database
$conn = new mysqli("localhost", "root", "", "event_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute DELETE query
$sql = "DELETE FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);

if ($stmt->execute()) {
    // Redirect back to admin dashboard after deletion
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "<p class='text-danger'>Error deleting user: " . $conn->error . "</p>";
}

$stmt->close();
$conn->close();
?>
