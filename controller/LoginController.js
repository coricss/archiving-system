$(function (){
  $('#frm_login').submit(function (e){
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: 'model/LoginModel.php?action=userLogin',
      type: 'POST',
      data: data,
      success: function (result){
        if (result == 'admin'){
          Swal.fire({
            title: 'Welcome Admin!',
            icon: 'success',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 1500,
            timerProgressBar: true,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            },
          }).then(function() {
            window.location.href = 'views/admin/dashboard.php';
          });
        } else if(result == 'user'){
          Swal.fire({
            title: 'Welcome User!',
            icon: 'success',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 1500,
            timerProgressBar: true,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            },
          }).then(function() {
            window.location.href = 'views/user/dashboard.php';
          });
        } else if(result == 'locked') {
          Swal.fire({
            title: 'Your account is deactivated!',
            text: 'Please contact the admin to reset your password.',
            icon: 'error',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            width: 500,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            },
          })
        } else {
          Swal.fire({
            title: 'Invalid Username or Password',
            icon: 'error',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 1500,
            timerProgressBar: true,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            },
          });
          var data = JSON.parse(result);
         
          $('.login-box-msg').html('You have '+ data.attempts +' attempt(s) remaining').css('color', 'red');
         
        }
        
      }
    });
  });

  $('.logout').click(function (e){
    e.preventDefault();
    $.ajax({
      url: '../../model/LoginModel.php?action=logoutUser',
      type: 'GET',
      success: function (result){
        if (result == 'success'){
          window.location.href = '/digital_archiving_management_system/views/admin/';
        }
      }
    });
  });

});