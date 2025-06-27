<?php
$conn = new mysqli("localhost", "root", "", "event_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id   = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $role      = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("ssss", $full_name, $email, $role, $user_id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?update=success");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
