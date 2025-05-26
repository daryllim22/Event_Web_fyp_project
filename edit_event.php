<?php
$conn = new mysqli("localhost", "root", "", "event_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    echo "Event ID not provided.";
    exit;
}

$id = $_GET['id'];
$event = null;

// Get event data
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $event = $result->fetch_assoc();
} else {
    echo "Event not found.";
    exit;
}
$stmt->close();

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];

    $update = $conn->prepare("UPDATE events SET event_name = ?, date = ?, time = ?, venue = ? WHERE id = ?");
    $update->bind_param("ssssi", $event_name, $date, $time, $venue, $id);

    if ($update->execute()) {
        header("Location: event_db.php");
        exit();
    } else {
        echo "<p class='text-danger'>Update failed: " . $conn->error . "</p>";
    }
    $update->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Event - ID: <?php echo htmlspecialchars($id); ?></h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Event Name</label>
            <input type="text" name="event_name" class="form-control" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($event['date']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="time" name="time" class="form-control" value="<?php echo htmlspecialchars($event['time']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Venue</label>
            <input type="text" name="venue" class="form-control" value="<?php echo htmlspecialchars($event['venue']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="event_db.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
