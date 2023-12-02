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
    $referenceNumber = $_POST['referenceNumber'];
    $equipment = $_POST['equipment']; // Added to retrieve equipment data
    
    $checkSql = "SELECT reference_number FROM form WHERE reference_number = ?";
    $checkStmt = $conn->prepare($checkSql);

    if ($checkStmt) {
    $checkStmt->bind_param("s", $referenceNumber);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Reference number already exists in the form table
        header("Location: form.php?error=Reference number already submitted.");
        exit();
    }
    } else {
    echo "Check statement preparation failed: " . $conn->error;
    exit();
}
    // Retrieve data from requestform table
    $sql = "SELECT fullname, studentNo, year_section, department, reference_number, approval_status FROM requestform WHERE reference_number = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $referenceNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $approvalStatus = $row['approval_status'];

                if ($approvalStatus === 'Approved') {
                    // Insert data into the form table
                    $insertSql = "INSERT INTO form (fullname, studentNo, year_section, department, reference_number, equipment) VALUES (?, ?, ?, ?, ?, ?)"; // Updated query
                    $insertStmt = $conn->prepare($insertSql);

                    if ($insertStmt) {
                        $insertStmt->bind_param("ssssss", $row['fullname'], $row['studentNo'], $row['year_section'], $row['department'], $row['reference_number'], $equipment); // Added equipment
                        $insertStmt->execute();

                        if ($insertStmt->affected_rows > 0) {
                            header("Location: success.html");
                            exit();
                        } else {
                            echo "Failed to insert data into the form table.";
                        }
                    } else {
                        echo "Insert statement preparation failed: " . $conn->error;
                    }
                } elseif ($approvalStatus === 'Pending') {
                    header("Location: form.php?error=Your request is pending. Please wait for approval.");
                } else {
                    header("Location: form.php?error=Your request is not approved.");
                }
            } else {
                header("Location: form.php?error=No data found for the given reference number.");
            }
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Statement preparation failed: " . $conn->error;
    }
}

$conn->close();
?>
