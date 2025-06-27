<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_db");

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = null;

// Fetch user info
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - EventWorld</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar d-flex justify-content-center gap-4 py-2 bg-light">
        <a href="home.php">
            <img src="images/logo.jpg" alt="EventWorld Logo" style="height: 60px; margin-bottom: 10px;">
        </a>
        <a href="home.php"><img src="images/home.png" alt="Home"></a>
        <a href="events.php"><img src="images/events.png" alt="Events"></a>
        <a href="past_events.php"><img src="images/past_events.png" alt="Past Events"></a>
        <a href="event_proposal.php"><img src="images/proposal.png" alt="Submit Proposal"></a>
        <a href="profile.php"><img src="images/user_profile.png" alt="Profile"></a>
        <a href="login.php"><img src="images/logout.png" alt="Logout"></a>
    </nav>

    <div class="content">
        <div class="announcement-banner text-center p-5">
            <h1>My Profile</h1>

            <form action="update_profile.php" method="POST" class="mx-auto" style="max-width: 500px;">
                <div class="mb-3 text-start">
                    <label for="full_name" class="form-label"><strong>Full Name</strong></label>
                    <input type="text" id="full_name" name="full_name" class="form-control"
                           value="<?= htmlspecialchars($user['full_name']) ?>" readonly>
                </div>

                <div class="mb-3 text-start">
                    <label for="user_id" class="form-label"><strong>User ID</strong></label>
                    <input type="text" id="user_id" name="user_id" class="form-control"
                           value="<?= htmlspecialchars($user['user_id']) ?>" readonly>
                </div>

                <div class="mb-3 text-start">
                    <label for="email" class="form-label"><strong>Email</strong></label>
                    <input type="email" id="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="mb-3 text-start">
                    <label for="new_password" class="form-label"><strong>New Password</strong></label>
                    <input type="password" id="new_password" name="new_password" class="form-control"
                           placeholder="Leave blank to keep current password">
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Profile</button>

                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success mt-4" role="alert">
                        <?= htmlspecialchars($_SESSION['success_message']) ?>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
