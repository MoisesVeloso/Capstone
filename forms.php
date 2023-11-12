<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "resourcetracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $yearSection = $_POST['year-section'];
    $studentNo = $_POST['studentNo'];
    $department = $_POST['department'];
//  $equipment = $_POST['equipment'];

    $sql = "INSERT INTO form (fullname, year_section, studentNo, department) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepared statement error: " . $conn->error);
    }
    $stmt->bind_param("ssss", $fullname, $yearSection, $studentNo, $department);

    if ($stmt->execute()) {
        header("Location: success.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
