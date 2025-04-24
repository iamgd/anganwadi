<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view this page.");
}

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

// Fetch profile details using the session's user ID
$userId = $_SESSION['user_id']; // Get the logged-in user ID from session
$sql = "SELECT id, name, una_no, aadhar_no, phone, designation, department, dob, anganwadi_address, pincode, photo, email FROM staff WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update profile details
    $name = $_POST['name'];
    $una_no = $_POST['una_no'];
    $aadhar_no = $_POST['aadhar_no'];
    $phone = $_POST['phone'];
    $designation = $_POST['designation'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];
    $anganwadi_address = $_POST['anganwadi_address'];
    $pincode = $_POST['pincode'];
    $email = $_POST['email'];

    // Handle photo upload
    $photo = $user['photo']; // Keep current photo unless a new one is uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Check file type and size (optional)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // Max file size 5MB

        if (in_array($_FILES['photo']['type'], $allowedTypes) && $_FILES['photo']['size'] <= $maxSize) {
            $uploadDir = 'uploads/';
            $photo = time() . '_' . basename($_FILES['photo']['name']); // New unique file name
            $uploadFile = $uploadDir . $photo;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                // File uploaded successfully
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type or file too large.";
        }
    }

    // Prepare and bind the update statement
    $updateSql = "UPDATE staff SET name = ?, una_no = ?, aadhar_no = ?, phone = ?, designation = ?, department = ?, dob = ?, anganwadi_address = ?, pincode = ?, email = ?, photo = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sssssssssssi", $name, $una_no, $aadhar_no, $phone, $designation, $department, $dob, $anganwadi_address, $pincode, $email, $photo, $userId);

    if ($updateStmt->execute()) {
        echo "Profile updated successfully!";
        header("Location: staffprofile.php");
        exit;
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        /* Reset default margins and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

      
        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #211661;
            color: rgb(241, 240, 245);
            padding: 20px;
            width: 100%;
            margin-top: -50px;
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

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .container1 {
            width: 80%;
            max-width: 500px;
            padding: 20px;
            background-color: rgb(228, 195, 195);
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            height: 405px;
            overflow-y: auto;
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
            font-family: Comic Sans MS;
        }

        form p label {
            font-weight: bold;
            margin-bottom: 5px;
           
        }

        form p input[type="text"],
        form p input[type="email"],
        form p input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
        }

        form p img {
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

       
    




<div class="container1">
    <h2>PROFILE DETAILS</h2>
    <form action="staffprofile.php" method="post" enctype="multipart/form-data">
        <p>ID: <?php echo $user['id']; ?></p>
        <p>Name: <input type="text" name="name" value="<?php echo $user['name']; ?>"></p>
        <p>UNA No: <input type="text" name="una_no" value="<?php echo $user['una_no']; ?>"></p>
        <p>Aadhar No: <input type="text" name="aadhar_no" value="<?php echo $user['aadhar_no']; ?>"></p>
        <p>Phone: <input type="text" name="phone" value="<?php echo $user['phone']; ?>"></p>
        <p>Designation: <input type="text" name="designation" value="<?php echo $user['designation']; ?>"></p>
        <p>Department: <input type="text" name="department" value="<?php echo $user['department']; ?>"></p>
        <p>Date of Birth: <input type="date" name="dob" value="<?php echo $user['dob']; ?>"></p>
        <p>Anganwadi Address: <input type="text" name="anganwadi_address" value="<?php echo $user['anganwadi_address']; ?>"></p>
        <p>Pincode: <input type="text" name="pincode" value="<?php echo $user['pincode']; ?>"></p>
        <p>Photo: <img src="uploads/<?php echo $user['photo']; ?>" alt="Photo"></p>
        <p>Email: <input type="email" name="email" value="<?php echo $user['email']; ?>"></p>
        <p>Upload New Photo: <input type="file" name="photo"></p>
        <button type="submit">Update Profile</button>
    </form>
</div>
<div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>

</body>
</html>
