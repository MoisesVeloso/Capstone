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

        <?php
        // Establish a database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ResourceTracking";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Query to get unique equipment types based on the user's department
        $sql = "SELECT DISTINCT type FROM equipment WHERE department = '$department'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="equipment-types">';
            while ($row = $result->fetch_assoc()) {
                $equipmentType = $row['type'];
                echo '<a href="dashboard.php?type=' . $equipmentType . '" class="type-button">' . $equipmentType . '</a>';
            }
            echo '</div>';
        }
        
        // Close the database connection
        $conn->close();
        ?>

        <div class="grid">
            <?php
            
            if (isset($_GET['type'])) {
                $selectedType = $_GET['type'];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "ResourceTracking";

                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                // Query to get equipment of the selected type based on the user's department
                $sql = "SELECT * FROM equipment WHERE department = '$department' AND type = '$selectedType'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="grid-item">';
                        echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="Equipment Image" class="img-container">';
                        echo '<div class="itemText">';
                        echo '<p>' . htmlspecialchars($row['brand']) . '</p>';
                        
                        echo '<form action="qrcodetesting.php" method="post">';
                        echo '<input type="hidden" name="brand" value="' . htmlspecialchars($row['brand']) . '">';
                        echo '<button type="submit" class="qrbutton" style="background-color: #066809; border-radius: 10px; color: white; height: 40px; width: 150px; margin-top: 10px">Generate QR Code</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    }
                }

                // Close the database connection
                $conn->close();
            }
            ?>

        

        <div class="addbtn">
            <a href="additem.php"><input type="button" class="btn" value="Add Equipment"></a>
        </div>

    </div>
    
</body>
</html>
