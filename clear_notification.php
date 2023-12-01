<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "resourcetracking";

$department = isset($_SESSION['department']) ? $_SESSION['department'] : "default";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$requestFormId = $_SESSION['request_form_id'];

$sql = "UPDATE requestform SET status = 'viewed' WHERE id = ? AND status = 'view'";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $requestFormId); 

    if ($stmt->affected_rows > 0) {
    
        echo "Status updated to 'viewed'";
    } else {
    
        echo "Failed to update status or ID does not match 'view'";
    }

    $stmt->close();
} else {
    echo "Database error";
}

$conn->close();
?>
