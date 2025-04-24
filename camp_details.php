<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campName = $conn->real_escape_string($_POST['camp_name']);
    $campLocation = $conn->real_escape_string($_POST['camp_location']);
    $campDate = $conn->real_escape_string($_POST['camp_date']);

    if (isset($_POST['save'])) {
        // Save the camp details
        $sql = "INSERT INTO camp_details (camp_name, camp_location, camp_date, status) VALUES ('$campName', '$campLocation', '$campDate', 'Saved')";
        if ($conn->query($sql) === TRUE) {
            echo "Camp details saved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['submit'])) {
        // Submit the camp details
        $sql = "INSERT INTO camp_details (camp_name, camp_location, camp_date, status) VALUES ('$campName', '$campLocation', '$campDate', 'Submitted')";
        if ($conn->query($sql) === TRUE) {
            echo "Camp details submitted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['delete'])) {
        // Delete the camp based on name, location, and date (basic criteria)
        $sql = "DELETE FROM camp_details WHERE camp_name = '$campName' AND camp_location = '$campLocation' AND camp_date = '$campDate'";
        if ($conn->query($sql) === TRUE) {
            echo "Camp details deleted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

