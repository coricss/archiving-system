$(function() {
  $('.sidebar-overlay').on('click', function() {
    $('body').removeClass('sidebar-open');
    $('body').addClass('sidebar-closed sidebar-collapse');
  });

  setInterval(() => {
    $('.date').html(new Date().toDateString());
    $('.clock').html(new Date().toLocaleTimeString());
  }, 500);

  $('#img_user').click (function() { 
    $('#file_picture').trigger('click');
  });

  $('#img_edit_user').click (function() {
    $('#file_edit_picture').trigger('click');
  });

  $('#file_picture').change(function() {
    var file = this.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#img_user').attr('src', e.target.result);
    }

    reader.readAsDataURL(file);
  });

  $('#file_edit_picture').change(function() {
    var file = this.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#img_edit_user').attr('src', e.target.result);
    }

    reader.readAsDataURL(file);
  });
  
  $('#btn-messenger').click(function(e){
    e.preventDefault();

    $('.fb-page-box').toggle();
  });

  var mouse_is_inside = false;

  $('.fb-page-box, #btn-messenger').hover(function(){ 
    mouse_is_inside=true; 
  }, function(){ 
      mouse_is_inside=false; 
  });

  $('body').mouseup(function(){ 
      if(! mouse_is_inside) {
      $('.fb-page-box').hide();
      }
  });

});