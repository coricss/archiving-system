$(function(){
    $.ajax({
      url: '../../model/NotificationModel.php?action=countNotif',
      type: 'GET',
      dataType: 'json',
      success: function(data){
        $('.count-admin-notifs').html(data.admin_notif);
        $('.count-user-notifs').html(data.user_notif);
        if(data.admin_notif > 0){;
          $('.count-admin-notif').removeClass('d-none').html(data.admin_notif);
        } else {
          $('.count-admin-notif').addClass('d-none');
        }

        if(data.user_notif > 0){
          $('.count-user-notif').removeClass('d-none').html(data.user_notif);
        } else {
          $('.count-user-notif').addClass('d-none');
        }
      }
    });
    setInterval(function(){
      $.ajax({
        url: '../../model/NotificationModel.php?action=countNotif',
        type: 'GET',
        dataType: 'json',
        success: function(data){
          $('.count-admin-notifs').html(data.admin_notif);
          $('.count-user-notifs').html(data.user_notif);
          if(data.admin_notif > 0){;
            $('.count-admin-notif').removeClass('d-none').html(data.admin_notif);
          } else {
            $('.count-admin-notif').addClass('d-none');
          }

          if(data.user_notif > 0){
            $('.count-user-notif').removeClass('d-none').html(data.user_notif);
          } else {
            $('.count-user-notif').addClass('d-none');
          }
        }
      });
    }, 5000);

    $('.admin-notif-bell').click(function(){
      $.ajax({
        url: '../../model/NotificationModel.php?action=adminNotification',
        type: 'GET',
        success: function(data){
          $('#admin-notif').html(data);
          $('button.notif-item').click(function() {
            var id = $(this).attr('request-id');
            var activity = $(this).attr('activity');

            if(activity == 0) {
              $.ajax({
                url: '../../model/RequestModel.php?action=getFileRequest',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(data) {
                  $("#file_process_file_id").val(data.file_id);
                  $("#file_process_id").val(data.id);
                  $('#file_process_requested_by').html(data.requested_by);
                  $("#file_process_file_name").html(data.file_name);
                  $("#file_process_file_type").html(data.file_type);
                  $("#file_process_reason").html(data.reason);
                  $("#file_process_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                  $("#file_process_date_requested").html(new Date(data.date_requested).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                }
              });
              $('#frm_approve_reject').parents("div.modal").modal({ backdrop: "static", keyboard: true });
            } else if (activity == 1) {
              $.ajax({
                url: '../../model/RequestModel.php?action=getFileRequest',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(data) {
                  $("#file_approve_notif_file_id").val(data.file_id);
                  $("#file_approve_notif_id").val(data.id);
                  $('#file_approve_notif_requested_by').html(data.requested_by);
                  $("#file_approve_notif_file_name").html(data.file_name);
                  $("#file_approve_notif_file_type").html(data.file_type);
                  $("#file_approve_notif_reason").html(data.reason);
                  $("#file_approve_notif_remarks").html(data.remarks);
                  $("#file_approve_notif_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                  $("#file_approve_notif_date_requested").html(new Date(data.date_requested).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                }
              });
              $('#frm_approve_notif').parents("div.modal").modal({ backdrop: "static", keyboard: true });
            } else {
              $.ajax({
                url: '../../model/RequestModel.php?action=getFileRequest',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(data) {
                  $("#file_reject_notif_file_id").val(data.file_id);
                  $("#file_reject_notif_id").val(data.id);
                  $('#file_reject_notif_requested_by').html(data.requested_by);
                  $("#file_reject_notif_file_name").html(data.file_name);
                  $("#file_reject_notif_file_type").html(data.file_type);
                  $("#file_reject_notif_reason").html(data.reason);
                  $("#file_reject_notif_remarks").html(data.remarks);
                  $("#file_reject_notif_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                  $("#file_reject_notif_date_requested").html(new Date(data.date_requested).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                }
              });
              $('#frm_reject_notif').parents("div.modal").modal({ backdrop: "static", keyboard: true });
            }
            
            
          })
        }
      })
    })

    $('.user-notif-bell').click(function(){
      $.ajax({
        url: '../../model/NotificationModel.php?action=userNotification',
        type: 'GET',
        success: function(data){
          $('#user-notif').html(data);
          $('button.notif-item').click(function() {
            var id = $(this).attr('request-id');
            var activity = $(this).attr('activity');

            if(activity == 1) {
              $.ajax({
                url: '../../model/RequestModel.php?action=getFileRequest',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(data) {
                  $("#file_approve_notif_file_id").val(data.file_id);
                  $("#file_approve_notif_id").val(data.id);
                  $('#file_approve_notif_requested_by').html(data.processed_by);
                  $("#file_approve_notif_file_name").html(data.file_name);
                  $("#file_approve_notif_file_type").html(data.file_type);
                  $("#file_approve_notif_reason").html(data.reason);
                  $("#file_approve_notif_remarks").html(data.remarks);
                  $("#file_approve_notif_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                  $("#file_approve_notif_date_requested").html(new Date(data.date_processed).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                }
              });
              $('#frm_approve_notif').parents("div.modal").modal({ backdrop: "static", keyboard: true });
            } else {
              $.ajax({
                url: '../../model/RequestModel.php?action=getFileRequest',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(data) {
                  $("#file_reject_notif_file_id").val(data.file_id);
                  $("#file_reject_notif_id").val(data.id);
                  $('#file_reject_notif_requested_by').html(data.processed_by);
                  $("#file_reject_notif_file_name").html(data.file_name);
                  $("#file_reject_notif_file_type").html(data.file_type);
                  $("#file_reject_notif_reason").html(data.reason);
                  $("#file_reject_notif_remarks").html(data.remarks);
                  $("#file_reject_notif_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                  $("#file_reject_notif_date_requested").html(new Date(data.date_processed).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
                }
              });
              $('#frm_reject_notif').parents("div.modal").modal({ backdrop: "static", keyboard: true });
            }
          })
        }
      });
    });

    
    
})