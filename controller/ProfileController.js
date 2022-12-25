$(function(){

  $(document).keypress(
    function(event){
      if (event.which == '13') {
        event.preventDefault();
      }
  });
  
  loadProfile();

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


});