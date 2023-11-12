<?php
session_start();

$department = isset($_SESSION['department']) ? $_SESSION['department'] : "default";

$departmentColors = [
    "CET" => "#E9B824",
    "CBA" => "#F4E869",
    "CHS" => "#3085C3",
    "CAS" => "#9EDDFF",
    "CCJ" => "#FF6969",
    "default" => "white",
];


$dashboardColor = isset($departmentColors[$department]) ? $departmentColors[$department] : $departmentColors["default"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/sidenav.css">
    <link rel="stylesheet" href="stylesheet/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Mooli&display=swap" rel="stylesheet">
    <style>
        .sidenav {
            background-color: <?php echo $dashboardColor; ?>;
        }
    </style>
    <title>Dashboard</title>
</head>
<body>
    <div class="sidenav">
        <h1 class="header">Smart Borrowing System</h1>
        <li class="links">
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="history.php">History</a>
            <a href="request.php">Request</a>
        </li>
        
        <div class="btnContainer">
            <button class="logoutBtn" id="logout" type="button">Logout</button>
        </div>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <h3 class="headerContent">Logout</h3>
                <p class="content">Are you sure?</p>
                <div class="modalBtn">
                    <form method="post" action="logout.php">
                        <button onclick="location.href='index.php'" class="ybtn logoutButton">Yes</button>
                    </form>
                        <button class="nbtn logoutButton">No</button>
                </div>
            </div>
        </div>

      <script src="Javascript/logoutFunction.js"></script>  
      <script src="Javascript/active.js"></script>

    </div>

    <div class="dashboard"> <!-- Dashboard -->
        <h1 class="dashboardHeader">Dashboard</h1>

        <div class="grid">
        <?php

        include 'fetchItems.php';

            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "resourceTracking";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            $sql = "SELECT DISTINCT type FROM equipment WHERE department = '$department'";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $type = $row['type'];

                $imagePath = fetchImagePathForType($type);

                echo '<div class="grid-item grid-item-clickable" data-type=""' . htmlspecialchars($type) . '">';
                echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Equipment Image" class="img-container">';
                echo '<div class="itemText">';
                echo "<p>$type</p>";
                echo '</div>';
                echo '</div>';
            }

            $conn->close();
            ?>

            <div class="grid" id="grid"></div>
            <div class="item-list" style="display: none;" id="item-list"></div>


            <script src="Javascript/displayItems.js"></script>
        </div>


        <div class="addbtn">
            <a href="additem.php"><input type="button" class="btn" value="Add Equipment"></a>
        </div>
    </div>
</body>
</html>
