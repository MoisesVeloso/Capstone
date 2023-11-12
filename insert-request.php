<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "resourcetracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateReferenceNumber($department) {
    $year = date("Y");
    $month = date("m");
    $randomChars = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
    return $department . $year . $month . $randomChars;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentNo = $_POST['studentNo'];
    $fullname = $_POST['fullname'];
    $yearSection = $_POST['year-section'];
    $department = $_POST['department'];
    $equipment = $_POST['equipment'];

    $referenceNumber = generateReferenceNumber($department);

    $sql = "INSERT INTO requestform (reference_number, studentNo, fullname, year_section, department, equipment) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssss", $referenceNumber, $studentNo, $fullname, $yearSection, $department, $equipment);
        $stmt->execute();

        header("Location: request_submitted.php?ref=" . $referenceNumber);

    } else {
        echo "Error" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
