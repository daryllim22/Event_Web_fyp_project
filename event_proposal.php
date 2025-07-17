<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Event Proposal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
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

    <div class="container mt-5">
        <h2 class="text-center mb-4">Submit Event Proposal</h2>
        <form action="submit_proposal.php" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow" style="max-width: 700px; margin: auto;">
            <div class="mb-3">
                <label for="title" class="form-label">Event Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" required min="<?= date('Y-m-d') ?>">
            </div>

            <div class="mb-3 row">
                <div class="col">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" name="start_time" id="start_time" class="form-control" required>
                </div>
                <div class="col">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time" name="end_time" id="end_time" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="venue" class="form-label">Venue</label>
                <input type="text" name="venue" id="venue" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Event Description</label>
                <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
            </div>

            <!-- New Poster Upload Field -->
            <div class="mb-3">
                <label for="poster" class="form-label">Event Poster</label>
                <input type="file" name="poster" id="poster" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Proposal</button>
        </form>
    </div>
</body>
</html>
