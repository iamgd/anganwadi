<?php
// Start session to store success/error messages
session_start();

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "anganwadi";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission for login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

    // Prepare SQL query to fetch user data
    $stmt = $conn->prepare("SELECT id, password FROM registrations WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if email exists in database
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashedPassword);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct
            $_SESSION['user_email'] = $email;
            $_SESSION['user_id'] = $user_id;  // Set user_id in session
            $_SESSION['login_success'] = "Login successful!";
            // Redirect to the dashboard or other page
            header("Location: parentindex.html");
            exit;
        } else {
            // Password is incorrect
            $_SESSION['login_error'] = "Invalid email or password.";
        }
    } else {
        // Email not found in the database
        $_SESSION['login_error'] = "Invalid email or password.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PARENT LOGIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        /* Global reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden; /* Remove horizontal overflow */
        }

        /* Top header style */
        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #211661;
            color: rgb(241, 240, 245);
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
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

        h2{
            margin-top: 40px;
            font-family: Eras Bold ITC;
        }

        /* Login form styles */
        .login-form {
            background-color: #211661;
            padding: 20px;
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 20px 0;
            height: 300px;
        }

        /* .login-form h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        } */

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #fff;
            margin-bottom: 5px;
            
            font-family: 'Comic Sans MS', sans-serif;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .form-group button {
            width: 50%;
            padding: 12px;
            background-color: #5573b4;
            color: white;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            display: flex;
            justify-content: center;
            font-family: 'Comic Sans MS', sans-serif;
        }

        .form-group button:hover {
            background-color: #7996cd;
        }

        /* Error and Success Messages */
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }

        /* Footer styles */
        .footer {
            background-color: #211661;
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        /* Ensure layout takes full height without extra space after footer */
        .container {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            flex-grow: 1; /* Make sure the container grows to fill the screen */
            width: 100%;
            margin: 0;
        }

        .login-form {
            margin-top: 20px;
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
        <a href="parentlogout.php" class="btn btn-danger">
            <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>
    <h2>PARENT LOGIN</h2>
    <!-- Login Form -->
    <div class="login-form">
       
        
        <!-- Display error message if set -->
        <?php
        if (isset($_SESSION['login_error'])) {
            echo '<p class="error-message">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']); // Clear the message after displaying
        }
        ?>

        <!-- Display success message if set -->
        <?php
        if (isset($_SESSION['login_success'])) {
            echo '<p class="success-message">' . $_SESSION['login_success'] . '</p>';
            unset($_SESSION['login_success']); // Clear the message after displaying
        }
        ?>

        <form action="parentlogin.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <button type="submit">Login</button>
                <button type="button" onclick="window.location.href='parentregister.html'" style="background-color: #5573b4; color: white; padding: 12px; border-radius: 30px; font-size: 16px; cursor: pointer; border: none; margin-left: 185px; margin-top: -45px; justify-content: center; ">
        Register
    </button>
            </div>
        </form>
    </div>
</div>

 <!-- Footer -->
 <div class="footer">
    &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
 </div>

</body>
</html>
