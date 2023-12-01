<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/addItem.css">
    <link href="https://fonts.googleapis.com/css2?family=Mooli&display=swap" rel="stylesheet">
    <title>Add Equipment</title>
</head>
<body>
    <div class="container"> <!-- Add Item -->
        <h1>Add Item</h1>

        <div class="form-container">
            <form action="addEquipment.php" method="post" enctype="multipart/form-data">
                <div class="form">
                    <label for="brand">Label</label><br>
                    <input type="text" id="equipment" name="equipment" required><br>

                    <label for="type">Type:</label><br>
                    <input type="text" id="type" name="type" required><br>

                    <label for="image">Image:</label><br>
                    <input type="file" id="image" name="image" accept="image/*" required><br>

                    <div class="addBtn">
                        <button type="submit" class="btn">Add Item</button>
                    </div>
                </div>
            </form>
        </div>  
    </div>
</body>
</html>
