<?php
$conn = new mysqli("localhost", "root", "", "event_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM proposals ORDER BY submitted_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Proposals</title>
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
        <div class="event-section">
            <h2>Submitted Event Proposals</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['date']) ?></td>
                                <td><?= htmlspecialchars(substr($row['start_time'], 0, 5)) ?></td>
                                <td><?= htmlspecialchars(substr($row['end_time'], 0, 5)) ?></td>
                                <td><?= htmlspecialchars($row['venue']) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                                <td><?= htmlspecialchars($row['submitted_at']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">No proposals found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
