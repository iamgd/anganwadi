<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: parentlogin.php');
    exit();
}

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Fetch the user details from the database
$sql = "SELECT * FROM registrations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit();
}

// Handle the profile update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data to update the profile
    $name = $_POST['name'];
    $husband_name = $_POST['husband_name'];
    $address = $_POST['address'];
    $phone_no = $_POST['phone_no'];
    $aadhar_no = $_POST['aadhar_no'];
    $pregnancy_status = $_POST['pregnancy_status'];
    $pregnancy_month = $_POST['pregnancy_month'];
    $child_count = $_POST['child_count'];
    $child_details = $_POST['child_details'];
    $email = $_POST['email'];

    // Update query
    $update_sql = "UPDATE registrations SET name=?, husband_name=?, address=?, phone_no=?, aadhar_no=?, pregnancy_status=?, pregnancy_month=?, child_count=?, child_details=?, email=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('sssssiisiis', $name, $husband_name, $address, $phone_no, $aadhar_no, $pregnancy_status, $pregnancy_month, $child_count, $child_details, $email, $user_id);

    if ($update_stmt->execute()) {
        echo "Profile updated successfully!";
        // Reload the page after update
        header("Refresh:0");
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        /* Reset default margins and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow: hidden;
        }

      
        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #211661;
            color: rgb(241, 240, 245);
            padding: 20px;
            width: 100%;
            margin-top: 20px;
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
        

        .navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #d581a1;
            background-image: url('night.jpg');
            padding: 8px;
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
            font-family: Arial, sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin-top: -40px;
        }

        .container1 {
            width: 80%;
            max-width: 500px;
            padding: 20px;
            background-color: rgb(228, 195, 195);
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            font-family: 'Comic Sans MS';
            overflow-y: auto;
            height: 375px;
            margin-top: 50px;
        }
        .container1 input{
           flex:2;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-family: Eras Bold ITC;
            color:#211661;
            font-size: 24px;
        }

        form p {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            
        }

        form  label {
            font-weight: bold;
            margin-bottom: 5px;
            flex:1;
            display: flex;
        }

        form  input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
            flex:1;
            box-sizing: border-box;
            
        }
       
        form  input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
            flex:1;
            box-sizing: border-box;
        }
        form  select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
            flex:1;
            box-sizing: border-box;
        }
        form  textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
            box-sizing: border-box;
            resize: vertical;
            
        }
       
       
        form  input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
            box-sizing: border-box;
        }
        form  input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
            box-sizing: border-box;
        }
        form  img {
            display: block;
            margin: 10px auto;
            width: 100px;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 30px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        button[type="submit"]:active {
            background-color: #388e3c;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            flex: 1;
            padding-bottom: 70px;
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
        
<div class="navbar">
            
<a href="parentindex.html" target="_self">HOME</a>
            <a href="parentview_updates.php" target="_self">DAILY UPDATE</a>
            <a href="parenttodaymealsnotifi.php" target="_self">TODAY MEALS</a>
            <a href="parentcampnotifi.php" target="_self">CAMP DETAILS</a>          
            <a href="parentfeedback.php" target="_self">FEEDBACK</a>
            <a href="parentschemes.html" target="_self">SCHEMES</a>
            <a href="parentprofile.php" target="_self">PROFILE</a>
            <a href="parentlogout.php" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>


<div class="container1">

        <h2>PROFILE DETAILS</h2>
        <form action="parentprofile.php" method="POST">
        <p>ID: <?php echo $user['id']; ?></p>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"><br><br>

            <label for="husband_name">Husband's Name:</label>
            <input type="text" id="husband_name" name="husband_name" value="<?php echo htmlspecialchars($user['husband_name']); ?>"><br><br>

            <label for="address">Address:</label>
            <textarea id="address" name="address"><?php echo htmlspecialchars($user['address']); ?></textarea><br><br>

            <label for="phone_no">Phone Number:</label>
            <input type="text" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($user['phone_no']); ?>"><br><br>

            <label for="aadhar_no">Aadhar Number:</label>
            <input type="text" id="aadhar_no" name="aadhar_no" value="<?php echo htmlspecialchars($user['aadhar_no']); ?>"><br><br>

            <label for="pregnancy_status">Pregnancy Status:</label>
            <select id="pregnancy_status" name="pregnancy_status">
                <option value="1" <?php echo ($user['pregnancy_status'] == 1) ? 'selected' : ''; ?>>Pregnant</option>
                <option value="0" <?php echo ($user['pregnancy_status'] == 0) ? 'selected' : ''; ?>>Not Pregnant</option>
            </select><br><br>

            <label for="pregnancy_month">Pregnancy Month:</label>
            <input type="number" id="pregnancy_month" name="pregnancy_month" value="<?php echo htmlspecialchars($user['pregnancy_month']); ?>"><br><br>

            <label for="child_count">Number of Children:</label>
            <input type="number" id="child_count" name="child_count" value="<?php echo htmlspecialchars($user['child_count']); ?>"><br><br>

            <label for="child_details">Child Details:</label>
            <textarea id="child_details" name="child_details"><?php echo htmlspecialchars($user['child_details']); ?></textarea><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>

            <button type="submit">Update Profile</button>
        </form>

        <br>
        <div class="profile-photo">
            <h2>Profile Photo:</h2>
            <?php
            if ($user['photo']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($user['photo']) . '" alt="Profile Photo" />';
            } else {
                echo '<p>No photo uploaded.</p>';
            }
            ?>
        </div>
        <div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>


</body>
</html>
