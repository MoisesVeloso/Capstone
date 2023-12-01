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

    $sql = "INSERT INTO requestform (reference_number, studentNo, fullname, year_section, department, equipment, status) VALUES (?, ?, ?, ?, ?, ?, 'view')";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
    $stmt->bind_param("ssssss", $referenceNumber, $studentNo, $fullname, $yearSection, $department, $equipment);
        $stmt->execute();

        $notificationMsg = "New request submitted by " . $fullname . " for " . $equipment;
        $departmentNotificationSql = "INSERT INTO department_notifications (department, notification_message) VALUES (?, ?)";
        $departmentNotificationStmt = $conn->prepare($departmentNotificationSql);

        if ($departmentNotificationStmt) {
            $departmentNotificationStmt->bind_param("ss", $department, $notificationMsg);
            $departmentNotificationStmt->execute();
            $departmentNotificationStmt->close();
        } else {
            echo "Error preparing department notification statement: " . $conn->error;
        }

        header("Location: request_submitted.php?ref=" . $referenceNumber);
    } else {
        echo "Error inserting request form data: " . $conn->error;
    }

    $stmt->close();
}