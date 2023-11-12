<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/lookrequest.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <title>Request Finder</title>
</head>
<body>
    <div class="container">
        <h1 class="header">Check your Request</h1>
        <p class="description">Please enter your reference number to check your request status</p>
        <form action="searchRequest.php" method="POST">
            <input type="text" id="reference-number" name="reference-number" placeholder="Reference Number" required>
            <input type="submit" value="Search">
            <?php if (isset($_GET['error'])) { ?>
                <div class="error"><?php echo $_GET['error']; ?></div>
            <?php } ?>
        </form>
    </div>
</body>
</html>