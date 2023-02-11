$(function (){

  (function () {
    'use strict'
    var forgot_password = document.querySelectorAll('#frm_forgot_password');
    var verify_code = document.querySelectorAll('#frm_verify_code');

    Array.prototype.slice.call(forgot_password)
    .forEach(function (form) {
        $('.btn_forgot_password').on('click', function(event){
          if (!forgot_password[0].checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          } else {
            $(this).prop("type", "submit");
          }
          form.classList.add('was-validated');
        })
    })
    Array.prototype.slice.call(verify_code)
    .forEach(function (form) {
        $('.btn_submit_code').on('click', function(event){
          if (!verify_code[0].checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          } else {
            $(this).prop("type", "submit");
          }
          form.classList.add('was-validated');
        })
    })
    
  })()

  $('#frm_forgot_password').submit(function (e){
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: 'model/LoginModel.php?action=sendCode',
      type: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      beforeSend: function () {
        Swal.fire({
          title: "Sending code...",
          html: "Please wait...",
          allowOutsideClick: false,
          allowEscapeKey: false,
          allowEnterKey: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
      },
      success: function (result){
        if(result == 'success'){

          Swal.fire({
            title: 'Code sent!',
            text: 'Please check your email for the code.',
            icon: 'success',
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
          }).then(function() {
            $('#forgotPassword').modal('hide');
            $('#verifyCode').modal({ backdrop: 'static', keyboard: false });
          });


        } else if(result == 'no email found'){

          Swal.fire({
            title: 'No email found',
            text: 'Please contact the admin to register your account.',
            icon: 'error',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 2500,
            timerProgressBar: true,
            width: 500,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            }
          })

        }
      }
    });
  });

  $('#frm_verify_code').submit(function (e){
    e.preventDefault();

    var data = $(this).serialize();
    $.ajax({
      url: 'model/LoginModel.php?action=verifyCode',
      type: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function (result){
        if(result == 'success'){
          
          Swal.fire({
            title: 'Password reset!',
            text: 'Please login with your default password.',
            icon: 'success',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 1500,
            timerProgressBar: true,
            width: 500,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            },
          }).then(function() {
            location.reload();
          });


        } else if(result == 'error'){

          Swal.fire({
            title: 'Invalid Code',
            text: 'Please check your email for the code.',
            icon: 'error',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 2500,
            timerProgressBar: true,
            width: 500,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            }
          })

        }
      }
    });

  });

  $('#frm_login').submit(function (e){
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: 'model/LoginModel.php?action=userLogin',
      type: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function (result){
        if (result == 'admin'){
          window.location.href = 'views/admin/dashboard.php';
        } else if(result == 'director'){
          window.location.href = 'views/admin/dashboard.php';
        } else if(result == 'user'){
          window.location.href = 'views/user/announcements.php';
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
          }).then(function() {
            location.reload();
          });
        } else if(result == 'no user found') {
          Swal.fire({
            title: 'No user found',
            text: 'Please contact the admin to register your account.',
            icon: 'error',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 1500,
            timerProgressBar: true,
            width: 500,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            }
          }).then(function() {
            location.reload();
          });
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
         location.reload();
        }
      }
    });
  });

});