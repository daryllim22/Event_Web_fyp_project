<?php
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $conn = new mysqli("localhost", "root", "", "event_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user_id using email
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];

        // Generate reset token and expiry
        $token = bin2hex(random_bytes(16));
        $update = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expire = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE user_id = ?");
        $update->bind_param("ss", $token, $user_id);
        $update->execute();

        // Send email (use PHPMailer for production)
        $resetLink = "http://localhost/reset_password.php?token=$token";
        $subject = "Password Reset - EventWorld";
        $body = "Hello,\n\nClick the link below to reset your password:\n$resetLink\n\nThis link will expire in 15 minutes.";

        if (mail($email, $subject, $body)) {
            $message = "Password reset instructions have been sent to your email.";
        } else {
            $message = "Failed to send email. Please contact admin.";
        }
    } else {
        $message = "Email address not found.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Forgot Password</h2>
    <form action="" method="POST" class="bg-light p-4 rounded shadow">
        <div class="mb-3">
            <label for="email" class="form-label">Enter Your Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
    <?php if ($message): ?>
        <p class="text-center mt-3 text-info"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <div class="text-center mt-3">
        <a href="login.php">← Back to Login</a>
    </div>
</div>
</body>
</html>
