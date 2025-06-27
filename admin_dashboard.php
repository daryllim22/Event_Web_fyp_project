<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        <div class="dashboard-section">
            <h2>User Management</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "event_db");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT full_name, user_id, email, role FROM users";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                            echo "<td>
                                <a href='edit_user.php?user_id=" . urlencode($row['user_id']) . "' class='btn btn-sm btn-primary'>Edit</a>
                                <a href='delete_user.php?user_id=" . urlencode($row['user_id']) . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No users found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
