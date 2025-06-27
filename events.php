<?php
include 'connection.php';

$query = "SELECT * FROM events WHERE date >= CURDATE() ORDER BY date ASC";
$result = $conn->query($query);

// Function to map event name to image
function getEventImage($eventName) {
    $eventName = strtolower($eventName);

    if (strpos($eventName, 'sport') !== false) {
        return 'images/sports_day.jpg';
    } elseif (strpos($eventName, 'food') !== false || strpos($eventName, 'carnival') !== false) {
        return 'images/food_carnival.jpg';
    } elseif (strpos($eventName, 'ai') !== false || strpos($eventName, 'artificial intelligence') !== false) {
        return 'images/ai_talk.jpg';
    } else {
        return 'images/event_default.jpg';
    }
}
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

    <!-- Page Content -->
    <div class="content">
        <h2 class="text-center mb-4">Upcoming Events</h2>
        <div class="row px-4">
            <?php while ($event = $result->fetch_assoc()): ?>
                <?php $imageSrc = getEventImage($event['event_name']); ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100" data-bs-toggle="modal" data-bs-target="#eventModal<?= $event['id'] ?>" style="cursor:pointer;">
                        <img src="<?= $imageSrc ?>" class="card-img-top" alt="Event Image">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($event['event_name']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($event['date']) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="eventModal<?= $event['id'] ?>" tabindex="-1" aria-labelledby="eventModalLabel<?= $event['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eventModalLabel<?= $event['id'] ?>"><?= htmlspecialchars($event['event_name']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                                <p><strong>Time:</strong> <?= date("g:i A", strtotime($event['start_time'])) ?> - <?= date("g:i A", strtotime($event['end_time'])) ?></p>
                                <p><strong>Venue:</strong> <?= htmlspecialchars($event['venue']) ?></p>
                                <?php if (!empty($event['description'])): ?>
                                    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer justify-content-start">
                                <a href="join_event.php?event_id=<?= urlencode($event['id']) ?>" class="btn btn-success">Join Event</a>
                            </div>    
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Bootstrap JS for Modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
