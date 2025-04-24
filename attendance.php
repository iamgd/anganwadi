<?php
// Database connection (update with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle saving attendance (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $status = $conn->real_escape_string($_POST['status']);
    $date = date('Y-m-d');  // Get the current date

    // Insert attendance record into the database
    $sql = "INSERT INTO attendance_records (name, date, status) VALUES ('$name', '$date', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Attendance recorded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle fetching attendance records (GET request)
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch attendance records from the database
    $sql = "SELECT * FROM attendance_records ORDER BY date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No attendance records found</td></tr>";
    }
}

$conn->close();
?>




