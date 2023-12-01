<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ResourceTracking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'image' key is set in the $_FILES array
    if (isset($_FILES['image'])) {
        // Handle image upload
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        // Handle the case where 'image' key is not set
        echo "Error: 'image' key not set in the form.";
        exit();
    }

    // Check if the 'title', 'brand', and 'model' keys are set in the $_POST array
    if (isset($_POST['title'], $_POST['brand'], $_POST['model'])) {
        $title = $_POST['title'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];

        $sql = "INSERT INTO equipment (title, brand, model, image_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $title, $brand, $model, $imagePath);
            $stmt->execute();

            // Check for errors during execution
            if ($stmt->error) {
                echo "Error: " . $stmt->error;
            } else {
                // Redirect to dashboard.php after successful insertion
                header("Location: dashboard.php");
                exit();
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error in preparing statement";
        }
    } else {
        // Handle the case where 'title', 'brand', or 'model' keys are not set
        echo "Error: 'title', 'brand', or 'model' keys not set in the form.";
        exit();
    }
}
?>
