
$(function() {

  $('.new_password').passwordRequirements();

  $('.show_password').on('click', function(){
    var pwd1 = document.getElementById("new_password");
    var pwd2 = document.getElementById("confirm_new_password");
    if (pwd1.type === "password"&&pwd2.type === "password") {
      pwd1.type = "text";
      pwd2.type = "text";
    } else {
      pwd1.type = "password";
      pwd2.type = "password";
    }
  });

  (function () {
    'use strict'
    var forms = document.querySelectorAll('.frm_new_password');

    Array.prototype.slice.call(forms)
      .forEach(function (form) {
          $('.btn_new_password').on('click', function(event){
            if (!forms[0].checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
              newPass();
              confirmPass();
            } else if (confirmPass()){

            } else if (newPass()){

            }else{
              $(this).prop("type", "submit");
            }
            form.classList.add('was-validated');
          })
      })
  })()

  $('.frm_new_password').on('submit', function (event) {
    event.preventDefault();
    $.ajax({
      url: '../../model/PasswordModel.php?action=updateAdminPassword',
      type: 'POST',
      data: $(this).serialize(),
      success: function (result){
        if (result == 'success'){
          Swal.fire({
            title: 'Password Updated!',
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
            window.location.reload();
          });
        } else {
          Swal.fire({
            title: 'Error!',
            text: 'Something went wrong!',
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
          }).then(function() {
            window.location.reload();
          });
        }
      }
    })
  })

  $('.new_password').keyup(function(){

    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#_\$%\^&\*])(?=.{8,})");
    var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
    var pass = $('#new_password').val();
    
    if(strongRegex.test(pass)==true){
      $('.passres').html("Strong password");
      $('.passres').css('color', '#28a745');
    }else if(mediumRegex.test(pass)==true){
      $('.passres').html("Weak password");
      $('.passres').css('color', '#dc3545');
    }else if(pass!=""){
      $('.passres').html("Very weak password");
      $('.passres').css('color', '#dc3545');
    }else{
      $('.passres').html("");
      $('.passres').css('color', '');
    }
  })

  function newPass(){
    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#_\$%\^&\*])(?=.{8,})");
    var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
    var pass = $('.new_password').val();
    
    if(strongRegex.test(pass)==true){
      return false;
    }else if(mediumRegex.test(pass)==true){
      Swal.fire({
        icon: 'error',
        title: 'Weak Password',
        text: 'Please complete password requirements.',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        width: 450,
        timerProgressBar: true,
        iconColor: 'white',
        customClass: {
          popup: 'colored-toast'
        }
      })
      return true;
    } else if(pass!="") {
      Swal.fire({
        icon: 'error',
        title: 'Weak Password',
        text: 'Please complete password requirements.',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        width: 450,
        timerProgressBar: true,
        iconColor: 'white',
        customClass: {
          popup: 'colored-toast'
        }
      })
      return true;
    } else {
      return true;
    }
  }

  function confirmPass(){
    if(($('.new_password').val() == '') || ($('.confirm_new_password').val() == '')){
      Swal.fire({
        icon: 'error',
        title: 'Enter password properly',
        text: 'Please enter password and try again.',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        width: 450,
        timerProgressBar: true,
        iconColor: 'white',
        customClass: {
          popup: 'colored-toast'
        }
      })
      return true;
    }else if ($('.new_password').val()!=$('.confirm_new_password').val()){
      Swal.fire({
        icon: 'error',
        title: 'Passwords Do Not Match',
        text: 'Please confirm password and try again.',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        width: 450,
        timerProgressBar: true,
        iconColor: 'white',
        customClass: {
          popup: 'colored-toast'
        }
      })
      return true;
    } else {
      return false;
    }
  }

});