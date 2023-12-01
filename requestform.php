<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/formstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <title>Request Form</title>
</head>
<body>
    <div class="container">
            <form action="insert-request-testing.php" method="post" class="formContainer">
                <div class="form">
                    <h1 class="header">Request Form</h1>

                    <label for="studentNo">Student No.</label><br>
                    <input type="text" id="studentNo" name="studentNo" class="textbox" placeholder="Student Number" required><br>

                    <label for="fullname">Full Name</label><br>
                    <input type="text" id="fullname" name="fullname" class="textbox" placeholder="Full Name" required><br>
            
                    <label for="year-section">Year Level and Section</label><br>
                    <input type="text" id="year-section" name="year-section" class="textbox" placeholder="Year Level & Section" required><br>

                    <label for="department">Department:</label> <br>
                    <select name="department" id="department" class="textbox" required>
                    <option value="" disabled selected>Select Department</option>
                        <option value="CET">CET</option>
                        <option value="CAS">CAS</option>
                        <option value="CCJ">CCJ</option>
                        <option value="CBA">CBA</option>
                        <option value="CHS">CHS</option>
                    </select>

                    <label for="equipment">Equipment</label><br>
                    <select name="equipment" id="equipment" class="textbox" required>
                         <option value="" disabled selected>Select Equipment</option>
                    </select>

                            <script>
                                const departmentDropdown = document.getElementById("department");
                                const equipmentDropdown = document.getElementById("equipment");

                                departmentDropdown.addEventListener("change", function () {
                                    const selectedDepartment = departmentDropdown.value;

                                    fetch(`getEquipmentOptions.php?department=${selectedDepartment}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            equipmentDropdown.innerHTML = '<option value="" disabled selected>Select Equipment</option>';

                                            data.forEach(equipmentOption => {
                                                const option = document.createElement("option");
                                                option.value = equipmentOption;
                                                option.text = equipmentOption;
                                                equipmentDropdown.appendChild(option);
                                            });
                                        });
                                });
                            </script>
            
                    <div class="buttonContainer">
                        <input type="submit" value="Submit" class="btn">
                    </div>

                    <div class="reference-search">
                        <a href="requestStatus.php" class="link">Search Request</a>
                            </div>
                </div>
            </form>
    </div>
   
    
</body>
</html>