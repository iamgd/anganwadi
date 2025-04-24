<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Head Woman Approval</title>
    <style>
        /* Basic reset and body styling */
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
<h2>FHW APPROVAL</h2>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("<div class='message'>Connection failed: " . mysqli_connect_error() . "</div>");
}

// Handle 'Approve' action
if (isset($_POST['approve'])) {
    $id = $_POST['approve'];

    // Fetch the data to be approved
    $query = "SELECT * FROM fhw_temp WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Insert the data into family_head_woman_dashboard
        $insert_query = "INSERT INTO family_head_woman_dashboard (name, occupation, husband_name, email, password, address, native_place, phone, ration_card_color, birth_certificate, family_photo, bank_passbook, annual_income_certificate)
                         VALUES ('" . $row['name'] . "', '" . $row['occupation'] . "', '" . $row['husband_name'] . "', '" . $row['email'] . "', '" . $row['password'] . "', '" . $row['address'] . "', '" . $row['native_place'] . "', '" . $row['phone'] . "', '" . $row['ration_card_color'] . "', '" . $row['birth_certificate'] . "', '" . $row['family_photo'] . "', '" . $row['bank_passbook'] . "', '" . $row['annual_income_certificate'] . "')";
        
        if (mysqli_query($conn, $insert_query)) {
            // After inserting, delete from fhw_temp
            $delete_query = "DELETE FROM fhw_temp WHERE id = '$id'";
            if (mysqli_query($conn, $delete_query)) {
                echo "<div class='message' style='color: green;'>Record approved and moved to family_head_woman_dashboard.</div>";
            } else {
                echo "<div class='message' style='color: red;'>Error deleting record from fhw_temp.</div>";
            }
        } else {
            echo "<div class='message' style='color: red;'>Error approving record.</div>";
        }
    } else {
        echo "<div class='message'>Record not found in fhw_temp.</div>";
    }
}

// Handle 'Deny' action
if (isset($_POST['deny'])) {
    $id = $_POST['deny'];

    // Delete the record from fhw_temp
    $delete_query = "DELETE FROM fhw_temp WHERE id = '$id'";
    
    if (mysqli_query($conn, $delete_query)) {
        echo "<div class='message' style='color: red;'>Record denied and deleted from fhw_temp.</div>";
    } else {
        echo "<div class='message' style='color: red;'>Error deleting record from fhw_temp.</div>";
    }
}

// Fetch all records from fhw_temp
$query = "SELECT * FROM fhw_temp";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {

    echo "<table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td>
                    <form method='post' style='display:inline;'>
                        <button type='submit' name='approve' value='" . $row['id'] . "'>Approve</button>
                        <button type='submit' name='deny' value='" . $row['id'] . "'>Deny</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<div class='message'>No data found in fhw_temp.</div>";
}

mysqli_close($conn);
?>

</body>
</html>
