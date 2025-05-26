<?php
if (!isset($_GET['id'])) {
    echo "Event ID not provided.";
    exit;
}

$id = $_GET['id'];

$conn = new mysqli("localhost", "root", "", "event_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: event_db.php");
    exit();
} else {
    echo "<p class='text-danger'>Failed to delete event: " . $conn->error . "</p>";
}

$stmt->close();
$conn->close();
?>
