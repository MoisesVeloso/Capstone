<?php
include('phpqrcode/qrlib.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['brand'])) {
    $equipment = $_POST['brand'];

    $qrCodeData = "Equipment: $equipment, Link: 192.168.89.100/Capstone/form.php?brand=$equipment";

    $filename = 'qrcodes/' . uniqid('qr_') . '.png';

    QRcode::png($qrCodeData, $filename);

    header("Location: dashboard.php?qr_image=$filename");
    exit;
} else {
    echo "Error";
}
?>