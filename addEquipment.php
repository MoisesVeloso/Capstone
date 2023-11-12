<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ResourceTracking";

session_start();

$conn = new mysqli($servername, $username, $password, $database);

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($username) {
        $sqlUserId = "SELECT id FROM usertable WHERE username = '$username'";
        $resultUserId = $conn->query($sqlUserId);

        if ($resultUserId !== false && $resultUserId->num_rows > 0) {
            $rowUserId = $resultUserId->fetch_assoc();
            $userId = $rowUserId['id'];

            $sqlUser = "SELECT department FROM usertable WHERE id = $userId";
            $resultUser = $conn->query($sqlUser);

            if ($resultUser !== false && $resultUser->num_rows > 0) {
                $rowUser = $resultUser->fetch_assoc();
                $userDepartment = $rowUser['department'];

                $imagePath = 'uploads/' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

                $brand = $_POST['brand'];
                $type = $_POST['type'];

                $sql = "INSERT INTO equipment (brand, type, image_path, department) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    // Adjust the data types and remove the extra placeholder
                    $stmt->bind_param("ssss", $brand, $type, $imagePath, $userDepartment);
                    $stmt->execute();

                    header("Location: dashboard.php");
                    exit();

                    $stmt->close();
                } else {
                    echo "Error in preparing statement: " . $conn->error;
                }
            } else {
                echo "Error retrieving user's department";
            }
        } else {
            echo "Error retrieving user's ID";
        }
    } else {
        echo "User not authenticated";
    }
}

$conn->close();
?>
