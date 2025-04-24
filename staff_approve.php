<?php
// db_connection.php

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

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request is for approve or deny action
if (isset($_GET['approve']) || isset($_GET['deny'])) {
    $id = $_GET['approve'] ?? $_GET['deny']; // Get the id from the URL

    // Fetch the data from staff_temp table based on the id
    $query = "SELECT * FROM staff_temp WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the row to insert into the staff table
        $row = mysqli_fetch_assoc($result);

        if (isset($_GET['approve'])) {
            // Approve: Insert into staff table
            // Check if the record already exists in the staff table
            $checkQuery = "SELECT * FROM staff WHERE una_no = '" . $row['una_no'] . "' AND phone = '" . $row['phone'] . "' AND username = '" . $row['username'] . "' AND aadhar_no = '" . $row['aadhar_no'] . "'";
            $checkResult = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                echo "This record already exists in the staff table.";
            } else {
                // Insert the data into the staff table
                $insertQuery = "INSERT INTO staff (name, una_no, aadhar_no, phone, otp, username, password, designation, department, dob, anganwadi_address, pincode, photo, email) 
                                VALUES ('" . $row['name'] . "', '" . $row['una_no'] . "', '" . $row['aadhar_no'] . "', '" . $row['phone'] . "', '" . $row['otp'] . "', '" . $row['username'] . "', '" . $row['password'] . "', '" . $row['designation'] . "', '" . $row['department'] . "', '" . $row['dob'] . "', '" . $row['anganwadi_address'] . "', '" . $row['pincode'] . "', '" . $row['photo'] . "', '" . $row['email'] . "')";
                
                if (mysqli_query($conn, $insertQuery)) {
                    echo "Record approved and added to the staff table.";
                    
                    // After inserting, delete from staff_temp
                    $deleteQuery = "DELETE FROM staff_temp WHERE id = '$id'";
                    mysqli_query($conn, $deleteQuery);
                } else {
                    echo "Error inserting record: " . mysqli_error($conn);
                }
            }
        } elseif (isset($_GET['deny'])) {
            // Deny: Delete from staff_temp table
            $deleteQuery = "DELETE FROM staff_temp WHERE id = '$id'";
            if (mysqli_query($conn, $deleteQuery)) {
                echo "Record denied and removed from the staff_temp table.";
            } else {
                echo "Error denying record: " . mysqli_error($conn);
            }
        }
    } else {
        echo "No record found.";
    }
}

// Close the database connection after all operations
// mysqli_close($conn); <-- Moved to the end after all operations
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Approval</title>
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
    <h2>STAFF APPROVAL</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>

        <?php
        // Fetch all records from staff_temp table
        $query = "SELECT * FROM staff_temp";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>
                        <a href='?approve=" . $row['id'] . "'>Approve</a> | 
                        <a href='?deny=" . $row['id'] . "'>Deny</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found.</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php
// Close the database connection after all operations
mysqli_close($conn);
?>
