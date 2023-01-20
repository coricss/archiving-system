$(function(){
    $.ajax({
      url: '../../model/NotificationModel.php?action=countNotif',
      type: 'GET',
      dataType: 'json',
      success: function(data){
        $('.count-admin-notifs').html(data.admin_notif);
        $('.count-user-notifs').html(data.user_notif);
        if((data.admin_notif > 0) || (data.user_notif > 0)){;
          $('.count-admin-notif').removeClass('d-none').html(data.admin_notif);
          $('.count-user-notif').removeClass('d-none').html(data.user_notif);
        } else {
          $('.count-admin-notif').addClass('d-none');
          $('.count-user-notif').addClass('d-none');
        }
      }
    });
})