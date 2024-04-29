var logoutBtn = document.getElementById('logoutBtn');
logoutBtn.addEventListener('click', function() {
  document.location.href = 'index.php?page=login&action=logout';
});

var regBtn = document.getElementById('regBtn');
regBtn.addEventListener('click', function() {
  document.location.href = 'index.php?page=register';
});