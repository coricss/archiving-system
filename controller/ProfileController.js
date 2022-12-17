$(function(){
  
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
            new Date(data.date_added).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric'})
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
});