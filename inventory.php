<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi"; // Update to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request for saving stock records
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $conn->real_escape_string($_POST['item_name']);
    $total_stock = (int)$_POST['total_stock'];
    $used_stock = (int)$_POST['used_stock'];
    $remaining_stock = $total_stock - $used_stock; // Calculate remaining stock
    $month = $conn->real_escape_string($_POST['month']);

    $sql = "INSERT INTO stock_records (item_name, total_stock, used_stock, remaining_stock, month) 
            VALUES ('$item_name', '$total_stock', '$used_stock', '$remaining_stock', '$month')";

    if ($conn->query($sql) === TRUE) {
        echo "Stock saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    exit; // Exit after saving to avoid returning HTML
}

// Handle DELETE request for deleting stock records
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = (int)$input['id'];

    $sql = "DELETE FROM stock_records WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully!";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    exit; // Exit after processing DELETE
}

// Handle GET request for fetching stock records
$sql = "SELECT * FROM stock_records ORDER BY id DESC"; // Adjust the order by as needed
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['item_name'] . "</td>";
        echo "<td>" . $row['total_stock'] . "</td>";
        echo "<td>" . $row['used_stock'] . "</td>";
        echo "<td>" . $row['remaining_stock'] . "</td>";
        echo "<td>" . $row['month'] . "</td>";
        echo "<td><button class='btn btn-danger' onclick='deleteStock(" . $row['id'] . ")'>Delete</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}

$conn->close();
?>
