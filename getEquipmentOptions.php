<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "resourcetracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$department = $_GET['department'];

$sql = "SELECT DISTINCT type FROM equipment WHERE department = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $department);
    $stmt->execute();
    $result = $stmt->get_result();
    $equipmentTypes = array();

    while ($row = $result->fetch_assoc()) {
        $equipmentTypes[] = $row['type'];
    }

    echo json_encode($equipmentTypes);
} else {
    echo json_encode(array());
}

$stmt->close();
$conn->close();