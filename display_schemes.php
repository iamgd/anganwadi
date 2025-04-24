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
    <title>Display Schemes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        select, option {
            padding: 8px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Display Government Schemes</h2>

        <!-- Filter by type dropdown -->
        <label for="typeFilter">Filter by Type: </label>
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
            window.location.href = `display_schemes.php?type=${type}`;
        }
    </script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
