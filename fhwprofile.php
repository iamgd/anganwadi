<?php
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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'fhwlogin.php';</script>";
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT id, name, husband_name, email, address, phone, ration_card_color FROM family_head_woman_dashboard WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle profile update
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $husband_name = htmlspecialchars(trim($_POST['husband_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $address = htmlspecialchars(trim($_POST['address']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $ration_card_color = htmlspecialchars(trim($_POST['ration_card_color']));

    // Update query
    $update_sql = "UPDATE family_head_woman_dashboard SET name = ?, husband_name = ?, email = ?, address = ?, phone = ?, ration_card_color = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $name, $husband_name, $email, $address, $phone, $ration_card_color, $user_id);

    if ($update_stmt->execute()) {
        $error = "Profile updated successfully!";
        // Refresh user data after update
        $user['name'] = $name;
        $user['husband_name'] = $husband_name;
        $user['email'] = $email;
        $user['address'] = $address;
        $user['phone'] = $phone;
        $user['ration_card_color'] = $ration_card_color;
    } else {
        $error = "Error updating profile.";
    }
    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FHW Profile Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        /* Your CSS styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow: hidden;
        }

      
        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #211661;
            color: rgb(241, 240, 245);
            padding: 20px;
            width: 100%;
            margin-top: 20px;
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
            /* overflow: hidden;
            white-space: nowrap; */
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
            margin-top: -40px;
        }

       
        .container1 {
            width: 80%;
            max-width: 500px;
            padding: 20px;
            background-color: rgb(228, 195, 195);
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: 'Comic Sans MS';
            overflow-y: auto;
            height: 340px;
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

        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 16px;
        }
        .error {
            color: green;
            margin-bottom: 15px;
        }
        .btn{
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
        .btn:hover {
            background-color: #45a049;
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
            <a href="fhwindex.html" target="_self">HOME</a> 
            <a href="fhwview_updates.php" target="_self">DAILY UPDATE</a>
            <a href="fhwtodaymealsnotifi.php" target="_self">TODAY MEALS</a>
            <a href="fhwcampnotifi.php" target="_self">CAMP DETAILS</a> 
            <a href="fhwfeedback.php" target="_self">FEEDBACK</a>
            <a href="fhwdisplay_schemes.php" target="_self">SCHEMES</a>
            <a href="fhwprofile.php" target="_self">PROFILE</a>
            <a href="fhwlogout.php" class="diff-btn">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>

<div class="container1">
    <h2>FHW PROFILE</h2>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
    <p>ID: <?php echo $user['id']; ?></p>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="husband_name">Husband's Name:</label>
            <input type="text" id="husband_name" name="husband_name" value="<?php echo htmlspecialchars($user['husband_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>

        <div class="form-group">
            <label for="ration_card_color">Ration Card Color:</label>
            <input type="text" id="ration_card_color" name="ration_card_color" value="<?php echo htmlspecialchars($user['ration_card_color']); ?>" required>
        </div>

        <button type="submit" class="btn">Update Profile</button>
    </form>
</div>
<div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>

    </div>

</body>
</html>
