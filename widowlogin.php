<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306); // Adjust port if necessary

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle logout if requested
/*if (isset($_POST['logout'])) {
    session_destroy();
    echo "<script>alert('Logged out successfully!'); window.location.href = 'widowlogin.php';</script>";
    exit();
}*/

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare and execute SQL statement to fetch user details by email
    $stmt = $conn->prepare("SELECT * FROM widow_details WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Debugging: Check what is stored in the database
        $hashedPassword = $row['password'];
        echo "<script>console.log('Stored Hash: " . $hashedPassword . "');</script>";
    
        // Check if the entered password matches the stored hash
        if (password_verify($password, $hashedPassword)) {
            // Set session variables for user and user_id
            $_SESSION['user'] = $row['name'];  // Store user name in session
            $_SESSION['user_id'] = $row['id']; // Store user_id in session
            
            // Redirect to the next page (dashboard)
            echo "<script>window.location.href = 'widowindex.html';</script>";
        } else {
            echo "<script>alert('Invalid password!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Invalid email!'); window.history.back();</script>";
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
    <title>WIDOW LOGIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
     /* Global Reset */
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

h2 {
    margin-top: 30px; /* Adjust the value as needed */
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

/* Content section styling */
.content {
    width: 100%;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    align-items: center; /* Center align items */
    margin-top: 30px; /* Move the login form down */
}

/* Login form styling */
.login-form {
    background-color: #211661; /* Form background color */
    max-width: 400px;
    width: 100%;
    padding: 20px;
    border-radius: 35px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 20px 0; /* Space around the form */
}

label {
    font-weight: bold;
    color: white; /* Form label color */
    display: block;
    margin-bottom: 6px;
    margin-top: 12px;
    font-family: 'Comic Sans MS', sans-serif;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 30px;
    background-color: #f9f9f9; /* Light background for input fields */
}

input[type="submit"] {
    width: 50%;
    color: white;
    background-color: #5573b4;
    padding: 12px;
    border-radius: 30px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
}

button {
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

input[type="submit"]:hover {
    background-color: #7996cd;
}

.error {
    color: red;
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
    position: absolute; /* Fix footer to the bottom */
    bottom: 0;
}

@media (max-width: 600px) {
    .login-form {
        padding: 15px;
        width: 90%;
    }
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
        <a href="widowlogout.php" class="btn btn-danger">
            <i class="bi bi-box-arrow-right"></i>
        </a>
        <!-- <a href="adminlogin.html">ADMIN</a> -->
    </div>

    <h2>WIDOW LOGIN</h2>
    <form class="login-form" method="post" action="widowlogin.php">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <input type="submit" name="login" value="Login">
        </div>

        <button type="button" onclick="window.location.href='widowreg.php'" style="background-color: #5573b4; width: 50%; color: white; padding: 12px; border-radius: 30px; font-size: 16px; cursor: pointer; border: none; margin-left: 185px; margin-top:-45px; justify-content: center; ">
            Register
        </button> 
</div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
    </div>
</div>
</body>
</html>
