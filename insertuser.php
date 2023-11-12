<?php
// Database connection details
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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password for security
    $department = $_POST["department"];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO userTable (username, password, department) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $department);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
