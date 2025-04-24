<?php
session_start();
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
    $occupation = $_POST['occupation'];
    $husband_name = $_POST['husband_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $address = $_POST['address'];
    $native_place = $_POST['native_place'];
    $phone = $_POST['phone'];
    $ration_card_color = $_POST['ration_card_color'];

    // File uploads
    $allowed_extensions = array("jpg", "jpeg", "png", "pdf");
    $upload_errors = [];

    // Function to handle file uploads
    function uploadFile($file, $target_dir, &$upload_errors, $allowed_extensions) {
        // Ensure the file exists before processing
        if (!isset($file['name']) || $file['error'] != UPLOAD_ERR_OK) {
            return null;  // Return null if no file is uploaded or there's an error
        }

        $target_file = $target_dir . basename($file['name']);
        $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $upload_errors[] = "File type not allowed for " . basename($file['name']);
            return false;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $upload_errors[] = "Error uploading " . basename($file['name']);
            return false;
        }

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            return $target_file;
        } else {
            $upload_errors[] = "Failed to move " . basename($file['name']) . " to the target directory.";
            return false;
        }
    }

    // Target directory for file uploads
    $target_dir = "uploads/";

    // Upload files with validation to handle undefined array keys
    $birth_certificate_target = uploadFile($_FILES['birth_certificate'] ?? null, $target_dir, $upload_errors, $allowed_extensions);
    $family_photo_target = uploadFile($_FILES['family_photo'] ?? null, $target_dir, $upload_errors, $allowed_extensions);
    $bank_passbook_target = uploadFile($_FILES['bank_passbook'] ?? null, $target_dir, $upload_errors, $allowed_extensions);

    // Handle the annual_income_certificate upload with a fallback
    $annual_income_certificate_target = isset($_FILES['annual_income_certificate']) && $_FILES['annual_income_certificate']['error'] == UPLOAD_ERR_OK
        ? uploadFile($_FILES['annual_income_certificate'], $target_dir, $upload_errors, $allowed_extensions)
        : 'no_file'; // Default value if no file is uploaded

    // Check for upload errors
    if (!empty($upload_errors)) {
        echo "<script>alert('Errors occurred while uploading files: " . implode(", ", $upload_errors) . "');</script>";
    } else {
        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO fhw_temp (name, occupation, husband_name, email, password, address, native_place, phone, ration_card_color, birth_certificate, family_photo, bank_passbook, annual_income_certificate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Correctly bind the parameters, including a fallback for annual_income_certificate
        $stmt->bind_param("sssssssssssss", $name, $occupation, $husband_name, $email, $password, $address, $native_place, $phone, $ration_card_color, $birth_certificate_target, $family_photo_target, $bank_passbook_target, $annual_income_certificate_target);
        
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href = 'success.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FHW REGISTRATION</title>
    <style>
          
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #211661;
            font-family: Eras Bold ITC;
            margin: 20px 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow: hidden; /* Prevent page scrolling */
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            min-height: 100vh;
            overflow: hidden; /* Prevent page scrolling */
        }

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

        .navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #d581a1;
            width: 100%;
            padding: 9px;
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

        h2{
            margin-top: 30px;
        }

        form {
            background-color: #211661;
            width: 400px; /* Adjusted to match login form */
            margin: 10px auto;
            padding: 20px;
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: white; /* Change text color to white for visibility */
            overflow-y: auto; /* Enable vertical scrolling */
            max-height: 330px; /* Set maximum height for scrolling */
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: white;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"],
        input[type="tel"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
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
        // Function to validate form inputs
        function validateForm() {
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
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

        <h2>FAMILY HEAD WOMEN REGISTRATION</h2>
        <form method="post" action="" enctype="multipart/form-data" onsubmit="return validateForm();">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="occupation">Occupation:</label>
                <input type="text" id="occupation" name="occupation" required>
            </div>

            <div class="form-group">
                <label for="husband_name">Husband's Name:</label>
                <input type="text" id="husband_name" name="husband_name" required>
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
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="native_place">Native Place:</label>
                <input type="text" id="native_place" name="native_place" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="ration_card_color">Ration Card Color:</label>
                <select id="ration_card_color" name="ration_card_color" required>
                    <option value="red">Red</option>
                    <option value="yellow">Yellow</option>
                </select>
            </div>

            <div class="form-group">
                <label for="birth_certificate">Upload Birth Certificate:</label>
                <input type="file" id="birth_certificate" name="birth_certificate" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>

            <div class="form-group">
                <label for="aadhar_card">Upload Aadhar Card:</label>
                <input type="file" id="aadhar_card" name="aadhar_card" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>

            <div class="form-group">
                <label for="ration_card">Upload Ration Card:</label>
                <input type="file" id="ration_card" name="ration_card" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>

            <div class="form-group">
                <label for="bank_passbook">Upload Bank Passbook:</label>
                <input type="file" id="bank_passbook" name="bank_passbook" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>

            <div class="form-group">
                <label for="family_photo">Upload Family Photo:</label>
                <input type="file" id="family_photo" name="family_photo" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>

            <input type="submit" value="Register">
        </form>

        <div class="footer">
        &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>
</body>
</html>
