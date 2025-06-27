<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET email = ?, password = ? WHERE user_id = ?");
        $stmt->bind_param("sss", $email, $hashed_password, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE user_id = ?");
        $stmt->bind_param("ss", $email, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['user_mail'] = $email;
        $_SESSION['success_message'] = "Profile updated successfully!";
    } else {
        $_SESSION['success_message'] = "Failed to update profile.";
    }

    header("Location: profile.php");
    exit();
}
?>
