<?php
session_start();
// Include your database connection file

// Check if the user is logged in
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

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT id, name, address, phone, guardian, dob, email FROM widow_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Update user details if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $guardian = $_POST['guardian'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];

    $update_sql = "UPDATE widow_details SET name = ?, address = ?, phone = ?, guardian = ?, dob = ?, email = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $name, $address, $phone, $guardian, $dob, $email, $user_id);

    if ($update_stmt->execute()) {
        echo "Profile updated successfully.";
        // Refresh data
        $user['name'] = $name;
        $user['address'] = $address;
        $user['phone'] = $phone;
        $user['guardian'] = $guardian;
        $user['dob'] = $dob;
        $user['email'] = $email;
    } else {
        echo "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Widow Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        /* Reset default margins and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        .middle-header .title1 {
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
      
        .container1 {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: rgb(228, 195, 195);
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            height: 360px;
            overflow-y: auto;
            font-family: 'Comic Sans MS';
        }

        h2 {
            text-align: center;
            font-family: Eras Bold ITC;
            color: #211661;
            font-size: 24px;
            margin-bottom: 24px;
        }

        form p {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            font-family: Comic Sans MS;
        }

        form p label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        form input[type="text"]{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px; 
        }

        form  input[type="email"]{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
        }

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
            border-radius: 30px;
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
        <img src="images/logo3.jpg" alt="Middle Logo" class="logo">
        <div class="title1">DEPARTMENT OF WOMAN AND CHILD DEVELOPMENT</div>
    </div>

    <div class="navbar">
        <a href="widowindex.html" target="_self">HOME</a>
        <a href="widowview_updates.php" target="_self">DAILY UPDATE</a>
        <a href="widowtodaymealsnotifi.php" target="_self">TODAY MEALS</a>
        <a href="widowcampnotifi.php" target="_self">CAMP DETAILS</a>
        <a href="widowfeedback.php" target="_self">FEEDBACK</a>
        <a href="widowdisplay_schemes.php" target="_self">SCHEMES</a>
        <a href="widowprofile.php" target="_self">PROFILE</a>
        <a href="widowlogout.php" class="btn btn-danger">
            <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>

    <div class="container1">
        <h2>Widow Profile</h2>

        <form method="POST" action="">
            <p>ID: <?php echo $user['id']; ?></p>

            <label>Name:</label><br>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"><br><br>

            <label>Address:</label><br>
            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>"><br><br>

            <label>Phone:</label><br>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br><br>

            <label>Guardian:</label><br>
            <input type="text" name="guardian" value="<?php echo htmlspecialchars($user['guardian']); ?>"><br><br>

            <label>Date of Birth:</label><br>
            <input type="date" name="dob" value="<?php echo $user['dob']; ?>"><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 Department of Woman and Child Development</p>
</div>

</body>
</html>
