<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get type filter (if any)
$typeFilter = isset($_GET['type']) ? $_GET['type'] : '';

// SQL query to fetch schemes based on filter
$sql = "SELECT * FROM schemes";
if ($typeFilter) {
    $sql .= " WHERE type = ?";
}

$stmt = $conn->prepare($sql);
if ($typeFilter) {
    $stmt->bind_param("s", $typeFilter);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FHW Schemes</title>
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
            
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
                   
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 2px solid #211661;
            
        }
        .container1 {
            width: 50%;
            margin: 0 auto;
            margin-top: 30px;
        }
        select, option {
            padding: 8px;
            margin-top: 10px;
        }
        h2{
            text-align: center;
            color: #211661;
        
            font-family: Eras Bold ITC;
          

        }
        th{
            color:white;
            background-color: #211661 ;
            
        }
        label{
            color: #211661;
        }     </style>
</head>
<body>
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
            <a href="fhwlogout.php" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>

    <div class="container1">
        <h2>GOVERNMENT SCHEMES</h2>

        <!-- Filter by type dropdown -->
        <label for="typeFilter">TYPE: </label>
        <select id="typeFilter" onchange="filterSchemes()">
            <option value="">All</option>
            <option value="parents" <?= $typeFilter == 'parents' ? 'selected' : '' ?>>Parents</option>
            <option value="widow" <?= $typeFilter == 'widow' ? 'selected' : '' ?>>Widow</option>
            <option value="senior_citizen" <?= $typeFilter == 'senior_citizen' ? 'selected' : '' ?>>Senior Citizen</option>
            <option value="fhw" <?= $typeFilter == 'fhw' ? 'selected' : '' ?>>Family Head Woman</option>
        </select>

        <table id="schemesTable">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Scheme Name</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['type']) ?></td>
                        <td><?= htmlspecialchars($row['scheme_name']) ?></td>
                        <td><a href="<?= htmlspecialchars($row['link']) ?>" target="_blank">View</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

    <script>
        // Function to filter schemes based on selected type
        function filterSchemes() {
            const type = document.getElementById("typeFilter").value;
            window.location.href = `fhwdisplay_schemes.php?type=${type}`;
        }
    </script>
<div class="footer">
            &copy; 2024 Department of Woman and Child Development, Government of Puducherry. All rights reserved.
        </div>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
