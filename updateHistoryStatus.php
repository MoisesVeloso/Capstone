<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "resourcetracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return'])) {
    $referenceNumber = $_POST['reference_number'];
    
    $sql = "UPDATE form SET status = 'Returned' WHERE reference_number = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $referenceNumber);
        
        if ($stmt->execute()) {
            header("Location: history.php");
            exit();
        } else {
            echo "Error updating status: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error in preparing statement.";
    }
}

?>

