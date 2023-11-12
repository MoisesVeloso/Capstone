<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/login.css">
    <title>Login</title>
</head>
<body>
    
    <div class="container"> <!-- Login -->
        <a href="collegeDept.html" class="udmBtn"><img class="image" src="image/udmlogo.jpg"></img></a>
        <h1 class="header">Login</h1>
        <form action="login.php" class="form" method="post">

            <?php if (isset($_GET['error'])) { ?>
                <div class="error"><?php echo $_GET['error']; ?></div>
            <?php } ?>

            <div class="form_input">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
    
                <div class="form_input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
    
                <div class="loginBtn">
                <button type="submit" class="btn">Login</button>
                </div>

                <div class="request-form">
                    <a href="requestform.php" class="reqEp">Request Equipment?</a>
                </div>
                
        </form>
    </div>
</body>
</html>