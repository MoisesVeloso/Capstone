
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/formstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <title>Fill Up Form</title>
</head>
<body>
    <div class="container">
            <form action="fetchUserData.php" method="post" class="formContainer">
                <div class="form">

                    <?php if (isset($_GET['error'])) { ?>
                        <div class="error"><?php echo $_GET['error']; ?></div>
                    <?php } ?>
                    
                    
                    <h1 class="header">Fill Up Form</h1>
                    <label for="referenceNumber">Reference Number</label><br>
                    <input type="text" id="referenceNumber" name="referenceNumber" class="textbox" placeholder="Reference Number" required><br>


                    <?php
                $equipment = isset($_GET['brand']) ? $_GET['brand'] : '';
                echo '<input type="hidden" id="equipment" name="equipment" class="textbox" value="' . htmlspecialchars($equipment) . '" required>';
                ?>
                    <div class="buttonContainer">
                        <input type="submit" value="Submit" class="btn">
                    </div>
                </div>
            </form>
    </div>
   
    
</body>
</html>