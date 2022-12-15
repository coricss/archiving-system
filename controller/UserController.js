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
      { data: "picture" },
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
        targets: [2],
        orderable: false,
        className: "text-center",
        render: function (data, type, row) {
          return '<img src="../../assets/dist/img/users/' + data + '" class="img-circle" width="50" height="50" />';
        }
      },
      {
        targets: [9],
        className: "text-center"
      },
      {
        targets: [11],
        orderable: false,
        className: "text-center"
      },
    ],
    deferRender: true,
    lengthChange: false,
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
        text: '<i class="fas fa-download"></i> Export',
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
  
  // align dt-buttons to filter
  $('#tbl_users_filter').addClass('float-right');
  $('.btn-group').addClass('float-left');

  $('.btn-close').on('click', function(){
    var form_add_user = $('#frm_user_details');
    var form_update_user = $('#frm_edit_user_details');
    close_reset_form(form_add_user);
    close_reset_form(form_update_user);
  });

  function close_reset_form(form) {
    form[0].reset();
    form.find('input:text, select')
          .removeClass('is-invalid')
          .parent()
          .css('margin-bottom', '15px')
          .find('label.error').remove();
    form.find('select').val(null).trigger('change');
    form.parents('div.modal').modal('hide');
  }

  // Add user

  (function () {
    'use strict'
    var add_user_forms = document.querySelectorAll('#frm_user_details');
    var edit_user_forms = document.querySelectorAll('#frm_edit_user_details');

    Array.prototype.slice.call(add_user_forms)
      .forEach(function (form) {
          $('#btn_save_user').on('click', function(event){
            if (!add_user_forms[0].checkValidity()) {
              event.preventDefault();
              event.stopPropagation();

            } else{
              $(this).prop("type", "submit");
            }
            form.classList.add('was-validated');
          })
      });

    Array.prototype.slice.call(edit_user_forms)
      .forEach(function (form) {
          $('#btn_update_user').on('click', function(event){
            if (!edit_user_forms[0].checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            } else{
              $(this).prop("type", "submit");
            }
            form.classList.add('was-validated');
          })
      });
  })()


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

        } else if (result == "user_exists"){

          Swal.fire({
            title: 'User Exists',
            icon: 'info',
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

        } else if (result == "email_exists"){

          Swal.fire({
            title: 'Email or Username Exists',
            icon: 'info',
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

        } else{

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
        $('#img_edit_user').prop('src', '../../assets/dist/img/users/'+result.picture);
        $('#txt_edit_fname').val(result.first_name);
        $('#txt_edit_mname').val(result.middle_name);
        $('#txt_edit_lname').val(result.last_name);
        $('#txt_edit_phone').val(result.phone_no);
        $('#txt_edit_email').val(result.email);
        $('#txt_edit_address').val(result.address);
        $('#txt_edit_username').val(result.username);
        $('#slc_edit_role').val(result.is_admin);
        if(result.status == 1){
          $('#btn_activate').addClass('d-none');
          $('#btn_deactivate').removeClass('d-none');
        }else {
          $('#btn_activate').removeClass('d-none');
          $('#btn_deactivate').addClass('d-none');
        }
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
          
        }else if (result == "user_exists"){

          Swal.fire({
            title: 'User Exists',
            icon: 'info',
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

        } else if (result == "email_exists"){

          Swal.fire({
            title: 'Email or Username Exists',
            icon: 'info',
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

        } else{

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

  // Change user status

  $('#btn_activate').on('click', function(){
    var id = $('#txt_user_id').val();

    $.ajax({
      url: "../../model/UserModel.php?action=activateUser",
      type: "POST",
      data: {id:id},
      success: function(result){
          if(result == "success"){
            Swal.fire({
              title: 'Account activated!',
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
            $('#tbl_users').DataTable().ajax.reload();
            $('#tbl_users').DataTable().order([0, 'asc']).draw();
            $('#btn_activate').addClass('d-none');
            $('#btn_deactivate').removeClass('d-none');
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

  $('#btn_deactivate').on('click', function(){
    var id = $('#txt_user_id').val();

    $.ajax({
      url: "../../model/UserModel.php?action=deactivateUser",
      type: "POST",
      data: {id:id},
      success: function(result){
        if(result == "success"){
          Swal.fire({
            title: 'Account deactivated!',
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
          $('#tbl_users').DataTable().ajax.reload();
          $('#tbl_users').DataTable().order([0, 'asc']).draw();
          $('#btn_activate').removeClass('d-none');
          $('#btn_deactivate').addClass('d-none');
        } else{
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
  
  //Reset password
  $tbl_users.on('click', '.btn_reset_password', function(){
    var id = $(this).attr('data-id');
 
    Swal.fire({
      title: 'Are you sure?',
      text: "You want to reset this user's password?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#007bff',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, reset it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../model/UserModel.php?action=resetPassword",
          type: "POST",
          data: {id:id},
          success: function(result){
            if(result == "success"){
              Swal.fire({
                title: 'Password successfully reset!',
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
      }
    });
  });

});