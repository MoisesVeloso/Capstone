
var modal = document.getElementById("myModal");
var btn = document.getElementById("logout");
var span = document.getElementsByClassName("nbtn")[0];

btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function logout() {
  window.location.href = "logout.php";
}