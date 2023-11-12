<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "resourcetracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reference_number'])) {
    $reference_number = $_POST['reference_number'];
    $approval_status = $_POST['approval_status'];

    $sql = "UPDATE requestform SET approval_status = ? WHERE reference_number = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $approval_status, $reference_number);

        if ($stmt->execute()) {
            header("Location: request.php");
        } else {
            echo "Error updating status: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error in preparing statement.";
    }
}

$conn->close();
?>
