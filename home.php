<?php
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page - EventWorld</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .carousel-wrapper {
            max-width: 800px;
            margin: auto;
        }
        #carouselImage {
            height: 400px;
            object-fit: contain;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar d-flex justify-content-center gap-4 py-2 bg-light">
        <a href="home.php"><img src="images/logo.jpg" alt="EventWorld Logo" style="height: 60px; margin-bottom: 10px;"></a>
        <a href="home.php"><img src="images/home.png" alt="Home"></a>
        <a href="events.php"><img src="images/events.png" alt="Events"></a>
        <a href="past_events.php"><img src="images/past_events.png" alt="Past Events"></a>
        <a href="event_proposal.php"><img src="images/proposal.png" alt="Submit Proposal"></a>
        <a href="profile.php"><img src="images/user_profile.png" alt="Profile"></a>
        <a href="login.php"><img src="images/logout.png" alt="Logout"></a>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <div class="announcement-banner text-center p-5">
            <h1>Welcome to <strong>EventWorld</strong></h1>
            <p class="mt-3 fs-5">
                EventWorld is your all-in-one platform to explore and manage events within your campus community.
                From student gatherings to official university functions, everything you need is just a click away.
            </p>
            <p class="fs-5">
                Whether you're looking to participate in upcoming events or propose your own ideas,
                EventWorld offers a simple and engaging experience for students and organizers alike.
                Start your journey today and make every moment count!
            </p>

            <!-- Custom JavaScript Carousel -->
            <div class="carousel-wrapper my-4">
                <div id="jsCarousel" class="position-relative text-center">
                    <img id="carouselImage" src="images/ai_talk.jpg" class="img-fluid rounded shadow" alt="Event Image">
                    <div class="mt-3">
                        <button onclick="prevImage()" class="btn btn-outline-primary me-2">⟨ Prev</button>
                        <button onclick="nextImage()" class="btn btn-outline-primary">Next ⟩</button>
                    </div>
                </div>
            </div>

            <a href="events.php" class="btn btn-primary mt-3">Explore Events</a>
        </div>
    </div>

    <!-- Bootstrap JS and Carousel Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const images = [
            'images/ai_talk.jpg',
            'images/food_carnival.jpg',
            'images/sports_day.jpg'
        ];
        let currentIndex = 0;

        function showImage(index) {
            const img = document.getElementById('carouselImage');
            img.src = images[index];
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % images.length;
            showImage(currentIndex);
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            showImage(currentIndex);
        }
    </script>
</body>
</html>
