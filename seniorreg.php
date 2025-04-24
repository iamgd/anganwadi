<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $guardian = $_POST['guardian'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Calculate age from date of birth
    $birthdate = new DateTime($dob);
    $currentDate = new DateTime();
    $age = $birthdate->diff($currentDate)->y;

    // Check if email already exists
    $check_email_stmt = $conn->prepare("SELECT email FROM senior_temp WHERE email = ?");
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_stmt->store_result();

    if ($check_email_stmt->num_rows > 0) {
        echo "<script>alert('Email already exists in the database.'); window.history.back();</script>";
        $check_email_stmt->close();
        $conn->close();
        exit();
    }
    $check_email_stmt->close();

    // File upload paths and error handling for each file
    $upload_dir = "uploads/";
    $birth_certificate_target = $upload_dir . basename($_FILES["birth_certificate"]["name"]);
    $aadhaar_target = $upload_dir . basename($_FILES["aadhaar"]["name"]);
    $ration_card_target = $upload_dir . basename($_FILES["ration_card"]["name"]);
    $bank_passbook_target = $upload_dir . basename($_FILES["bank_passbook"]["name"]);

    // Upload each file and check for errors
    $upload_errors = [];

    if (!move_uploaded_file($_FILES["birth_certificate"]["tmp_name"], $birth_certificate_target)) {
        $upload_errors[] = "Failed to upload birth certificate.";
    }
    if (!move_uploaded_file($_FILES["aadhaar"]["tmp_name"], $aadhaar_target)) {
        $upload_errors[] = "Failed to upload Aadhaar card.";
    }
    if (!move_uploaded_file($_FILES["ration_card"]["tmp_name"], $ration_card_target)) {
        $upload_errors[] = "Failed to upload ration card.";
    }
    if (!move_uploaded_file($_FILES["bank_passbook"]["tmp_name"], $bank_passbook_target)) {
        $upload_errors[] = "Failed to upload bank passbook.";
    }

    // Check for any upload errors
    if (!empty($upload_errors)) {
        echo "<script>alert('" . implode("\\n", $upload_errors) . "'); window.history.back();</script>";
        exit();
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO senior_temp (name, email, password, guardian, address, phone, dob, birth_certificate, aadhaar, ration_card, bank_passbook) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $name, $email, $hashed_password, $guardian, $address, $phone, $dob, $birth_certificate_target, $aadhaar_target, $ration_card_target, $bank_passbook_target);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href = 'seniorlogin.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENIOR CITIZEN REGISTRATION</title>
    <style>

* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensure body takes at least full viewport height */
        }

        h2 {
            color: #211661;
            font-family: 'Eras Bold ITC';
            margin: 20px 0;
            text-align: center;
        }

        /* Container to hold all sections */
        .container {
            flex: 1; /* Allow the container to grow and take available space */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start; /* Align content to the top */
            padding-bottom: 20px; /* Space for footer */
            overflow: hidden; /* Prevent page scrolling */
        }

        /* Top Header */
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
            flex: 1;
            text-align: center;
        }

        .logo {
            width: 65px;
            height: 65px;
        }

        /* Middle Header */
        .middle-header {
            display: flex;
            align-items: center;
            background-color: #e7dfdf;
            width: 100%;
            padding: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .middle-header .title {
            font-size: 24px;
            font-weight: bold;
            font-family: 'Copperplate Gothic Light', sans-serif;
            flex: 1;
            text-align: center;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #d581a1;
            width: 100%;
            padding: 9px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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


        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            
        }
        h2 {
            text-align: center;
            color: #211661;
            font-family: Eras Bold ITC;
            margin-top: 40px;
   }
        form {
            background-color: #211661;
            width: 400px; /* Adjusted to match login form */
            margin: 20px auto;
            padding: 20px;
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: white; /* Change text color to white for visibility */
            overflow-y: auto; /* Enable vertical scrolling */
            max-height: 300px; /* Set maximum height for scrolling */
            margin-top: 20px;
            font-family: 'Comic Sans MS';
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color:white;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="file"],
        input[type="tel"],
        input[type="number"] {
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
            color: white;
            background-color: #5573b4;
            border: none;
            padding: 10px 15px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #7996cd;

        }

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
    <script>
        // Function to validate password and confirm password
        function validateForm() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const dob = new Date(document.getElementById("dob").value);
            const today = new Date();
            const age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            // Display the calculated age
            document.getElementById("age").value = age;

            if (age < 55) {
                alert("Age must be more than 55. You are unauthorized to register.");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }
    </script>
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

   

<h2>SENIOR REGISTRATION</h2>
<form method="post" action="seniorreg.php" enctype="multipart/form-data" onsubmit="return validateForm();">
    <div class="form-group">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>

    <div class="form-group">
        <label for="guardian">Husband/Guardian Name:</label>
        <input type="text" id="guardian" name="guardian" required>
    </div>

    <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>
    </div>

    <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required onchange="validateForm();">
    </div>

    <div class="form-group">
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" readonly>
    </div>

    <h3>Document Uploads</h3>

    <div class="form-group">
        <label for="birth_certificate">Birth Certificate:</label>
        <input type="file" id="birth_certificate" name="birth_certificate" accept="image/*" required>
    </div>

    <div class="form-group">
        <label for="aadhaar">Aadhaar Card:</label>
        <input type="file" id="aadhaar" name="aadhaar" accept="image/*" required>
    </div>

    <div class="form-group">
        <label for="ration_card">Ration Card:</label>
        <input type="file" id="ration_card" name="ration_card" accept="image/*" required>
    </div>

    <div class="form-group">
        <label for="bank_passbook">Bank Passbook:</label>
        <input type="file" id="bank_passbook" name="bank_passbook" accept="image/*" required>
    </div>

    <div class="form-group">
        <input type="submit" name="submit" value="Register">
    </div>
</form>

<div class="footer">
&copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>


</body>
</html>
