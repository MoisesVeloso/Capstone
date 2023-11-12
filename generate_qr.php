<?php
include('phpqrcode/qrlib.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ResourceTracking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['model']) && isset($_POST['brand'])) {
    $brand = $_POST['brand'];

    $qrCodeData = "192.168.1.17/Capstone/form.html";
    

    $filename = 'qrcodes/' . uniqid('qr_') . '.png';

   
    QRcode::png($qrCodeData, $filename);

    header("Location: dashboard.php?qr_image=$filename");
    exit;
} else {

    echo "Errro";
}
?>
