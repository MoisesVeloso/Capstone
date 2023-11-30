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
    <link rel="stylesheet" href="stylesheet/table.css">
    <link href="https://fonts.googleapis.com/css2?family=Mooli&display=swap" rel="stylesheet">
    <style>
        .sidenav {
            background-color: <?php echo $dashboardColor; ?>;
        }
    </style>
    <title>History</title>
</head>
<body> <!-- History -->
    <div class="sidenav">
        <h1 class="header">Smart Borrowing System</h1>
        <li class="links">
            <a href="dashboard.php">Dashboard</a>
            <a href="history.php" class="active">History</a>
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

    <div class="table">
        <h1 class="contentHeader">History</h1>

        <table class="datatable">
            <tr>
                <th>Name</th>
                <th>Student Number</th>
                <th>Section</th>
                <th>Equipment</th>
                <th>Date & Time</th>
                <th>Reference Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "resourcetracking";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT fullname, year_section, studentNo, equipment, time, DATE_FORMAT(time, '%Y-%m-%d  %h:%i %p') as formatted_time, reference_number, status, action FROM form WHERE department = '$department'";
        $result = $conn->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='tableData'>" . $row['fullname'] . "</td>";
                echo "<td class='tableData'>" . $row['studentNo'] . "</td>";
                echo "<td class='tableData'>" . $row['year_section'] . "</td>";
                echo "<td class='tableData'>" . $row['equipment'] . "</td>";
                echo "<td class='time-cell'>" . $row['time'] . "</td>";
                echo "<td class='time-cell'>" . $row['reference_number'] . "</td>";
                echo "<td class='tableData'>" . $row['status'] . "</td>";
                echo "<td class='tableData'>";
                
                if ($row['status'] !== 'Returned') {
                    echo "<form method='post' action='updateHistoryStatus.php'>
                            <input type='hidden' name='reference_number' value='" . $row['reference_number'] . "'>
                            <button type='submit' class='updateStatusBtn' name='return' value='Returned Item'>Return</button>
                          </form>";
                } else {
                    echo "<button class='updateStatusBtn' disabled>Return</button>";
                }
        
                echo "</td>";
                echo "</tr>";
            }
        
            echo "</table>";
        } else {
            echo "<tr><td colspan='8' class='no-record'>No records found</td></tr>";
        }

        $conn->close();
        ?>
        </table>
    </div>
</body>
</html>