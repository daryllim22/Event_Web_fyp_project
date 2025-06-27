<?php
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $user_id = $_POST['user_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // DB connection
    $conn = new mysqli("localhost", "root", "", "event_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user_id or email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE user_id = ? OR email = ?");
    $check->bind_param("ss", $user_id, $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $error = "User ID or email already exists.";
    } else {
        // Insert user
        $stmt = $conn->prepare("INSERT INTO users (user_id, full_name, email, role, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $user_id, $full_name, $email, $role, $password);

        if ($stmt->execute()) {
            $success = "Account created successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="create-account-container d-flex align-items-center justify-content-center w-100">
    <form action="" method="POST" class="bg-light p-4 rounded shadow" style="min-width: 300px;">
        <h2 class="text-center mb-4">Create Account</h2>

        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" name="full_name" id="full_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="student">Student</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="text" name="user_id" id="user_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Account</button>

        <div class="text-center mt-3">
            <a href="login.php" class="text-decoration-none">Already have an account? Login</a>
        </div>

        <?php if ($success): ?>
            <p class="text-success text-center mt-3"><?= htmlspecialchars($success) ?></p>
        <?php elseif ($error): ?>
            <p class="text-danger text-center mt-3"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
