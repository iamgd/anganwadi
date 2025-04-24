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

// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("SELECT id, password FROM family_head_woman_dashboard WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $id; // Store user_id in session
            header("Location: fhwindex.html"); // Redirect to dashboard or home page
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Email not found!";
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
    <title>FHW LOGIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
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
            background-color: #f0f0f0;
            position: relative;
            padding-bottom: 0 0 30px; /* Space for footer */
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
            padding: 9px; /* Adjusted padding */
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

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0; /* Remove body padding */
        }
        
        h2 {
            text-align: center;
            color: #211661;
            font-family: Eras Bold ITC;
            margin-top: 35px;
        }

        .content {
            width: 100%;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center align items */
            margin-top: 30px;
        }

        form {
            background-color: #211661; /* Form background color */
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 30px 0; /* Space around the form */
            height: 300px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            margin-top: 20px;
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: white;
            width: 80%;
            font-family: 'Comic Sans MS', sans-serif;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
           
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
            form {
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
            <a href="fhwlogout.php" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>

        <h2>FAMILY HEAD WOMEN LOGIN</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div><br>

            <!-- <input type="submit" value="Login"><br><br>
            <a style="color: white;" href="fhwreg.php">Register</a> -->

            <button type="submit">Login</button>
            <button type="button" onclick="window.location.href='fhwreg.php'" style="background-color: #5573b4; width: 50%; color: white; padding: 12px; border-radius: 30px; font-size: 16px; cursor: pointer; border: none; margin-left: 185px; margin-top:-45px; justify-content: center; ">
            Register
             </button>   
        </form>
        
        <div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
</div>
</body>
</html> 
