<?php
include 'connection.php';

if (!isset($_GET['id'])) {
    die("Event not found.");
}

$id = intval($_GET['id']);
$query = "SELECT * FROM events WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    die("Event not found.");
}

$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($event['event_name']) ?> - Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <a href="events.php" class="btn btn-secondary mb-4">← Back to Events</a>
        
        <h2><?= htmlspecialchars($event['event_name']) ?></h2>
        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
        <p><strong>Time:</strong> <?= date("g:i A", strtotime($event['time'])) ?></p>
        <p><strong>Venue:</strong> <?= htmlspecialchars($event['venue']) ?></p>
    </div>
</body>
</html>
