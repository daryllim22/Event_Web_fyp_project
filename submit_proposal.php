<?php
// Database connection
$servername = "localhost";
$username = "root"; // your DB username
$password = "";     // your DB password
$dbname = "event_db"; // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $title = $conn->real_escape_string($_POST['title']);
    $date = $conn->real_escape_string($_POST['date']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $venue = $conn->real_escape_string($_POST['venue']);
    $description = $conn->real_escape_string($_POST['description']);

    // Handle file upload
    $target_dir = "uploads/"; // make sure this folder exists & is writable
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // create folder if not exists
    }

    $poster = $_FILES['poster'];
    $poster_name = basename($poster["name"]);
    $poster_tmp = $poster["tmp_name"];
    $poster_size = $poster["size"];
    $poster_type = strtolower(pathinfo($poster_name, PATHINFO_EXTENSION));

    // Validate image
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($poster_type, $allowed_types)) {
        die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
    }

    if ($poster_size > 2 * 1024 * 1024) { // 2MB limit
        die("Error: File size should not exceed 2MB.");
    }

    // Generate unique filename
    $new_poster_name = uniqid("poster_", true) . "." . $poster_type;
    $target_file = $target_dir . $new_poster_name;

    if (move_uploaded_file($poster_tmp, $target_file)) {
        // Save to database
        $sql = "INSERT INTO proposals (title, date, start_time, end_time, venue, description, poster) 
                VALUES ('$title', '$date', '$start_time', '$end_time', '$venue', '$description', '$new_poster_name')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Event proposal submitted successfully!'); window.location.href='events.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        die("Error uploading poster file.");
    }
}

$conn->close();
?>
