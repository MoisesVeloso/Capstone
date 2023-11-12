<?php
include('phpqrcode/qrlib.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['brand'])) {
    $brand = $_POST['brand'];

    $qrCodeData = "Brand: $brand, Link: 172.20.10.2/Capstone/form.html";

    $filename = 'qrcodes/' . uniqid('qr_') . '.png';

    QRcode::png($qrCodeData, $filename);

    header("Location: dashboard.php?qr_image=$filename");
    exit;
} else {
    echo "Error";
}
?>
