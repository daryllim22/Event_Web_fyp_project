<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <a href="admin_dashboard.php"><img src="images/user.png" alt="User"></a>
        <a href="event_db.php"><img src="images/events.png" alt="Events"></a>
        <a href="login.php"><img src="images/logout.png" alt="Logout"></a>
    </nav>

    <div class="content">
        <div class="container mt-5">
            <h2>Add New Event</h2>
            <form action="" method="POST" class="bg-light p-4 rounded shadow" style="max-width: 600px;">
                <div class="mb-3">
                    <label for="event_name" class="form-label">Event Name</label>
                    <input type="text" name="event_name" id="event_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" name="time" id="time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="venue" class="form-label">Venue</label>
                    <input type="text" name="venue" id="venue" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Add Event</button>
                <div class="text-center mt-3">
                <a href="event_db.php" class="btn btn-secondary">Back to Event Database</a>
                </div>

            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $conn = new mysqli("localhost", "root", "", "event_db");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $event_name = $_POST['event_name'];
                $date = $_POST['date'];
                $time = $_POST['time'];
                $venue = $_POST['venue'];

                $sql = "INSERT INTO events (event_name, date, time, venue) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $event_name, $date, $time, $venue);

                if ($stmt->execute()) {
                    echo "<p class='text-success mt-3'>Event added successfully!</p>";
                } else {
                    echo "<p class='text-danger mt-3'>Error: " . $stmt->error . "</p>";
                }

                $stmt->close();
                $conn->close();
            }
            ?>
        </div>
    </div>
</body>
</html>
