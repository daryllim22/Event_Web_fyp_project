<?php
session_start();
$conn = new mysqli("localhost", "root", "", "event_db");

// Admin check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch participant data
$sql = "SELECT ep.id, ep.student_name, ep.student_id, ep.phone_number, ep.school, e.event_name
        FROM event_participants ep
        JOIN events e ON ep.event_id = e.id
        ORDER BY e.date ASC, ep.student_name ASC";
$result = $conn->query($sql);

// Count participants by school for pie chart
$schoolCounts = [];
$chartQuery = "SELECT school, COUNT(*) as count FROM event_participants GROUP BY school";
$chartResult = $conn->query($chartQuery);
while ($row = $chartResult->fetch_assoc()) {
    $schoolCounts[$row['school']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Participants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar d-flex justify-content-center gap-4 py-2 bg-light">
        <a href="admin_dashboard.php"><img src="images/user.png" alt="User" title="Admin Dashboard"></a>
        <a href="event_db.php"><img src="images/events.png" alt="Events" title="Event Database"></a>
        <a href="view_proposals.php"><img src="images/proposal.png" alt="Proposals" title="View Proposals"></a>
        <a href="view_participants.php"><img src="images/participants.png" alt="Participants" title="Event Participants"></a>
        <a href="login.php"><img src="images/logout.png" alt="Logout" title="Logout"></a>
    </nav>

    <div class="content container mt-4">
        <h2 class="mb-4 text-center">Students Who Joined Events</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Phone</th>
                    <th>School</th>
                    <th>Event Name</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['student_name']) ?></td>
                            <td><?= htmlspecialchars($row['student_id']) ?></td>
                            <td><?= htmlspecialchars($row['phone_number']) ?></td>
                            <td><?= htmlspecialchars($row['school']) ?></td>
                            <td><?= htmlspecialchars($row['event_name']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No participants found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pie Chart Section -->
        <div class="text-center mt-5">
            <h4>Participation by School</h4>
            <div style="width: 250px; height: 250px; margin: 0 auto;">
                <canvas id="schoolChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('schoolChart').getContext('2d');
        const schoolChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode(array_keys($schoolCounts)) ?>,
                datasets: [{
                    data: <?= json_encode(array_values($schoolCounts)) ?>,
                    backgroundColor: [
                        '#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f',
                        '#edc948', '#b07aa1', '#ff9da7', '#9c755f', '#bab0ab'
                    ],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
