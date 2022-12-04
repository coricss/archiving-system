$(function(){

  var $tbl_users = $('#tbl_users').DataTable({
    dom: 'Bfrtip',
    processing: true,
    responsive: true,
    order: [[ 0, "asc" ]],
    lengthMenu:     [[10, 25, 50, -1], ['Show 10 entries', 'Show 25 entries', 'Show 50 entries', 'Show all entries']],
    ajax: {
      url: "../../model/UserModel.php?action=loadUserDetails",
      type: "GET",
      dataType: "json",
      dataSrc: ""
    },
    columns: [
      { data: "id" },
      { data: "userid" },
      { data: "fullname" },
      { data: "phone" },
      { data: "email" },
      { data: "address" },
      { data: "username" },
      { data: "role" },
      { data: "status" },
      { data: "date_added" },
      { data: "action" },
    ],
    columnDefs: [
      {
        targets: [10],
        orderable: false,
        className: "text-center"
      },
    ],
    deferRender: true,
    buttons: [
      {
        text: '<i class="fas fa-eye fa-sm"></i> Show entries',
        extend: 'pageLength',
        // titleAttr: 'Show entries',
        className: 'btn btn-sm bg-primary',
        init: function(api, node, config) {
            $(node).removeClass('dt-button');
        }
      },
      {
        text: '<i class="fa fa-plus"></i> Add User',
        className: 'btn btn-sm bg-primary',
        titleAttr: 'Add User',
        action: function ( e, dt, node, config ) {
          $('#frm_user_details').parents('div.modal').modal({backdrop: 'static', keyboard: true});
        }
      },
      {
        text: '<i class="fas fa-file-excel"></i> Export',
        title: 'Digita Archiving System Users',
        extend: 'excel',
        titleAttr: 'Export to excel',
        className: 'btn btn-sm bg-primary',
        init: function(api, node, config) {
            $(node).removeClass('dt-button')
        },
        exportOptions: {
            columns: ':not(:last-child)',
        }
      },
      {
        text: '<i class="fas fa-print"></i> Print',
        title: 'Digita Archiving System Users',
        extend: 'print',
        titleAttr: 'Print table',
        className: 'btn btn-sm bg-primary',
        init: function(api, node, config) {
            $(node).removeClass('dt-button')
        },
        exportOptions: {
            columns: ':not(:last-child)',
        }
      },
      {
        text: '<i class="fas fa-sync fa-sm"></i> Refresh',
        titleAttr: 'Click to refresh table',
        className: 'btn btn-sm bg-primary',
        init: function(api, node, config) {
            $(node).removeClass('dt-button')
        },
        action: function (e, dt, node, config) {
            $('#tbl_users').DataTable().ajax.reload();
            $('#tbl_users').DataTable().order([0, 'asc']).draw();
        }
      },
    ],  
  });
  


  // Add user

  $('#frm_user_details').on('submit', function(e){
    e.preventDefault();

    $.ajax({
      url: "../../model/UserModel.php?action=addUserDetails",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function(result){
        if(result == "success"){

          $('#frm_user_details').parents('div.modal').modal('hide');
          $('#tbl_users').DataTable().ajax.reload();
          $('#tbl_users').DataTable().order([0, 'asc']).draw();
          $('#frm_user_details')[0].reset();

          Swal.fire({
            title: 'New user added!',
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
          });
        }else{
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
            },
          });
        }
      }
    });
  });

  // Edit user
  $tbl_users.on('click', '.btn_edit_user', function(){
    var id = $(this).attr('data-id');

    $.ajax({
      url: "../../model/UserModel.php?action=getUserDetails",
      type: "GET",
      data: {id:id},
      dataType: "json",
      success: function(result){
        $('#txt_user_id').val(result.id);
        $('#txt_edit_fname').val(result.first_name);
        $('#txt_edit_mname').val(result.middle_name);
        $('#txt_edit_lname').val(result.last_name);
        $('#txt_edit_phone').val(result.phone_no);
        $('#txt_edit_email').val(result.email);
        $('#txt_edit_address').val(result.address);
        $('#txt_edit_username').val(result.username);
        $('#slc_edit_role').val(result.is_admin);

        $('#frm_edit_user_details').parents('div.modal').modal({backdrop: 'static', keyboard: true});
      }
    });
  });

  $('#frm_edit_user_details').on('submit', function(e){
    e.preventDefault();

    $.ajax({
      url: "../../model/UserModel.php?action=updateUserDetails",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function(result){
        if(result == "success"){

          $('#frm_edit_user_details').parents('div.modal').modal('hide');
          $('#tbl_users').DataTable().ajax.reload();
          $('#tbl_users').DataTable().order([0, 'asc']).draw();
          $('#frm_edit_user_details')[0].reset();

          Swal.fire({
            title: 'User details updated!',
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
          });
        }else{
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
            },
          });
        }
      }
    });
  });
  
})