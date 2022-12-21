$(function() {

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
  
});