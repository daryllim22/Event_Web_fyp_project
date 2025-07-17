<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch only upcoming events
$sql = "SELECT * FROM events WHERE date >= CURDATE() ORDER BY date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upcoming Events - EventWorld</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Use global styles -->
    <style>
        /* Same style as past_events.php */
        .card-img-top {
            height: 220px; /* fixed height for uniformity */
            object-fit: cover; /* crops image nicely */
            border-bottom: 3px solid #dee2e6;
            border-radius: 10px 10px 0 0;
        }
        .modal-poster {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            margin-bottom: 15px;
        }
        .card {
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="navbar">
        <a href="home.php"><img src="images/logo.jpg" alt="EventWorld Logo"></a>
        <a href="home.php"><img src="images/home.png" alt="Home"></a>
        <a href="events.php"><img src="images/events.png" alt="Events"></a>
        <a href="past_events.php"><img src="images/past_events.png" alt="Past Events"></a>
        <a href="event_proposal.php"><img src="images/proposal.png" alt="Submit Proposal"></a>
        <a href="profile.php"><img src="images/user_profile.png" alt="Profile"></a>
        <a href="login.php"><img src="images/logout.png" alt="Logout"></a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="text-center mb-4">Upcoming Events</h2>
        <div class="row px-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($event = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100" data-bs-toggle="modal" data-bs-target="#eventModal<?= $event['id'] ?>">
                            <!-- Poster -->
                            <img src="uploads/<?= htmlspecialchars($event['poster']) ?>" class="card-img-top" alt="Event Poster">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($event['event_name']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars($event['date']) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="eventModal<?= $event['id'] ?>" tabindex="-1" aria-labelledby="eventModalLabel<?= $event['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventModalLabel<?= $event['id'] ?>"><?= htmlspecialchars($event['event_name']); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="uploads/<?= htmlspecialchars($event['poster']) ?>" class="modal-poster img-fluid rounded shadow mb-3" alt="Event Poster">
                                    <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                                    <p><strong>Time:</strong> <?= date("g:i A", strtotime($event['start_time'])) ?> - <?= date("g:i A", strtotime($event['end_time'])) ?></p>
                                    <p><strong>Venue:</strong> <?= htmlspecialchars($event['venue']) ?></p>
                                    <?php if (!empty($event['description'])): ?>
                                        <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">🎉 No upcoming events found. Check back later!</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
