<?php
$conn = new mysqli("localhost", "root", "", "event_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, event_name, date, start_time, end_time, venue, description FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Database</title>
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
            <h2>Event Database</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Time (Start - End)</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$result) {
                        echo "<tr><td colspan='7'>Query failed: " . $conn->error . "</td></tr>";
                    } elseif ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                            echo "<td>" . date("g:i A", strtotime($row['start_time'])) . " - " . date("g:i A", strtotime($row['end_time'])) . "</td>";
                            echo "<td>" . htmlspecialchars($row['venue']) . "</td>";
                            echo "<td>" . nl2br(htmlspecialchars($row['description'])) . "</td>";
                            echo "<td>
                                <a href='edit_event.php?id=" . urlencode($row['id']) . "' class='btn btn-sm btn-primary'>Edit</a>
                                <a href='delete_event.php?id=" . urlencode($row['id']) . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No events found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
            <a href="add_event.php" class="btn btn-success mt-3">Add New Event</a>
        </div>
    </div>
</body>
</html>
