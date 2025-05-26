<?php
include 'connection.php';

$query = "SELECT * FROM events ORDER BY date ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <a href="home.html"><img src="images/home.png" alt="Home"></a>
        <a href="events.php"><img src="images/events.png" alt="Events"></a>
        <a href="past_events.php"><img src="images/past_events.png" alt="Past Events"></a>
        <a href="login.php"><img src="images/logout.png" alt="Logout"></a>
    </nav>

    <div class="content">
        <h2 class="text-center mb-4">Upcoming Events</h2>
        <div class="row">
            <?php while ($event = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <!-- Optional static image or replace with $event['image_url'] if dynamic -->
                        <img src="images/event_default.jpg" class="card-img-top" alt="Event Image">

                        <div class="card-body text-center">
                            <!-- Clickable Event Name -->
                            <h5 class="card-title">
                            <a href="event_detail.php?id=<?= $event['id'] ?>" class="text-decoration-none text-dark">
                            <?= htmlspecialchars($event['event_name']) ?>
                            </a>
                            </h5>

                            <!-- Date Below Title -->
                            <p class="card-text text-muted"><?= htmlspecialchars($event['date']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
