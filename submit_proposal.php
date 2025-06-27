<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "event_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$title = $_POST['title'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$venue = $_POST['venue'];
$description = $_POST['description'];

// Prepare and insert
$sql = "INSERT INTO proposals (title, date, start_time, end_time, venue, description) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $title, $date, $start_time, $end_time, $venue, $description);
$success = $stmt->execute();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proposal Submission</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Same Navbar as event_proposal.php -->
    <nav class="navbar d-flex justify-content-center gap-4 py-2 bg-light">
        <a href="home.html"><img src="images/home.png" alt="Home"></a>
        <a href="events.php"><img src="images/events.png" alt="Events"></a>
        <a href="past_events.php"><img src="images/past_events.png" alt="Past Events"></a>
        <a href="submit_proposal_form.php"><img src="images/proposal.png" alt="Submit Proposal"></a>
        <a href="profile.php"><img src="images/user_profile.png" alt="Profile"></a>
        <a href="login.php"><img src="images/logout.png" alt="Logout"></a>
    </nav>

    <!-- Page Content -->
    <div class="container mt-5">
        <div class="bg-light p-5 rounded shadow text-center">
            <?php if ($success): ?>
                <h2 class="text-success mb-4">Proposal submitted successfully!</h2>
                <a href="events.php" class="btn btn-primary">Back to Events</a>
            <?php else: ?>
                <h2 class="text-danger mb-4">Error submitting proposal.</h2>
                <p>Please try again later.</p>
                <a href="submit_proposal_form.php" class="btn btn-secondary">Go Back</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
