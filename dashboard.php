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
            <a href="request.php">Request <span id="noti_number" class="noti_number"></span></a>
            <script type="text/javascript">
                        function loadDoc() {

                        setInterval(function(){

                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("noti_number").innerHTML = this.responseText;
                            }
                        };
                        xhttp.open("GET", "data.php", true);
                        xhttp.send();

                        },1000);


                        }
                        loadDoc();
                    </script>
        
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
    <script src="Javascript/notifcation.js"></script>
    <script src="Javascript/logoutFunction.js"></script>  
    <script src="Javascript/active.js"></script>

    </div>

    <div class="dashboard"> <!-- Dashboard -->
        <h1 class="dashboardHeader">Dashboard</h1>

        <div class="grid">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ResourceTracking";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DISTINCT type FROM equipment WHERE department = '$department'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $type = $row['type'];

        $sqlExample = "SELECT * FROM equipment WHERE department = '$department' AND type = '$type' LIMIT 1";
        $resultExample = $conn->query($sqlExample);

        if ($rowExample = $resultExample->fetch_assoc()) {
            echo '<div class="grid-item" onclick="fetchEquipment(\'' . htmlspecialchars($rowExample['type']) . '\')">';
            echo '<img src="' . htmlspecialchars($rowExample['image_path']) . '" alt="Equipment Image" class="img-container">';
            echo '<div class="itemText">';
            echo '<p> ' . htmlspecialchars($rowExample['type']) . '</p>';

            echo '</div>';
            echo '</div>';
        }
    }
    $conn->close();
    ?>
</div>

<div id="equipmentContainer">
    
</div>

<script>
function fetchEquipment(type) {
                const department = '<?php echo $department; ?>';

                // Hide the grid items
                const gridItems = document.querySelectorAll('.grid-item');
                gridItems.forEach(item => {
                    item.style.display = 'none';
                });

                const addBtn = document.querySelector('.addbtn');
                addBtn.style.display = 'none';

                fetch(`getEquipmentByType.php?type=${type}&department=${department}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('equipmentContainer').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error fetching equipment:', error);
                    });
            }
        </script>

<div class="addbtn">
        <a href="additem.php"><input type="button" class="btn" value="Add Equipment"></a>
    </div>
   
</div>
</body>
</html>