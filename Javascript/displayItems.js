function loadEquipmentItems(type) {
    // AJAX request to fetch equipment items for the selected type
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("equipment-items").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "fetchEquipmentItems.php?type=" + type, true);
    xhttp.send();
}
