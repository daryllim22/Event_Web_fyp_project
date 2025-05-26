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

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST['email'];
                $role = $_POST['role'];
                $user_id = $_POST['user_id'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                // DB connection
                $conn = new mysqli("localhost", "root", "", "event_db");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Insert into users table
                $sql = "INSERT INTO users (user_id, email, role, password) VALUES ('$user_id', '$email', '$role', '$password')";

                if ($conn->query($sql) === TRUE) {
                    echo "<p class='text-success text-center mt-3'>Account created successfully!</p>";
                } else {
                    echo "<p class='text-danger text-center mt-3'>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }

                $conn->close();
            }
            ?>
        </form>
    </div>
</body>
</html>
