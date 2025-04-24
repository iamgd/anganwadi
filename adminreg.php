<?php
// Database connection
$host = 'localhost';
$dbname = 'anganwadi';
$username = 'root';
$password = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password']; // Store the password as plain text

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$user, $email, $pass]);

    // After registration, redirect to the login page
    header("Location: adminlogin.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
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
            padding-bottom: 0 0 30px; /* Space for footer */
            background-color: #f0f0f0;
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }

        .form-container {
            background-color: #211661; /* Form background color */
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px 0; /* Space around the form */        }

            label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: white;
            width: 80%;
            font-family: 'Comic Sans MS', sans-serif;
        }

        h2 {
            text-align: center;
            color: #211661;
            font-family: Eras Bold ITC;
            margin-top: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 30px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #5573b4;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            width: 100%;
        }

        button:hover {
            background-color: #7996cd;
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
            <a href="adminlogin.html">ADMIN</a>
        </div>
        <h2>Admin Registration</h2>
 
    <div class="form-container">

        <form id="register-form" action="adminreg.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </div>
    <div class="footer">
        &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
    </div>
</div>
    <script>
        // Form validation for password length
        document.getElementById('register-form').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
