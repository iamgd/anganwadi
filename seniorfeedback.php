<!doctype html>
	<html>
		<head>
  		  <title>
		    Senior Feedback</title>
		  <link rel="stylesheet" href="css/bootstrap.min.css">
		  <script src="js/bootstrap.min.js"></script>
		  <script src="js/jquery-3.3.1.min.js"></script>
		  <link rel="stylesheet" href="Stylesheet.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
		</head>
        <style>

        /* Style the main form container */

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
            padding-bottom: 30px; /* Space for footer */
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


        /* Content Area */
        .content {
            flex-grow: 1; /* This makes the content area expand to fill the space */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center the content */
            padding: 20px;
            color: black;
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
       


        #form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 420px;
            background: #211661;
            margin-top: 20px;
            width: 400px;
            border-radius: 30px;
           
        }
        
        #mainform {
            background: #fff;
            padding: 15px;
            border-radius: 30px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            
            /* margin-top: 20px; */
        }

        .contact-us {
            font-size: 30px;
            font-family:  'Eras Bold ITC';
            color: #211661;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        label h3 {
            color: #333;
            font-weight: 600;
           
        }

        .form-control {
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 30px;
            width: 100%;
        }

        #btn {
            font-size: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #17a2b8;
            border-radius: 30px;
            text-shadow: 0 0 3px #000;
            margin-top: 30px;
            align-items: center;
            width: 100%;
        }

        #btn:hover {
            background-color: #138496;
        }

        
        .form-group{
            align-items: center;
            
        }
        label{
            font-size: 20px;
            font-family:  'Eras Bold ITC';
            color: #211661;
           
        }
    </style><body>
<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi";

// Create a connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Retrieve the email and comment from the form input
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    
    // Prepare the SQL query
    $sql = "INSERT INTO feedback (EMAIL, COMMENT) VALUES ('$email', '$comment')";
    
    // Execute the query and check if it was successful
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        echo '<script>alert("Feedback Sent Successfully!! THANK YOU!!"); window.location.href = "staffindex.html";</script>';
    } else {
        // Display the error message if the query failed
        echo '<script>alert("Failed to send feedback: ' . mysqli_error($con) . '");</script>';
    }
}

// Close the database connection
mysqli_close($con);
?>


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


<div id="form">
    <div class="col-md-12" id="mainform">
        <div class="text-center">
            <h2 class="contact-us">FEEDBACK</h2>
        </div>
        <form method="POST">
            <div class="form-group">
                <label>NAME</label>
                <input type="text" name="name" class="form-control" placeholder="  User Name" required>
            </div>
            <div class="form-group">
                <label>EMAIL</label>
                <input type="email" name="email" class="form-control" placeholder="  User Email" required>
            </div>
            <div class="form-group d-flex align-items-center">
    <label class="mr-3" >COMMENTS</label>
    <textarea class="form-control" name="comment" rows="3" placeholder="  Message" required style="flex-grow: 1;"></textarea>
</div>
<div class="form-group text-center">
                <input type="submit" class="btn btn-info" id="btn" value="SUBMIT" name="submit">
                
            </div>
        </form>
    </div>
</div>
       

<!-- Add Bootstrap JS and dependencies (optional, for Bootstrap components functionality) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>
</body>
</html>
