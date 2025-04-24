<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "anganwadi";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper function to handle file uploads
function uploadFile($file, $targetDir) {
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create directory if it doesn't exist
    }
    $targetFile = $targetDir . basename($file["name"]);
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }
    return null;
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting and sanitizing form data
    $name = mysqli_real_escape_string($conn, $_POST["name"] ?? "");
    $husbandName = mysqli_real_escape_string($conn, $_POST["husbandName"] ?? "");
    $address = mysqli_real_escape_string($conn, $_POST["address"] ?? "");
    $phone = mysqli_real_escape_string($conn, $_POST["phone"] ?? "");
    $nativePlace = mysqli_real_escape_string($conn, $_POST["nativePlace"] ?? "");
    $aadharNo = mysqli_real_escape_string($conn, $_POST["aadharNo"] ?? "");
    $pregnancyStatus = isset($_POST["pregnancyStatus"]) && $_POST["pregnancyStatus"] === "yes" ? 1 : 0;
    $email = mysqli_real_escape_string($conn, $_POST["email"] ?? "");
    $password = password_hash($_POST["password"] ?? "", PASSWORD_BCRYPT);

    // Check if Aadhaar number already exists
    $checkAadhaarQuery = "SELECT * FROM parent_temp WHERE aadhar_no = ?";
    $stmt = $conn->prepare($checkAadhaarQuery);
    $stmt->bind_param("s", $aadharNo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Aadhaar number already exists, show an error message
        echo "Error: Aadhaar number already exists.";
        $stmt->close();
        $conn->close();
        exit();  // Stop further execution
    }
    $stmt->close();

    // File upload paths
    $photo = isset($_FILES["photo"]) ? uploadFile($_FILES["photo"], "uploads/photos/") : null;
    $bankPassbook = $pregnancyStatus && isset($_FILES["bankPassbook"]) ? uploadFile($_FILES["bankPassbook"], "uploads/bank_passbook/") : "";

    // Additional data for pregnancy or children
    $pregnancyMonth = $pregnancyStatus ? intval($_POST["pregnancyMonth"] ?? 0) : 0; // Set to 0 if not pregnant
    $childCount = !$pregnancyStatus && isset($_POST["childCount"]) ? intval($_POST["childCount"]) : 0;

    // Prepare child details JSON if not pregnant
    $childDetails = [];
    if (!$pregnancyStatus && $childCount > 0) {
        for ($i = 1; $i <= $childCount; $i++) {
            $childNameKey = "childName$i";
            $childDobKey = "childDob$i";
            $childGenderKey = "childGender$i";
            $childHeightKey = "childHeight$i";
            $childWeightKey = "childWeight$i";
            $birthCertificateKey = "birthCertificate$i";

            $childDetails[] = [
                "name" => mysqli_real_escape_string($conn, $_POST[$childNameKey] ?? ""),
                "dob" => mysqli_real_escape_string($conn, $_POST[$childDobKey] ?? ""),
                "gender" => mysqli_real_escape_string($conn, $_POST[$childGenderKey] ?? ""),
                "height" => intval($_POST[$childHeightKey] ?? 0),
                "weight" => intval($_POST[$childWeightKey] ?? 0),
                "birth_certificate" => isset($_FILES[$birthCertificateKey]) ? uploadFile($_FILES[$birthCertificateKey], "uploads/birth_certificates/") : ""
            ];
        }
    }
    $childDetailsJson = json_encode($childDetails);

    // Inserting data into the database
    $stmt = $conn->prepare("INSERT INTO parent_temp(name, husband_name, address, phone_no, photo, native_place, aadhar_no, pregnancy_status, pregnancy_month, child_count, child_details, email, password, bank_passbook) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssiiisss", $name, $husbandName, $address, $phone, $photo, $nativePlace, $aadharNo, $pregnancyStatus, $pregnancyMonth, $childCount, $childDetailsJson, $email, $password, $bankPassbook);

    if ($stmt->execute()) {
        // Redirect to login.php after successful registration
        header("Location: parentlogin.php");
        exit(); // Stop further execution after redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
