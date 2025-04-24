<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "anganwadi"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if approve or deny is clicked
if (isset($_GET['approve']) || isset($_GET['deny'])) {
    $id = $_GET['approve'] ?? $_GET['deny']; // Get the ID from the URL

    // Fetch the record from widow_temp table based on the ID
    $query = "SELECT * FROM widow_temp WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (isset($_GET['approve'])) {
            // Approve: Insert the data into widow_details table
            $insertQuery = "INSERT INTO widow_details (name, address, phone, guardian, child_name, dob, age, death_certificate, bank_passbook, aadhaar, ration_card, voter_id, reg_date, email, password) 
                            VALUES ('" . $row['name'] . "', '" . $row['address'] . "', '" . $row['phone'] . "', '" . $row['guardian'] . "', '" . $row['child_name'] . "', '" . $row['dob'] . "', '" . $row['age'] . "', '" . $row['death_certificate'] . "', '" . $row['bank_passbook'] . "', '" . $row['aadhaar'] . "', '" . $row['ration_card'] . "', '" . $row['voter_id'] . "', '" . $row['reg_date'] . "', '" . $row['email'] . "', '" . $row['password'] . "')";

            if (mysqli_query($conn, $insertQuery)) {
                // After inserting into widow_details, delete the record from widow_temp
                $deleteQuery = "DELETE FROM widow_temp WHERE id = '$id'";
                mysqli_query($conn, $deleteQuery);
                echo "<p class='success-message'>Record approved and added to the widow_details table.</p>";
            } else {
                echo "<p class='error-message'>Error inserting record: " . mysqli_error($conn) . "</p>";
            }
        } elseif (isset($_GET['deny'])) {
            // Deny: Delete the record from widow_temp
            $deleteQuery = "DELETE FROM widow_temp WHERE id = '$id'";
            if (mysqli_query($conn, $deleteQuery)) {
                echo "<p class='success-message'>Record denied and removed from the widow_temp table.</p>";
            } else {
                echo "<p class='error-message'>Error denying record: " . mysqli_error($conn) . "</p>";
            }
        }
    } else {
        echo "<p class='error-message'>Record not found.</p>";
    }
}

// Display the data in a table format
$query = "SELECT * FROM widow_temp";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widow Approval</title>
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
            height: 200px;
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
    <h2>WIDOW APPROVAL</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Guardian</th>
            <th>Child Name</th>
            <th>DOB</th>
            <th>Action</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['address'] . "</td>
                        <td>" . $row['phone'] . "</td>
                        <td>" . $row['guardian'] . "</td>
                        <td>" . $row['child_name'] . "</td>
                        <td>" . $row['dob'] . "</td>
                        <td>
                            <a href='?approve=" . $row['id'] . "'>Approve</a> | 
                            <a href='?deny=" . $row['id'] . "'>Deny</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No records found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
mysqli_close($conn);
?>
