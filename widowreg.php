<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi"; // Use your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $guardian = $_POST['guardian'];
    $child_name = $_POST['child_name'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Target directories for uploads
    $target_dir = "uploads/";
    
    // File uploads with default empty strings if no file uploaded
    $death_certificate = isset($_FILES['death_certificate']['name']) && $_FILES['death_certificate']['name'] ? $_FILES['death_certificate']['name'] : '';
    $bank_passbook = isset($_FILES['bank_passbook']['name']) && $_FILES['bank_passbook']['name'] ? $_FILES['bank_passbook']['name'] : '';
    $aadhaar = isset($_FILES['aadhaar']['name']) && $_FILES['aadhaar']['name'] ? $_FILES['aadhaar']['name'] : '';
    $ration_card = isset($_FILES['ration_card']['name']) && $_FILES['ration_card']['name'] ? $_FILES['ration_card']['name'] : '';
    $voter_id = isset($_FILES['voter_id']['name']) && $_FILES['voter_id']['name'] ? $_FILES['voter_id']['name'] : '';

    // Set target paths or leave as empty strings
    $death_certificate_target = $death_certificate ? $target_dir . basename($death_certificate) : '';
    $bank_passbook_target = $bank_passbook ? $target_dir . basename($bank_passbook) : '';
    $aadhaar_target = $aadhaar ? $target_dir . basename($aadhaar) : '';
    $ration_card_target = $ration_card ? $target_dir . basename($ration_card) : '';
    $voter_id_target = $voter_id ? $target_dir . basename($voter_id) : '';

    // Move uploaded files if they exist
    if ($death_certificate) {
        move_uploaded_file($_FILES['death_certificate']['tmp_name'], $death_certificate_target);
    }
    if ($bank_passbook) {
        move_uploaded_file($_FILES['bank_passbook']['tmp_name'], $bank_passbook_target);
    }
    if ($aadhaar) {
        move_uploaded_file($_FILES['aadhaar']['tmp_name'], $aadhaar_target);
    }
    if ($ration_card) {
        move_uploaded_file($_FILES['ration_card']['tmp_name'], $ration_card_target);
    }
    if ($voter_id) {
        move_uploaded_file($_FILES['voter_id']['tmp_name'], $voter_id_target);
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO widow_temp (name, email, address, phone, guardian, child_name, dob, age, password, death_certificate, bank_passbook, aadhaar, ration_card, voter_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssissssss", $name, $email, $address, $phone, $guardian, $child_name, $dob, $age, $hashed_password, $death_certificate_target, $bank_passbook_target, $aadhaar_target, $ration_card_target, $voter_id_target);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!');</script>";
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
    <title>WIDOW REGISTRATION</title>
    <style>
        /* Universal Styles */
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
            margin: 30px 0;
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

        /* Form Styling */
        .form-container {
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
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: white;
            display: block;
            margin-bottom: 6px;
            margin-top: 12px;
            font-family: 'Comic Sans MS';
        }

        input[type="text"],
        input[type="password"],
        input[type="tel"],
        input[type="date"],
        input[type="email"],
        input[type="number"],
        select,
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
            background-color: #5573b4;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #7996cd;
        }

        /* Error and Success Messages */
        .error {
            color: red;
            text-align: center;
        }

        .success {
            color: green;
            text-align: center;
        }

        /* Footer */
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

        #age {
            background-color: #f1f1f1;
            pointer-events: none;
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

        <h2>WIDOW REGISTRATION</h2>
        <div class="form-container"> <!-- Added form container -->
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email ID:</label>
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
                    <label for="phone">Phone Number:</label>
                    <input type="text" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="guardian">Guardian (if applicable):</label>
                    <input type="text" id="guardian" name="guardian">
                </div>

                <h3>Children's Information</h3>
                <div class="form-group">
                    <label for="child_name">Child's Name:</label>
                    <input type="text" id="child_name" name="child_name">
                </div>

                <div class="form-group">
                    <label for="dob">Child's Date of Birth:</label>
                    <input type="date" id="dob" name="dob" onchange="calculateAge()" required>
                </div>

                <div class="form-group">
                    <label for="age">Child's Age:</label>
                    <input type="number" id="age" name="age" readonly>
                </div>

                <h3>Document Uploads</h3>
                <div class="form-group">
                    <label for="birth_certificate">Birth Certificate:</label>
                    <input type="file" id="birth_certificate" name="birth_certificate" required>
                </div>

                <div class="form-group">
                    <label for="aadhaar_card">Aadhaar Card:</label>
                    <input type="file" id="aadhaar_card" name="aadhaar_card" required>
                </div>

                <div class="form-group">
                    <label for="ration_card">Ration Card:</label>
                    <input type="file" id="ration_card" name="ration_card" required>
                </div>

                <div class="form-group">
                    <label for="bank_passbook">Bank Passbook:</label>
                    <input type="file" id="bank_passbook" name="bank_passbook" required>
                </div>

                <input type="submit" value="Register">
            </form>
        </div> <!-- End of form container -->

        <!-- Footer -->
        <div class="footer">
        &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>

    <script>
        function calculateAge() {
            const dob = new Date(document.getElementById('dob').value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            document.getElementById('age').value = age;
        }
    </script>
</body>
</html>
