
$(function() {

  $('.new_password, .update_new_password').PassRequirements();

  $('.show_password').on('click', function(){
    var pwd1 = $('.new_password, .confirm_new_password').prop('type');
    if (pwd1 === "password") {
      $('.new_password, .confirm_new_password').prop('type', 'text');
    } else {
      $('.new_password, .confirm_new_password').prop('type', 'password');
    }
  });
  $('.show_change_password').on('click', function(){
    var pwd2 = $('.update_new_password, .update_current_password, .update_confirm_password').prop('type');
    if (pwd2 === "password") {
      $('.update_new_password, .update_current_password, .update_confirm_password').prop('type', 'text');
    } else {
      $('.update_new_password, .update_current_password, .update_confirm_password').prop('type', 'password');
    }
  });

  (function () {
    'use strict'
    var forms = document.querySelectorAll('.frm_new_password');
    var change_password = document.querySelectorAll('#frm_change_password');
  
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
    Array.prototype.slice.call(change_password)
      .forEach(function (form) {
          $('.btn-change-password').on('click', function(event){
            if (!change_password[0].checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
              checkCurrentPass();
              confirmChangePass();
              newChangePass();
            } else if (checkCurrentPass()){

            } else if (confirmChangePass()){

            } else if (newChangePass()){

            } else if (changePass()){
             
            }
            form.classList.add('was-validated');
          })
      })
  })()

  $('.frm_new_password').on('submit', function (event) {
    event.preventDefault();
    $.ajax({
      url: '../../model/PasswordModel.php?action=updatePassword',
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

  function changePass(){

    return $.ajax({
      url: '../../model/PasswordModel.php?action=changePassword',
      type: 'POST',
      data: new FormData($('#frm_change_password')[0]),
      contentType: false,
      processData: false,
      cache: false,
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

          return false;

        } else if(result == 'error'){
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
          });

          return true;
        } else if(result == 'wrong password'){
          Swal.fire({
            icon: 'error',
            title: 'Invalid current password',
            text: 'Please enter your current password correctly.',
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
          });

          return true;
        }
      }
    })
  }

  $('.new_password').keyup(function(){

    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#_\$%\^&\*])(?=.{8,})");
    var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
    var pass = $('.new_password').val();
    
    if(strongRegex.test(pass)==true){
      $('.passres').html("Strong password").css('color', '#28a745');
    }else if(mediumRegex.test(pass)==true){
      $('.passres').html("Weak password").css('color', '#dc3545');
    }else if(pass!=""){
      $('.passres').html("Very weak password").css('color', '#dc3545');
    }else{
      $('.passres').html("").css('color', '');
    }
  })
  $('.update_new_password').keyup(function(){

    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#_\$%\^&\*])(?=.{8,})");
    var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
    var pass = $('.update_new_password').val();
    
    if(strongRegex.test(pass)==true){
      $('.passres2').html("Strong password").css('color', '#28a745');
    }else if(mediumRegex.test(pass)==true){
      $('.passres2').html("Weak password").css('color', '#dc3545');
    }else if(pass!=""){
      $('.passres2').html("Very weak password").css('color', '#dc3545');
    }else{
      $('.passres2').html("").css('color', '');
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
  function newChangePass(){
    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#_\$%\^&\*])(?=.{8,})");
    var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
    var pass = $('.update_new_password').val();
    
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
  function confirmChangePass(){
    if(($('.update_new_password').val() == '') || ($('.update_confirm_password').val() == '')){
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
    }else if ($('.update_new_password').val()!=$('.update_confirm_password').val()){
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

  function checkCurrentPass(){
    var pass = $('.update_current_password').val();

    if (pass==""){
      Swal.fire({
        icon: 'error',
        title: 'Enter current password',
        text: 'Please enter your current password.',
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
      });

      return true;
    } 
  }

});