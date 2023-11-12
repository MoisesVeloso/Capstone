<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "resourcetracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $yearSection = $_POST['year-section'];
    $studentNo = $_POST['studentNo'];
    $department = $_POST['department'];
    $equipment = $_POST['equipment'];

    // Extract equipment data from QR code data
    $qrCodeData = $_POST['qrcode']; // Assuming 'qrcode' is the name of the input field

    // Parse the QR code data to extract equipment details (e.g., brand)
    $brand = ''; // Initialize variables for equipment data

    // Split the QR code data by a delimiter (e.g., comma) to separate values
    $qrCodeParts = explode(',', $qrCodeData);

    // Iterate through the parts to extract equipment information and add debugging
    foreach ($qrCodeParts as $part) {
        $part = trim($part);
        list($key, $value) = explode(':', $part);
        $key = trim($key);
        $value = trim($value);

        if ($key == 'Brand') {
            $brand = $value;
            echo "Extracted Brand: $brand"; // Debugging: Display the extracted brand
        }
    }

    // After the loop, check the extracted value
    echo "Final Brand: $brand"; // Debugging: Display the final extracted brand

    // ... Continue with the rest of your code for database insertion ...
}
?>
