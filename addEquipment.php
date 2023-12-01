<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "ResourceTracking";

session_start();

$conn = new mysqli($servername, $username, $password, $database);

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($username) {
        // Fetch user's department
        $sqlUser = "SELECT department FROM usertable WHERE username = ?";
        $stmtUser = $conn->prepare($sqlUser);

        if ($stmtUser) {
            $stmtUser->bind_param("s", $username);
            $stmtUser->execute();
            $resultUser = $stmtUser->get_result();

            if ($resultUser->num_rows > 0) {
                $rowUser = $resultUser->fetch_assoc();
                $userDepartment = $rowUser['department'];

                // Process file upload
                $imagePath = 'uploads/' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

                // Get other form data
                $equipment = $_POST['equipment'];
                $type = $_POST['type'];

                // Insert into database using prepared statement
                $sql = "INSERT INTO equipment (equipment, type, image_path, department) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("ssss", $equipment, $type, $imagePath, $userDepartment);
                    if ($stmt->execute()) {
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        echo "Error in executing statement: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Error in preparing statement: " . $conn->error;
                }
            } else {
                echo "Error retrieving user's department";
            }
        } else {
            echo "Error preparing user query: " . $conn->error;
        }
    } else {
        echo "User not authenticated";
    }
}

$conn->close();
?>
