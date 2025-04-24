<?php
// Database connection (update with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $conn->real_escape_string($_POST['delete_id']);
    $sql = "DELETE FROM meals WHERE id = '$delete_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Update deleted successfully!');</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch meal updates
$sql = "SELECT id, update_text, status FROM meals";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Updates Display</title>
    <style>
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Container to hold all sections */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            min-height: 100vh;
            position: relative;
            padding-bottom: 30px; /* Space for footer */
        }

        /* Top header style */
        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #211661;
            color: rgb(241, 240, 245);
            width: 100%;
            padding: 20px;
        }

        .top-header .title {
            font-size: 24px;
            font-weight: bold;
            font-family: 'Copperplate Gothic Bold', sans-serif;
            text-align: center;
            flex: 1;
        }

        .logo {
            width: 65px;
            height: 65px;
        }

        /* Middle header style */
        .middle-header {
            display: flex;
            align-items: center;
            background-color: #e7dfdf;
            width: 100%;
            padding: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .middle-header .left-section {
            display: flex;
            align-items: center;
            padding-left: 20px;
        }

        .middle-header .title {
            font-size: 24px;
            font-weight: bold;
            font-family: 'Copperplate Gothic Light', sans-serif;
            flex: 1;
            text-align: center;
        }

        /* Navbar style */
        .navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #d581a1;
            background-image: url('night.jpg');
            width: 100%;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            white-space: nowrap;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 2px 20px;
            border-radius: 25px;
            transition: background-color 0.3s, color 0.3s;
            font-family: 'Comic Neue', 'Comic Sans MS', cursive, sans-serif;
            font-weight: 700;
        }

        .navbar a:hover {
            background-color: #fad2e0;
            color: #d581a1;
        }


        /* Content Area */
       
        /* Footer styling */
        .footer {
            background-color: #211661;
            color: white;
            text-align: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }
       

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .container1 {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #211661;
            font-family: Eras Bold ITC;
            
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #211661;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .status-posted {
            color: #28a745;
            font-weight: bold;
        }

        .status-saved {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
        <!-- Top Header -->
        <div class="top-header">
            <img src="images/logo2.png" alt="Left Logo" class="logo">
            <div class="title">GOVERNMENT OF PUDUCHERRY</div>
            <img src="images/logo1.jpg" alt="Right Logo" class="logo">
        </div>

         <!-- Middle Header -->
         <div class="middle-header">
            <div class="left-section">
                <img src="images/logo3.jpg" alt="Middle Logo" class="logo">
            </div>
            <div class="title">DEPARTMENT OF WOMAN AND CHILD DEVELOPMENT</div>
        </div>

        <!-- Navbar -->
        <div class="navbar">
            
            <a href="view_updates.php" target="_self">DAILY UPDATE</a>
            <a href="todaymealsnotifi.php" target="_self">TODAY MEALS</a>
            <a href="campnotifi.php" target="_self">CAMP DETAILS</a>
            
            <a href="feedback.php" target="_self">FEEDBACK</a>
            <a href="" target="_self">SCHEMES</a>
        </div>

    
    <div class="container1">
        <h2>MEALS UPDATES</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Update Text</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['update_text']); ?></td>
                            <td>
                                <span class="<?php echo ($row['status'] == 'Posted') ? 'status-posted' : 'status-saved'; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="todaymealsnotifi.php" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No meal updates found.</p>
        <?php endif; ?>
    </div>

    <?php $conn->close(); ?>


    <div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>
</body>
</html>
