<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "ResourceTracking";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = sanitizeInput($_POST['username']);
$password = sanitizeInput($_POST['password']);

$sql = "SELECT * FROM usertable WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {

    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];
    $department = $row['department'];

    if (password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        $_SESSION['department'] = $department;

        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: index.php?error=Invalid username or password");
        exit();
    }
} else {
    header("Location: index.php?error=Invalid username or password");
    exit();
}

$stmt->close();
$conn->close();

function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}
?>