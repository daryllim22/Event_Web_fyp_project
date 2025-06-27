<?php
session_start();
include("connection.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, email, role, password FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_mail'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: home.php');
            }
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="login-container d-flex align-items-center justify-content-center vh-100">
    <form action="" method="POST" class="bg-light p-4 rounded shadow" style="min-width: 300px;">
        <h2 class="text-center mb-4">Login</h2>

        <div class="mb-3">
            <label>User ID</label>
            <input type="text" name="user_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <div class="text-center mt-3">
            <a href="create_account.php">Create Account</a>
        </div>

        <?php if (!empty($error)): ?>
            <p class="text-danger text-center mt-3"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
