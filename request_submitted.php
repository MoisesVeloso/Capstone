<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/request-submitted.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <title>Request Submit</title>
</head>
<body>
    <div class="container">
        <h1 class="header">Request Submitted</h1>
        <?php
        if (isset($_GET['ref'])) {
            $referenceNumber = $_GET['ref'];
            echo "<p class='description'>Your reference number is:<span> $referenceNumber </span></p>";
        }
        ?>
        <div class="btn">
        <button id="copybtn" onclick="copyReference()">Copy Reference Number</button>

        <div class="btnlink">
        <a href="requeststatus.php">Check your Status</a>
        </div>
    </div>
    </div>
    <script>
        function copyReference() {
            var referenceNumber = "<?php echo $referenceNumber; ?>";
            var copyText = document.createElement("input");
            document.body.appendChild(copyText);
            copyText.value = referenceNumber;
            copyText.select();
            document.execCommand("copy");
            document.body.removeChild(copyText);
            
            var copyButton = document.getElementById("copybtn");
            copyButton.textContent = "Copied";
        }
    </script>

</body>
</html>
