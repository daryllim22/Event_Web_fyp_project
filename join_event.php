<?php
session_start();
include 'connection.php';

$event_id = $_GET['event_id'] ?? '';

// Initialize
$full_name = '';
$student_id = '';

// Fetch from session & database
if (isset($_SESSION['user_id'])) {
    $student_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT full_name FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        $full_name = $user['full_name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="home.php"><img src="images/logo.jpg" alt="Logo"></a>
        <a href="home.php"><img src="images/home.png" alt="Home"></a>
        <a href="events.php"><img src="images/events.png" alt="Events"></a>
        <a href="past_events.php"><img src="images/past_events.png" alt="Past Events"></a>
        <a href="event_proposal.php"><img src="images/proposal.png" alt="Submit Proposal"></a>
        <a href="profile.php"><img src="images/user_profile.png" alt="Profile"></a>
        <a href="login.php"><img src="images/logout.png" alt="Logout"></a>
    </div>

    <!-- Join Event Form -->
    <div class="content d-flex justify-content-center align-items-center">
        <div class="announcement-banner p-4" style="width: 100%; max-width: 600px;">
            <h2 class="mb-4 text-center">Join This Event</h2>

            <form action="submit_join.php" method="POST" class="bg-light p-4 rounded shadow">
                <input type="hidden" name="event_id" value="<?= htmlspecialchars($event_id) ?>">

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($full_name) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Student ID</label>
                    <input type="text" name="student_id" class="form-control" value="<?= htmlspecialchars($student_id) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">School</label>
                    <select name="school" class="form-select" required>
                        <option value="">Select School</option>
                        <option value="School of Computing">School of Computing</option>
                        <option value="School of Business">School of Business</option>
                        <option value="School of Engineering">School of Engineering</option>
                        <option value="School of Design">School of Design</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
