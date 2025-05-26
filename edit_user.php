<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "event_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user_id from URL
if (!isset($_GET['user_id'])) {
    echo "User ID not provided.";
    exit;
}

$user_id = $_GET['user_id'];
$user = null;

// Fetch user details
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $role = $_POST['role'];
    $newPassword = $_POST['password'];

    // Update query
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSQL = "UPDATE users SET email = ?, role = ?, password = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateSQL);
        $updateStmt->bind_param("ssss", $email, $role, $hashedPassword, $user_id);
    } else {
        $updateSQL = "UPDATE users SET email = ?, role = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateSQL);
        $updateStmt->bind_param("sss", $email, $role, $user_id);
    }

    if ($updateStmt->execute()) {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error updating user: " . $conn->error . "</p>";
    }
    $updateStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit User - <?php echo htmlspecialchars($user_id); ?></h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="student" <?php if ($user['role'] === 'student') echo 'selected'; ?>>Student</option>
                <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
