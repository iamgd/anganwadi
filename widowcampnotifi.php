<?php
// Start session
session_start();

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

// Delete functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $sql = "DELETE FROM camp_details WHERE id = $deleteId";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Record deleted successfully!";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
    }
    // Redirect to clear POST data and show message
    header("Location: campnotifi.php");
    exit();
}

// Fetch camp details from the database
$sql = "SELECT * FROM camp_details";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widow Camp Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        /* Styles */

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
            padding: 9px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            white-space: nowrap;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 2px 20px;
            border-radius: 25px;
            transition: background-color 0.3s, color 0.3s;
            font-family: 'Comic Neue', 'Comic Sans MS', cursive, sans-serif;
            font-weight: 400;
        }

        .navbar a:hover {
            background-color: #fad2e0;
            color: #d581a1;
        }


        /* Content Area */
        .content {
            flex-grow: 1; /* This makes the content area expand to fill the space */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center the content */
            padding: 20px;
            color: black;
          
        }

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
        }
        .container1 {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: rgb(228, 195, 195); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 35px;
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            color:#211661;
            font-family: Eras Bold ITC;
            
        }
        .message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #211661;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 30px;
            cursor: pointer;
        }
        .delete-btn:hover {
            opacity: 0.8;
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
            <a href="widowindex.html" target="_self">HOME</a>
            <a href="widowview_updates.php" target="_self">DAILY UPDATE</a>
            <a href="widowtodaymealsnotifi.php" target="_self">TODAY MEALS</a>
            <a href="widowcampnotifi.php" target="_self">CAMP DETAILS</a>
            <a href="widowfeedback.php" target="_self">FEEDBACK</a>
            <a href="widowdisplay_schemes.php" target="_self">SCHEMES</a>
            <a href="widowprofile.php" target="_self">PROFILE</a>
            <a href="widowlogout.php" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
      



<div class="container1">
    <h2>CAMP DETAILS</h2>
    
    <!-- Display message if set -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <table>
        <tr>
            <th>CAMP NAME</th>
            <th>LOCATION</th>
            <th>DATE</th>
            <th>STATUS</th>
            <th>ACTION</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['camp_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['camp_location']); ?></td>
                    <td><?php echo htmlspecialchars($row['camp_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No camp details found.</td></tr>
        <?php endif; ?>
    </table>
</div>
<div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>


</body>
</html>

<?php
$conn->close();

?>
