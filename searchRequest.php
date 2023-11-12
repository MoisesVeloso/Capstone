<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "resourcetracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reference-number'])) {
    $referenceNumber = $_POST['reference-number'];

    $sql = "SELECT fullname, studentNo, equipment, approval_status FROM requestform WHERE reference_number = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $referenceNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['fullname'];
            $studentNo = $row['studentNo'];
            $equipment = $row['equipment'];
            $approvalStatus = $row['approval_status'];

            echo "<p>Name: $name</p>";
            echo "<p>Student Number: $studentNo</p>";
            echo "<p>Equipment: $equipment</p>";

            if ($approvalStatus === 'Approved') {
                echo "<p>Your request has been Approved, proceed to your College Department</p>";
            } elseif ($approvalStatus === 'Declined') {
                echo "<p>Your request has been Declined. Equipment is not available</p>";
            } else {
                echo "<p>Your request is still Pending</p>";
            }
        } else {
            header("Location: requestStatus.php?error=Reference number doesn't exist or not correct");
        }
    } else {
        echo "Error in preparing the statement.";
    }

    $stmt->close();
}

$conn->close();
?>
