<?php
$conn = new mysqli("localhost", "root", "", "event_db");

if (isset($_GET["token"])) {
    $token = $_GET["token"];
    $result = $conn->query("SELECT * FROM users WHERE reset_token='$token' AND reset_token_expire > NOW()");

    if ($result->num_rows === 1) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET password='$newPassword', reset_token=NULL, reset_token_expire=NULL WHERE reset_token='$token'");
            echo "<p class='text-success'>Password updated! <a href='login.php'>Login</a></p>";
        }

        echo '<form method="POST">
                <h2>New Password</h2>
                <input type="password" name="password" placeholder="New password" class="form-control mb-3" required>
                <button type="submit" class="btn btn-success">Reset Password</button>
              </form>';
    } else {
        echo "<p class='text-danger'>Invalid or expired token.</p>";
    }
}
$conn->close();
?>
