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

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']); // Sanitize input

    // Delete the selected update
    $delete_sql = "DELETE FROM daily_updates_db WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Update deleted successfully!'); window.location.href = 'view_updates.php';</script>";
    } else {
        echo "<script>alert('Error deleting update.');</script>";
    }
    $stmt->close();
}

// Fetch only 'Posted' updates
$sql = "SELECT id, update_text, created_at FROM daily_updates_db WHERE status = 'Posted' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widow Daily Updates</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
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
        }
        .container1 {
            margin: 50px auto;
            padding: 20px;
            max-width: 800px;
            background-color: rgb(228, 195, 195);
            border-radius: 35px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color:#211661;
            font-family: Eras Bold ITC;
            
        }
        .update {
            padding: 15px;
            margin-bottom: 10px;
            background-color: #e9ecef;
            border-radius: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .update p {
            margin: 0;
            flex: 1;
        }
        .timestamp {
            font-size: 0.8em;
            color: #6c757d;
            margin-right: 10px;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 30px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #c82333;
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
    <h2>POSTED DAILY UPDATES</h2>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='update'>";
            echo "<p>" . htmlspecialchars($row['update_text']) . "</p>";
            echo "<div class='timestamp'>Posted on: " . $row['created_at'] . "</div>";
            echo "<form method='POST' style='margin-left: 10px;'>";
            echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
            echo "<button type='submit' class='delete-button'>Delete</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No updates found.</p>";
    }
    $conn->close();
    ?>
</div>

<div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>


</body>
</html>
