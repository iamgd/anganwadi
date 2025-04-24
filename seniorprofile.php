<?php
// Start the session to access the logged-in user info
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view this page.");
}

// Connect to the database
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "anganwadi"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user's ID from session
$user_id = $_SESSION['user_id'];

// Retrieve user data from the `above_60_dashboard` table
$sql = "SELECT id, name, email, address, phone, dob, aadhaar FROM above_60_dashboard WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// If the user exists, fetch their data
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit();
}

// Handle form submission (edit profile)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated details from the form
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $aadhaar = $_POST['aadhaar'];
    $email = $_POST['email'];

    // Prepare an SQL statement to update the user details
    $update_sql = "UPDATE above_60_dashboard SET 
                    name = ?, 
                    address = ?, 
                    phone = ?, 
                    dob = ?, 
                    aadhaar = ?, 
                    email = ? 
                    WHERE id = ?";
    
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $name, $address, $phone, $dob, $aadhaar, $email, $user_id);
    
    if ($update_stmt->execute()) {
        // Success message
        echo "Profile updated successfully!";
        
        // Refresh the data after update
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
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
            margin-top: -40px;
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
        }

        .container1 {
            width: 80%;
            max-width: 500px;
            padding: 20px;
            background-color: rgb(228, 195, 195);
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            font-family: "Comic Sans MS"; 
            overflow-y: auto;
            height: 355px;
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            text-align: center;
            font-family: Eras Bold ITC;
            color:#211661;
            font-size: 24px;
        }

        form p {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        form  label {
            margin-bottom: 5px;
        }

        form input[type="text"],
        form  input[type="email"],
        form  input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
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

<div class="navbar">
            
<a href="seniorindex.html" target="_self">HOME</a>
            <a href="seniorview_updates.php" target="_self">DAILY UPDATE</a>
            <a href="seniortodaymealsnotifi.php" target="_self">TODAY MEALS</a>
            <a href="seniorcampnotifi.php" target="_self">CAMP DETAILS</a>
            <a href="seniorfeedback.php" target="_self">FEEDBACK</a>
            <a href="seniordisplay_schemes.php" target="_self">SCHEMES</a>
            <a href="seniorprofile.php" target="_self">PROFILE</a>
            <a href="seniorlogout.php" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>


<div class="container1">
    <h2>SENIOR PROFILE </h2>

    <form action="" method="post">
    <p>ID: <?php echo $user['id']; ?></p>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required><br><br>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br><br>
        
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<?php echo $user['dob']; ?>" required><br><br>
        
        <label for="aadhaar">Aadhaar:</label>
        <input type="text" id="aadhaar" name="aadhaar" value="<?php echo htmlspecialchars($user['aadhaar']); ?>" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>
        
        <button type="submit">Update Profile</button>
    </form>
</div>
<div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
