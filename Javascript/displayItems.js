function displayItemsByType(selectedType) {
    fetch(`fetchItems.php?type=${selectedType}`)
        .then((response) => response.json())
        .then((data) => {
            // Process the retrieved items and display them in the desired format
            // Replace this with your actual logic to display items
            console.log(data); // You can inspect the data in the console
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}