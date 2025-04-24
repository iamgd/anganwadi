<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anganwadi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

// Handle GET request to fetch all schemes with type filtering
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $sql = "SELECT * FROM schemes";
    
    if ($type) {
        $sql .= " WHERE type = ?";
    }

    $stmt = $conn->prepare($sql);
    if ($type) {
        $stmt->bind_param("s", $type);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    
    $schemes = [];
    while ($row = $result->fetch_assoc()) {
        $schemes[] = $row;
    }

    echo json_encode(["success" => true, "schemes" => $schemes]);
    exit();
}

// Handle POST request to add a new scheme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $scheme_name = $data['scheme_name'];
    $link = $data['link'];
    $type = $data['type'];

    if (!empty($scheme_name) && !empty($link) && !empty($type)) {
        $stmt = $conn->prepare("INSERT INTO schemes (scheme_name, link, type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $scheme_name, $link, $type);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "scheme" => ["id" => $conn->insert_id, "scheme_name" => $scheme_name, "link" => $link, "type" => $type]]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add scheme."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Incomplete data."]);
    }
    exit();
}

// Handle DELETE request to delete a scheme
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM schemes WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete scheme."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid ID."]);
    }
    exit();
}

$conn->close();
?>
