document.getElementById('cookie-accept').addEventListener('click', function() {
  document.getElementById('cookie-widget').style.display = 'none';
  localStorage.setItem('cookieAccepted', 'true');
});

window.addEventListener('load', function() {
  if (localStorage.getItem('cookieAccepted') === 'true') {
    document.getElementById('cookie-widget').style.display = 'none';
  }
});