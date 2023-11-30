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

$sql = "SELECT COUNT(*) AS total FROM requestform WHERE department = '$department' AND status = 'view'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error executing query: " . $conn->error;
} else {
    $row = $result->fetch_assoc();
    echo $row['total'];
}

$conn->close();
?>
