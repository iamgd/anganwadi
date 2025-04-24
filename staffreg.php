<?php
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

// Function to clean input data
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Initialize error and success messages
$error = "";
$success = "";

// Ensure the uploads directory exists
$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']); // Add email field
    $una_no = clean_input($_POST['una_no']);
    $aadhar_no = clean_input($_POST['aadhar_no']);
    $phone = clean_input($_POST['phone']);
    $otp = clean_input($_POST['otp']);
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    $confirm_password = clean_input($_POST['confirm_password']);
    $designation = clean_input($_POST['designation']);
    $department = clean_input($_POST['department']);
    $dob = clean_input($_POST['dob']);
    $anganwadi_address = clean_input($_POST['anganwadi_address']);
    $pincode = clean_input($_POST['pincode']);
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    }
    
    // Validate passwords
    if ($password != $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Handle file upload
        $photo = $_FILES['photo'];
        $photo_name = $photo['name'];
        $photo_tmp = $photo['tmp_name'];
        $photo_size = $photo['size'];
        $photo_error = $photo['error'];
        $photo_ext = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($photo_ext, $allowed_ext) && $photo_error === 0 && $photo_size < 5000000) {
            $photo_new_name = uniqid('', true) . '.' . $photo_ext;
            $photo_destination = $upload_dir . $photo_new_name;
            
            // Move the uploaded file to the destination
            if (move_uploaded_file($photo_tmp, $photo_destination)) {
                // SQL query to insert data into the database
                $sql = "INSERT INTO staff_temp (name, email, una_no, aadhar_no, phone, otp, username, password, designation, department, dob, anganwadi_address, pincode, photo) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssssssss", $name, $email, $una_no, $aadhar_no, $phone, $otp, $username, $hashed_password, $designation, $department, $dob, $anganwadi_address, $pincode, $photo_new_name);

                if ($stmt->execute()) {
                    // Trigger success message in JavaScript
                    echo "<script>alert('Registration successful!');</script>";
                    $success = "Registration successful!";
                } else {
                    $error = "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $error = "Failed to move the uploaded file!";
            }
        } else {
            $error = "Invalid file upload!";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STAFF REGISTRATION</title>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow: hidden;
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
            overflow: hidden;
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
            overflow: hidden;
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
            overflow: hidden;
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

        h2{
            margin-top: 30px;
        }

        /* Form styling */
        form {
            background-color: #211661;
            max-width: 400px; /* Adjusted to match login form */
            margin: 30px auto;
            padding: 20px;
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: white; /* Change text color to white for visibility */
            overflow-y: auto; /* Enable vertical scrolling */
            max-height: 310px; /* Set maximum height for scrolling */
        }

        label {
            font-weight: bold;
            color: white;
            display: block;
            margin-bottom: 6px;
            margin-top: 12px;
            font-family: Comic Sans MS;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"],
        input[type="tel"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 30px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #5573b4; /* Color changed to match login form */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #7996cd; /* Color changed to match login form */
        }

        p.error {
            color: red;
            text-align: center;
        }

        p.success {
            color: green;
            text-align: center;
        }

         /* Footer styling */
         .footer {
            background-color: #211661;
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
            font-family: Arial, sans-serif;
            position: fixed;
            bottom: 0;
            left: 0;
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
            <a href="index.html">HOME</a>
            <a href="stafflogin.php">STAFF</a>
            <a href="parentlogin.php">PARENT</a>
            <a href="widowlogin.php">WIDOW</a>
            <a href="seniorlogin.php">SENIOR CITIZEN</a>
            <a href="fhwlogin.php">FHW</a>
        </div>

        <!-- Display error messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <h2>STAFF REGISTRATION</h2>
        <!-- Registration Form -->
        <form action="" method="POST" enctype="multipart/form-data">
        
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label> <!-- Added email field -->
            <input type="email" id="email" name="email" required>

            <label for="una_no">UNA No:</label>
            <input type="text" id="una_no" name="una_no" required>

            <label for="aadhar_no">Aadhar No:</label>
            <input type="text" id="aadhar_no" name="aadhar_no" required>

            <label for="phone">Phone No:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="otp">OTP:</label>
            <input type="text" id="otp" name="otp" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <label for="designation">Designation:</label>
            <input type="text" id="designation" name="designation" required>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="anganwadi_address">Anganwadi Address:</label>
            <input type="text" id="anganwadi_address" name="anganwadi_address" required>

            <label for="pincode">Pincode:</label>
            <input type="text" id="pincode" name="pincode" required>

            <label for="photo">Upload Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required><br><br>

            <input type="submit" value="Register">
        </form>


        <!-- Footer -->
        <div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>
</body>
</html>