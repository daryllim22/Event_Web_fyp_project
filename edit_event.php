<?php
session_start();
include 'connection.php';

// Restrict to admins only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Event ID missing.");
}

$id = intval($_GET['id']);
$message = '';

// Update event
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_name = $_POST['event_name'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE events SET event_name=?, date=?, start_time=?, end_time=?, venue=?, description=? WHERE id=?");
    $stmt->bind_param("ssssssi", $event_name, $date, $start_time, $end_time, $venue, $description, $id);

    if ($stmt->execute()) {
        header("Location: event_db.php");
        exit();
    } else {
        $message = "Update failed: " . $stmt->error;
    }
}

// Get current event
$result = $conn->query("SELECT * FROM events WHERE id = $id");
if ($result->num_rows !== 1) {
    die("Event not found.");
}
$event = $result->fetch_assoc();
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
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

    <div class="container mt-5" style="max-width: 700px;">
        <h2 class="mb-4 text-center">Edit Event</h2>
        <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" class="bg-light p-4 rounded shadow">
            <div class="mb-3">
                <label class="form-label">Event Name</label>
                <input type="text" name="event_name" class="form-control" value="<?= htmlspecialchars($event['event_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($event['date']) ?>" min="<?= $today ?>" required>
            </div>

            <div class="mb-3 row">
                <div class="col">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="start_time" class="form-control" value="<?= htmlspecialchars($event['start_time']) ?>" required>
                </div>
                <div class="col">
                    <label class="form-label">End Time</label>
                    <input type="time" name="end_time" class="form-control" value="<?= htmlspecialchars($event['end_time']) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Venue</label>
                <input type="text" name="venue" class="form-control" value="<?= htmlspecialchars($event['venue']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($event['description']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Event</button>
            <div class="text-center mt-3">
                <a href="event_db.php">← Back to Event Database</a>
            </div>
        </form>
    </div>
</body>
</html>
