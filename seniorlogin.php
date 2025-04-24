<?php
// Start session
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

// Initialize error message
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // SQL query to fetch senior details using email
        $sql = "SELECT * FROM above_60_dashboard WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if email exists in the database
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Check password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $user['name'];
                $_SESSION['age'] = $user['age'];

                // Redirect to senior dashboard
                echo "<script>window.location.href = 'seniorindex.html';</script>";
                exit();
            } else {
                $error = 'Incorrect email or password.';
            }
        } else {
            $error = 'No account found for this email.';
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENIOR CITIZEN LOGIN</title>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">
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
            font-size: 18px;
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
            margin-top: 10px;
        }

        /* Content section styling */
        .content {
            width: 100%;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
        }

        /* Login form styling */
        form {
            background-color: #211661;
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            height: 300px
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            margin-top: 12px;
            color: white;
            font-family: 'Comic Sans MS', sans-serif;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 30px;
            background-color: #f9f9f9;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 50%;
            color: white;
            background-color: #5573b4;
            padding: 12px;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            font-family: 'Comic Sans MS', sans-serif;
        }

        input[type="submit"]:hover {
            background-color: #7996cd;
        }

        p.error {
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
            <a href="seniorlogout.php" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>

        <!-- Content Section with login form -->
        <div class="content">
            <h2>SENIOR CITIZEN LOGIN</h2>

            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
               
                <input type="submit" value="Login">
                <button type="button" onclick="window.location.href='seniorreg.php'" style="background-color: #5573b4; width: 50%; color: white; padding: 12px; border-radius: 30px; font-size: 16px; cursor: pointer; border: none; margin-left: 185px; margin-top:-47px; justify-content: center; display: flex;  font-family: 'Comic Sans MS', sans-serif; ">
                 Register
                 </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>
</body>
</html>
