<?php
// Retrieve the selected type from the AJAX request
if (isset($_GET['type'])) {
    $selectedType = $_GET['type'];

    // Fetch equipment items based on the selected type
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ResourceTracking";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT * FROM equipment WHERE type = '$selectedType'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Output each equipment item as needed
            echo '<div class="grid-item">';
            echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="Equipment Image" class="img-container">';
            echo '<div class="itemText">';
            echo '<p>' . htmlspecialchars($row['equipment']) . '</p>';
            // Add more information as required
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No items found.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
