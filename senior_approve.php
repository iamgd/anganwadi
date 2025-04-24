<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Approval Dashboard</title>
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
    <h2>SENIOR APPROVAL</h2>

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
        die("Connection failed: " . mysqli_connect_error());
    }

    // Handle the 'Approve' action
    if (isset($_POST['approve'])) {
        $id = $_POST['approve'];
        $query = "SELECT * FROM senior_temp WHERE id = '$id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Check if email already exists in above_60_dashboard
            $email_check_query = "SELECT * FROM above_60_dashboard WHERE email = '" . $row['email'] . "'";
            $email_check_result = mysqli_query($conn, $email_check_query);

            if (mysqli_num_rows($email_check_result) > 0) {
                $update_query = "UPDATE above_60_dashboard SET 
                                name = '" . $row['name'] . "', 
                                phone = '" . $row['phone'] . "', 
                                guardian = '" . $row['guardian'] . "', 
                                address = '" . $row['address'] . "', 
                                dob = '" . $row['dob'] . "', 
                                birth_certificate = '" . $row['birth_certificate'] . "', 
                                aadhaar = '" . $row['aadhaar'] . "', 
                                ration_card = '" . $row['ration_card'] . "', 
                                bank_passbook = '" . $row['bank_passbook'] . "' 
                                WHERE email = '" . $row['email'] . "'";

                if (mysqli_query($conn, $update_query)) {
                    $delete_query = "DELETE FROM senior_temp WHERE id = '$id'";
                    mysqli_query($conn, $delete_query);
                    echo "<p>Record updated and moved to above_60_dashboard.</p>";
                } else {
                    echo "<p>Error updating record.</p>";
                }
            } else {
                $insert_query = "INSERT INTO above_60_dashboard (name, email, phone, guardian, address, dob, birth_certificate, aadhaar, ration_card, bank_passbook)
                                VALUES ('" . $row['name'] . "', '" . $row['email'] . "', '" . $row['phone'] . "', '" . $row['guardian'] . "', '" . $row['address'] . "', '" . $row['dob'] . "', '" . $row['birth_certificate'] . "', '" . $row['aadhaar'] . "', '" . $row['ration_card'] . "', '" . $row['bank_passbook'] . "')";

                if (mysqli_query($conn, $insert_query)) {
                    $delete_query = "DELETE FROM senior_temp WHERE id = '$id'";
                    mysqli_query($conn, $delete_query);
                    echo "<p>Record approved and moved to above_60_dashboard.</p>";
                } else {
                    echo "<p>Error approving record.</p>";
                }
            }
        } else {
            echo "<p>No record found for approval with the specified ID.</p>";
        }
    }

    // Handle the 'Deny' action
    if (isset($_POST['deny'])) {
        $id = $_POST['deny'];
        $delete_query = "DELETE FROM senior_temp WHERE id = '$id'";
        if (mysqli_query($conn, $delete_query)) {
            echo "<p>Record denied and deleted from senior_temp.</p>";
        } else {
            echo "<p>Error denying record.</p>";
        }
    }

    // Fetch records from senior_temp table
    $query = "SELECT * FROM senior_temp";
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
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['phone']) . "</td>
                    <td>
                        <form method='post'>
                            <button type='submit' name='approve' value='" . htmlspecialchars($row['id']) . "'>Approve</button>
                            <button type='submit' name='deny' value='" . htmlspecialchars($row['id']) . "'>Deny</button>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No data found.</p>";
    }

    mysqli_close($conn);
    ?>
</body>
</html>
