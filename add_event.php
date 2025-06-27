<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_name  = $_POST['event_name'];
    $date        = $_POST['date'];
    $start_time  = $_POST['start_time'];
    $end_time    = $_POST['end_time'];
    $venue       = $_POST['venue'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO events (event_name, date, start_time, end_time, venue, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $event_name, $date, $start_time, $end_time, $venue, $description);
    $stmt->execute();
    $stmt->close();

    header("Location: event_db.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar d-flex justify-content-center gap-4 py-2 bg-light">
        <a href="admin_dashboard.php"><img src="images/user.png" alt="User" title="Admin Dashboard"></a>
        <a href="event_db.php"><img src="images/events.png" alt="Events" title="Event Database"></a>
        <a href="view_proposals.php"><img src="images/proposal.png" alt="Proposals" title="View Proposals"></a>
        <a href="view_participants.php"><img src="images/participants.png" alt="Participants" title="Event Participants"></a>
        <a href="login.php"><img src="images/logout.png" alt="Logout" title="Logout"></a>
    </nav>

    <div class="content">
        <div class="dashboard-section">
            <h2 class="mb-4">Add New Event</h2>

            <form method="POST" action="" class="bg-light p-4 rounded shadow" style="max-width: 700px; margin: auto;">
                <div class="mb-3">
                    <label class="form-label">Event Name</label>
                    <input type="text" name="event_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                    <div class="col">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Venue</label>
                    <input type="text" name="venue" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Enter event details..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Add Event</button>
            </form>
        </div>
    </div>
</body>
</html>
