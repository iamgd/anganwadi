<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $host = 'localhost';
    $dbname = 'anganwadi';
    $username = 'root';
    $password = '';
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get and trim form data
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Debugging: Print input values after trimming
    echo "Input username: [$user] <br>";
    echo "Input password: [$pass] <br>";

    // Check the credentials
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$user]);
    $admin = $stmt->fetch();

    if ($admin) {
        // Debugging: Show stored values
        echo "Stored username in DB: [" . $admin['username'] . "]<br>";
        echo "Stored password in DB: [" . $admin['password'] . "]<br>";

        // Verify plain-text password match
        if ($pass === $admin['password']) {  // Plain-text comparison
            // Credentials match
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            // Redirect to admin dashboard
            header("Location: admin.html");
            exit();
        } else {
            echo "Passwords do not match.";
        }
    } else {
        echo "No user found with username: [$user]";
    }
}
