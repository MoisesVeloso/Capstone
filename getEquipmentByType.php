<div class="grid-equipment">

<link rel="stylesheet" href="stylesheet/dashboard.css">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ResourceTracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['type']) && isset($_GET['department'])) {
    $type = $_GET['type'];
    $department = $_GET['department'];

    $sql = "SELECT * FROM equipment WHERE type = '$type' AND department = '$department'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 

            $equipmentName = htmlspecialchars($row['equipment']);
            

            echo '<div class="grid-item-row">';
            echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="Equipment Image" class="img-container-equipment">';
            echo '<div class="itemText">';
            echo '<p> ' . $equipmentName . '</p>';
        
            $statusSql = "SELECT status FROM form WHERE equipment = '$equipmentName'";
            $statusResult = $conn->query($statusSql);

            if ($statusResult->num_rows > 0) {
                $statusRow = $statusResult->fetch_assoc();
                $status = htmlspecialchars($statusRow['status']);

                if ($status === 'Currently in use') {
                    echo '<p>' . $status . '</p>';
                } else {
                    echo '<p></p>';
                }
            } else {
                echo '<p></p>';
            }
            

            echo '<form action="qrcode.php" method="post">';
            echo '<input type="hidden" name="brand" value="' . $equipmentName . '">';
            echo '<button type="submit" class="qrbutton" style="background-color: #066809; border-radius: 10px; color: white; height: 40px; width: 150px; margin-top: 10px">Generate QR Code</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No equipment found for this type and department.";
    }
} else {
    echo "Type or department parameter is missing.";
}

$conn->close();
?>
</div>