<?php
// Database connection (adjust the credentials as per your setup)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update_text = $conn->real_escape_string($_POST['daily_update']);

    if (isset($_POST['post'])) {
        // Insert the update into the database
        $sql = "INSERT INTO daily_updates_db (update_text, status) VALUES ('$update_text', 'Posted')";
        if ($conn->query($sql) === TRUE) {
            echo "Update posted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['save'])) {
        // Save the update in the database without posting
        $sql = "INSERT INTO daily_updates_db (update_text, status) VALUES ('$update_text', 'Saved')";
        if ($conn->query($sql) === TRUE) {
            echo "Update saved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['delete'])) {
        // Delete the update
        $sql = "DELETE FROM daily_updates_db WHERE update_text = '$update_text'";
        if ($conn->query($sql) === TRUE) {
            echo "Update deleted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>



