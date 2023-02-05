$(function(){

    
  loadProfile();
  loadTheme();

  $(document).keypress(
    function(event){
      if (event.which == '13') {
        event.preventDefault();
      }
  });

  $('#btn_deactivate_profile').click(function(){
    Swal.fire({
      title: 'Are you sure?',
      text: "You want to deactivate this account?",
      icon: 'warning',
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Deactivate'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '../../model/ProfileModel.php?action=deactivateProfile',
          type: 'POST',
          success: function(result){
            if (result == 'success'){
              Swal.fire({
                title: 'Deactivated!',
                icon: 'success',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                iconColor: 'white',
                customClass: {
                  popup: 'colored-toast'
                }
              }).then(() => {
                loadProfile();
              });
            } else {
              Swal.fire({
                title: 'Somtehing went wrong!',
                icon: 'error',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                iconColor: 'white',
                customClass: {
                  popup: 'colored-toast'
                }
              })
            }
          }
        });
      }
    });
  });

  $('#btn_activate_profile').click(function(){
    Swal.fire({
      title: 'Are you sure?',
      text: "You want to activate this account?",
      icon: 'warning',
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Activate'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '../../model/ProfileModel.php?action=activateProfile',
          type: 'POST',
          success: function(result){
            if (result == 'success'){
              Swal.fire({
                title: 'Activated!',
                icon: 'success',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                iconColor: 'white',
                customClass: {
                  popup: 'colored-toast'
                }
              }).then(() => {
                loadProfile();
              });
            } else {
              Swal.fire({
                title: 'Somtehing went wrong!',
                icon: 'error',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                iconColor: 'white',
                customClass: {
                  popup: 'colored-toast'
                }
              })
            }
          }
        });
      }
    });
  });
  
  function loadProfile(){
    $.ajax({
      url: '../../model/ProfileModel.php?action=loadProfile',
      type: 'GET',
      dataType: 'json',
      cache: false,
      beforeSend: function(){
        $('.profile-name, .profile-username, .profile-userid, .profile-email, .profile-phone, .profile-address, .profile-date-added').html('<div class="spinner-border spinner-border-sm text-success" role="status"></div>');
      },
      success: function(data){
        setTimeout(function(){
          $('.display-picture').attr('src', '../../assets/dist/img/users/'+data.picture);
          $('.profile-username').html(data.username);
          $('.profile-name').html(data.first_name+' '+data.middle_name+' '+data.last_name);
          $('.profile-userid').html(data.user_id);
          $('.profile-email').html(data.email);
          $('.profile-phone').html(data.phone);
          $('.profile-address').html(data.address);
          $('.profile-date-added').html(
            new Date(data.date_added).toLocaleDateString('en-US', {year: 'numeric', month: 'short', day: 'numeric'})
          );
          $('#btn_activate_profile').css('display', data.status == 1 ? 'none' : 'block');
          $('#btn_deactivate_profile').css('display', data.status == 0 ? 'none' : 'block');

          //EDIT FORM
          $('#edit_first_name').val(data.first_name);
          $('#edit_middle_name').val(data.middle_name);
          $('#edit_last_name').val(data.last_name);
          $('#edit_username').val(data.username);
          $('#edit_email').val(data.email);
          $('#edit_phone').val(data.phone);
          $('#edit_address').val(data.address);

        }, 300);
      }
    });
  }

  //EDIT PROFILE
  $('#profile-user-img').on('click', function(){
    $('#profile-picture').trigger('click');
  });

  $('#profile-picture').on('change', function(){

    var file = this.files[0];

    var reader = new FileReader();
    reader.onload = function(e){
      $('.display-picture').attr('src', e.target.result);
    }
    reader.readAsDataURL(file);


    $.ajax({
      url: '../../model/ProfileModel.php?action=updatePicture',
      type: 'POST',
      data: new FormData($('#upload-picture-form')[0]),
      contentType: false,
      cache: false,
      processData: false,
      success: function(result){
        if(result == 'success'){
          Swal.fire({
            title: 'User photo was updated!',
            icon: 'success',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 1500,
            timerProgressBar: true,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            }
          });
        } else {
          Swal.fire({
            title: 'Something went wrong!',
            icon: 'error',
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timer: 1500,
            timerProgressBar: true,
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            }
          });
        }
      }

    });
  });

  (function () {
    'use strict'
    var edit_profile = document.querySelectorAll('#frm_edit_profile');
    var current_password = document.querySelectorAll('#frm_current_password');


    Array.prototype.slice.call(edit_profile)
      .forEach(function (form) {
          $('.btn-update-details').on('click', function(event){
            if (!edit_profile[0].checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            } else if(checkUserIfExists()){
              
            }
            form.classList.add('was-validated');
          })
      })

    Array.prototype.slice.call(current_password)
      .forEach(function (form) {
          $('.btn-current-password').on('click', function(event){
            if (!current_password[0].checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
              
            } else if(checkCurrentPassword()){
             
            }
            form.classList.add('was-validated');
          })
      })

      function checkUserIfExists() {

        $.ajax({
          url: '../../model/ProfileModel.php?action=checkUserIfExists',
          type: 'POST',
          data: $('#frm_edit_profile').serialize(),
          success: function(result){
            if (result == 'user_exists'){

              Swal.fire({
                title: 'User already exists!',
                icon: 'error',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                iconColor: 'white',
                customClass: {
                  popup: 'colored-toast'
                }
              });

              return true;

            } else if(result == 'username_exists'){
              Swal.fire({
                title: 'Username already exists!',
                icon: 'error',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                iconColor: 'white',
                customClass: {
                  popup: 'colored-toast'
                }
              });

              return true;

            } else if(result == 'email_exists'){
              Swal.fire({
                title: 'Email already exists!',
                icon: 'error',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
                iconColor: 'white',
                customClass: {
                  popup: 'colored-toast'
                }
              });

              return true;

            } else {

              $('#frm_current_password').parents('.modal').modal({backdrop: 'static', keyboard: false});

              return false;
            }
          }
        });

      }

      function checkCurrentPassword(){

       return $.ajax({
          url: '../../model/ProfileModel.php?action=checkCurrentPassword',
          type: 'POST',
          data: new FormData($('#frm_current_password')[0]),
          contentType: false,
          processData: false,
          cache: false,
          success: function(result){
            if (result == 'success'){
             
              $.ajax({
                url: '../../model/ProfileModel.php?action=updateProfile',
                type: 'POST',
                data: new FormData($('#frm_edit_profile')[0]),
                contentType: false,
                processData: false,
                cache: false,
                success: function(result){
                  if (result == 'success'){
                    Swal.fire({
                      title: 'Profile updated!',
                      icon: 'success',
                      showConfirmButton: false,
                      toast: true,
                      position: 'top-end',
                      timer: 1500,
                      timerProgressBar: true,
                      iconColor: 'white',
                      customClass: {
                        popup: 'colored-toast'
                      }
                    }).then(() => {
                      location.reload();
                    });
                  } else {  
                    Swal.fire({
                      title: 'Something went wrong!',
                      icon: 'error',
                      showConfirmButton: false,
                      toast: true,
                      position: 'top-end',
                      timer: 1500,
                      timerProgressBar: true,
                      iconColor: 'white',
                      customClass: {
                        popup: 'colored-toast'
                      }
                    });
                  }
                }
              });

              return false;
            } else{

              Swal.fire({
                title: 'Incorrect Password!',
                icon: 'error',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 1500,
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
      }
  })()

  function loadTheme(){
    $.ajax({
      url: '../../model/ProfileModel.php?action=loadTheme',
      type: 'GET',
      dataType: 'json',
      cache: false,
      success: function(data){
        console.log(data.bg_theme_img);
        $('.bg-theme-img').removeClass('active');
        $('#label'+data.theme_id+' img').addClass('active');
        $('.sidebar-bg-image, .control-sidebar-bg-image').css('background-image', 'url(../../assets/dist/img/bg/'+data.bg_theme_img+')');
      }
    })
  } 

  $('.bg-theme').click(function(e){
    e.preventDefault();
    var theme_id = $(this).val();

    $.ajax({
      url: '../../model/ProfileModel.php?action=changeTheme',
      type: 'POST',
      data: {theme_id: theme_id},
      cache: false,
      beforeSend: function(){
        $('.bg-theme').attr('disabled', true);
      },
      success: function(data){
        setTimeout(function(){
          $('.bg-theme').attr('disabled', false);
          if(data == 'success'){
            Swal.fire({
              title: 'Theme changed successfully!',
              icon: 'success',
              toast: true,
              position: 'top-end',
              timer: 1500,
              timerProgressBar: true,
              iconColor: 'white',
              customClass: {
                popup: 'colored-toast'
              },
              showConfirmButton: false
            })

            loadTheme();
          }else{
            Swal.fire({
              title: 'Theme change failed!',
              icon: 'error',
              toast: true,
              position: 'top-end',
              timer: 1500,
              timerProgressBar: true,
              iconColor: 'white',
              customClass: {
                popup: 'colored-toast'
              },
              showConfirmButton: false
            });
          }
        }, 300);
      }
    })
      
  });


});