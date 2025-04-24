<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "anganwadi"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if approve or deny is clicked
if (isset($_GET['approve']) || isset($_GET['deny'])) {
    $id = $_GET['approve'] ?? $_GET['deny']; // Get the ID from the URL

    // Prepare and execute the query to fetch the record from parent_temp table based on the ID
    $query = "SELECT * FROM parent_temp WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id); // Bind the ID parameter as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (isset($_GET['approve'])) {
            // Check if the aadhar_no already exists in the registrations table
            $checkAadharQuery = "SELECT * FROM registrations WHERE aadhar_no = ?";
            $checkStmt = $conn->prepare($checkAadharQuery);
            $checkStmt->bind_param("s", $row['aadhar_no']); // Bind aadhar_no as string
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                // Aadhar already exists in the registrations table
                echo "Error: Aadhar number already exists in the registrations table.";
            } else {
                // Approve: Insert the data into registrations table
                $insertQuery = "INSERT INTO registrations (name, husband_name, address, phone_no, photo, native_place, aadhar_no, pregnancy_status, pregnancy_month, pincode, bank_passbook, child_count, child_details, email, password) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("sssssssssssssss", 
                    $row['name'], $row['husband_name'], $row['address'], $row['phone_no'], $row['photo'], $row['native_place'], 
                    $row['aadhar_no'], $row['pregnancy_status'], $row['pregnancy_month'], $row['pincode'], 
                    $row['bank_passbook'], $row['child_count'], $row['child_details'], $row['email'], $row['password']);
                if ($insertStmt->execute()) {
                    // After inserting into registrations, delete the record from parent_temp
                    $deleteQuery = "DELETE FROM parent_temp WHERE id = ?";
                    $deleteStmt = $conn->prepare($deleteQuery);
                    $deleteStmt->bind_param("i", $id); // Bind the ID parameter as an integer
                    $deleteStmt->execute();
                    echo "Record approved and added to the registrations table.";
                } else {
                    echo "Error inserting record: " . $conn->error;
                }
            }
        } elseif (isset($_GET['deny'])) {
            // Deny: Delete the record from parent_temp
            $deleteQuery = "DELETE FROM parent_temp WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $id); // Bind the ID parameter as an integer
            if ($deleteStmt->execute()) {
                echo "Record denied and removed from the parent_temp table.";
            } else {
                echo "Error denying record: " . $conn->error;
            }
        }
    } else {
        echo "Record not found.";
    }
}

// Display the data in a table format
$query = "SELECT * FROM parent_temp";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Approval</title>
    <style>
    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
            color: #211661;
            font-family: Eras Bold ITC;
        }
        table {
            width: 80%;
            height: 120px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
             background-color: #211661;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            text-decoration: none;
            color: #211661;
            font-weight: bold;
            padding: 4px 8px;
            border: 1px solid #211661;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }
        a:hover {
            background-color: #211661;
            color: white;
        }
        p {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <h2>PARENT APPROVALS</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Aadhar No</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['aadhar_no']; ?></td>
                <td>
                    <a href="?approve=<?php echo $row['id']; ?>">Approve</a> | 
                    <a href="?deny=<?php echo $row['id']; ?>">Deny</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php
// Close the connection
$conn->close();
?>
