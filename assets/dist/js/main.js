$(function() {
  setInterval(() => {
    $('.date').html(new Date().toDateString());
    $('.clock').html(new Date().toLocaleTimeString());
  }, 500);
});