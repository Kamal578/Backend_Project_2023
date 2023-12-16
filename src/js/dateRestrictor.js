document.addEventListener("DOMContentLoaded", function() {
  var currentDate = new Date().toISOString().split('T')[0];
  document.getElementById("date").max = currentDate;
});
