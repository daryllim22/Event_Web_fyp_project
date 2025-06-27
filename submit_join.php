<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$event_id     = $_POST['event_id'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';
$school       = $_POST['school'] ?? '';

// Get user data from session
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit();
}

$student_id = $_SESSION['user_id'];
$full_name = '';

// Fetch full name from database
$stmt = $conn->prepare("SELECT full_name FROM users WHERE user_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $full_name = $user['full_name'];
}

$stmt->close();

// Validate and insert
if ($event_id && $student_id && $full_name && $phone_number && $school) {
    $stmt = $conn->prepare("INSERT INTO event_participants (event_id, student_name, student_id, phone_number, school) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $event_id, $full_name, $student_id, $phone_number, $school);

    if ($stmt->execute()) {
        echo "<script>alert('Successfully joined event!'); window.location.href='events.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "All fields are required.";
}

$conn->close();
?>
