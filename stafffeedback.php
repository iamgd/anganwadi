<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Feedback</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: rgb(81, 2, 15);
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #211661;
            color: rgb(241, 240, 245);
            padding: 20px;
            width: 100%;
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

        /* Navbar Style */
        .navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #d581a1;
            background-image: url('night.jpg');
            padding: 9px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

        .footer {
            background-color: #211661;
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            flex: 1;
            padding-bottom: 70px;
        }

        .hai {
            width: 100%;
            background-position: center;
            background-size: cover;
            height: 109vh;
            color: #211661;
            font-family: Eras Bold ITC;
           
                   }
        .header {
            margin-top: 70px;
            margin-left: 650px;
        }
        .content-table {
            border-collapse: collapse;
            font-size: 0.9em;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            margin-left: 350px;
            margin-top: 25px;
           
            width: 800px;
            height: auto; /* Adjust height to fit content */
            
            
        }
        .content-table thead tr {
            background-color:  #211661;;
            color: white;
            text-align: left;
        }
        .content-table th,
        .content-table td {
            padding: 12px 15px;
        }
        .content-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }
        .content-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        .content-table tbody tr:last-of-type {
            border-bottom: 2px solid darkblue;
        }
        .delete-btn {
            color:   #211661;;
            cursor: pointer;
            font-size: 16px;
            padding: 0 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";   // Hostname
$username = "root";          // Database username
$password = "";              // Database password
$dbname = "anganwadi";       // Name of the database

// Create a connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Delete feedback logic
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $delete_query = "DELETE FROM feedback WHERE FED_ID='$delete_id'";
    mysqli_query($con, $delete_query);
}

// Fetch feedback data
$query = "SELECT * FROM feedback";
$queryy = mysqli_query($con, $query);
?>


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
            <a href="staffindex.html" target="_self">HOME</a>
            <a href="dailynotificationstaff.html" target="_self">DAILY NOTE</a>
            <a href="attendance.html" target="_self">ATTENDANCE</a>
            <a href="todaymeals.html" target="_self">TODAY MEALS</a>
            <a href="inventory.html" target="_self">MEAL INVENTORY</a>
           
            <a href="camp_details.html" target="_self">CAMP DETAILS</a>
           
            <a href="stafffeedback.php" target="_self">FEEDBACK</a>
            <a href="staffprofile.php" target="_self">PROFILE</a>
            <a href="stafflogout.php" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>

       
    

<div class="hai">
    <div>
        <h1 class="header">FEEDBACKS</h1>
        <div>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>EMAIL</th>
                        <th>COMMENT</th>
                        <th>ACTION</th> <!-- New column for actions -->
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($res = mysqli_fetch_array($queryy)) {
                ?>
                <tr class="active-row">
                    <td><?php echo $res['EMAIL']; ?></td>
                    <td><?php echo $res['COMMENT']; ?></td>
                    <td>
                        <a href="?delete_id=<?php echo $res['FED_ID']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this feedback?');">&times;</a>
                    </td> <!-- X button for delete -->
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

        <div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
</div>


</body>
</html>
