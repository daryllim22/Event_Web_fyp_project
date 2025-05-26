<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container d-flex align-items-center justify-content-center w-100">
        <form action="" method="POST" class="bg-light p-4 rounded shadow" style="min-width: 300px;">
            <h2 class="text-center mb-4">Login</h2>

            <div class="mb-3">
                <label for="user_id" class="form-label">User ID</label>
                <input type="text" name="user_id" id="user_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>

            <div class="text-center mt-3">
                <a href="create_account.php" class="text-decoration-none">Create Account</a>
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $user_id = $_POST['user_id'];
                $password = $_POST['password'];

                $conn = new mysqli("localhost", "root", "", "event_db");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM users WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();

                    if (password_verify($password, $user['password'])) {
                        // Redirect by role
                        if ($user['role'] === 'admin') {
                            header("Location: admin_dashboard.php");
                            exit();
                        } else {
                            header("Location: home.html");
                            exit();
                        }
                    } else {
                        echo "<p class='text-danger text-center mt-3'>Invalid password.</p>";
                    }
                } else {
                    echo "<p class='text-danger text-center mt-3'>User ID not found.</p>";
                }

                $conn->close();
            }
            ?>
        </form>
    </div>
</body>
</html>
