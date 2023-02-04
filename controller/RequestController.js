$(function (){
  $('.btn-close-files').on('click', function(){
    $("#file_approve_remarks").summernote('reset');
    $("#file_reject_remarks").summernote('reset');
  });
  var $tbl_pending_user = $('#tbl_pending_user').DataTable({
    dom: "Bfrtip",
    processing: true,
    responsive: true,
    order: [[0, "asc"]],
    lengthMenu: [
      [10, 25, 50, -1],
      [
        "Show 10 entries",
        "Show 25 entries",
        "Show 50 entries",
        "Show all entries",
      ],
    ],
    ajax: {
      url: "../../model/RequestModel.php?action=loadPendingRequestUser",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "request_id" },
      { data: "file_name" },
      { data: "file_type" },
      { data: "reason" },
      { data: "date_requested" },
      { data: "status" },
      { data: "action"},
    ],
    columnDefs: [
      {
        targets: [5, 6, 7],
        orderable: false,
        searchable: false,
        className: "text-center",
      }
    ],
    buttons: [
      {
        text: '<i class="fas fa-eye fa-sm"></i> Show entries',
        extend: "pageLength",
        // titleAttr: 'Show entries',
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digital Archiving System Pending Requests",
        extend: "excel",
        titleAttr: "Export to excel",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-print"></i> Print',
        title: "Digital Archiving System Pending Requests",
        extend: "print",
        titleAttr: "Print table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-sync fa-sm"></i> Refresh',
        titleAttr: "Click to refresh table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        action: function (e, dt, node, config) {
          $("#tbl_pending_user").DataTable().ajax.reload();
          $("#tbl_pending_user").DataTable().order([0, "asc"]).draw();
        },
      },
    ]
  });

  // align dt-buttons to filter
  $("#tbl_pending_user_filter").addClass("float-right");
  $(".btn-group").addClass("float-left");

  
  $('#txt_edit_reason').summernote(
    {
      placeholder: 'Enter reason for request',
      height: 100,
      toolbar: [
        ['font', ['fontname', 'fontsize', 'bold', 'italic', 'underline', 'color']],
        ['script', ['strikethrough', 'superscript', 'subscript', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    }
   
  );

  var $tbl_track_user = $('#tbl_track_user').DataTable({
    dom: "Bfrtip",
    processing: true,
    responsive: true,
    order: [[0, "asc"]],
    lengthMenu: [
      [10, 25, 50, -1],
      [
        "Show 10 entries",
        "Show 25 entries",
        "Show 50 entries",
        "Show all entries",
      ],
    ],
    ajax: {
      url: "../../model/RequestModel.php?action=loadTrackRequestUser",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "request_id" },
      { data: "file_name" },
      { data: "file_type" },
      { data: "reason" },
      { data: "date_requested" },
      { data: "status" },
      { data: "track"}
    ],
    columnDefs: [
      {
        targets: [6, 7],
        orderable: false,
        searchable: false,
        className: "text-center",
      }
    ],
    buttons: [
      {
        text: '<i class="fas fa-eye fa-sm"></i> Show entries',
        extend: "pageLength",
        // titleAttr: 'Show entries',
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digital Archiving System Pending Requests",
        extend: "excel",
        titleAttr: "Export to excel",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-print"></i> Print',
        title: "Digital Archiving System Pending Requests",
        extend: "print",
        titleAttr: "Print table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-sync fa-sm"></i> Refresh',
        titleAttr: "Click to refresh table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        action: function (e, dt, node, config) {
          $("#tbl_track_user").DataTable().ajax.reload();
          $("#tbl_track_user").DataTable().order([0, "asc"]).draw();
        },
      },
    ]
  });

  // align dt-buttons to filter
  $("#tbl_track_user_filter").addClass("float-right");
  $(".btn-group").addClass("float-left");
 
  $tbl_track_user.on("click", ".btn_track_request", function () {
    var $id = $(this).attr("data-id");
    $.ajax({
      url: "../../model/RequestModel.php?action=getFileRequest",
      type: "POST",
      data: { id: $id },
      dataType: "json",
      success: function (data) {
        $("#txt_track_request_id").html(data.request_id);
        $("#file_track_name").html(data.file_name);
        $("#track_file_type").html(data.file_type);
        $("#txt_track_reason").html(data.reason);
        $("#track_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric'}));
        $("#track_date_requested").html(new Date(data.date_requested).toLocaleString('en-us', {year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric'}));
        
        if (data.is_approved == 0) {
          $('#step_requested').addClass('completed active');
        } else if ((data.is_approved == 1) && (data.is_director_approved == 0)) {
          $('#step_requested').addClass('completed');
          $('#step_admin').addClass('completed active');
        } else if (data.is_approved == 2) {
          $('#step_requested').addClass('completed');
          $('#step_admin').addClass('incomplete active');
        } else if ((data.is_approved == 1) && (data.is_director_approved == 1)) {
          $('#step_requested, #step_admin').addClass('completed');
          $('#step_director').addClass('completed active');
        } else if ((data.is_approved == 1) && (data.is_director_approved == 2)) {
          $('#step_requested, #step_admin').addClass('completed');
          $('#step_director').addClass('incomplete active');
        } if ((data.is_approved == 1) && (data.is_director_approved == 1) && (data.is_released == 1)) {
          $('#step_requested, #step_admin, #step_director').addClass('completed');
          $('#step_released').addClass('completed active');
          $('#step_director').removeClass('active');
        }

        $('.btn-close-files').click(function () {
          $('#step_requested, #step_admin, #step_director, #step_released').removeClass('completed incomplete active');
        });

      }
    });
    $('#trackRequestFileModal').modal({ backdrop: 'static', keyboard: false });
  });

  $tbl_pending_user.on("click", ".btn_edit_file_request", function () {
    var $id = $(this).attr("data-id");
    $.ajax({
      url: "../../model/RequestModel.php?action=getFileRequest",
      type: "POST",
      data: { id: $id },
      dataType: "json",
      success: function (data) {
        $("#txt_edit_request_id").html(data.request_id);
        $("#txt_edit_file_id").val(data.id);
        $("#file_edit_name").html(data.file_name);
        $("#edit_file_type").html(data.file_type);
        $("#txt_edit_reason").summernote('code', data.reason);
        $("#edit_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric'}));
        $("#edit_date_requested").html(new Date(data.date_requested).toLocaleString('en-us', {year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric'}));
      }
    })
    $('#editRequestFileModal').modal({ backdrop: 'static', keyboard: false });
  });

  (function () {
    "use strict";

    var frm_edit_file_request = document.querySelectorAll("#frm_edit_file_request");

    Array.prototype.slice.call(frm_edit_file_request).forEach(function (form) {
      $("#btn_edit_request_file").on("click", function (event) {
        if (!frm_edit_file_request[0].checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          Swal.fire({
            title: "Please enter your reason",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });
        } else {
          $(this).prop("type", "submit");
        }
        form.classList.add("was-validated");
      });
    });
  })();


  $("#frm_edit_file_request").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "../../model/RequestModel.php?action=updateFileRequest",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function (result) {
        if (result == "success") {
          Swal.fire({
            title: 'File request updated successfully',
            icon: "success",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            width: 400,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });

          $("#tbl_pending_user").DataTable().ajax.reload();
          $("#tbl_pending_user").DataTable().order([0, "asc"]).draw();
          $("#editRequestFileModal").modal("hide");
          $("#frm_edit_file_request")[0].reset();
          $("#frm_edit_file_request").removeClass("was-validated");
          $("#txt_edit_reason").summernote('reset');
        } else if(result == "empty reason"){
          Swal.fire({
            title: 'Please enter your reason',
            icon: 'error',
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });
        } else {
          Swal.fire({
            title: "Something went wrong",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });
        }
      }
    });
  });

  $tbl_pending_user.on("click", ".btn_cancel_file_request", function () {
    var $id = $(this).attr("data-id");

    Swal.fire({
      title: "Are you sure you want to cancel this request?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#007bff",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../model/RequestModel.php?action=cancelFileRequest",
          type: "POST",
          data: { id: $id },
          success: function (data) {
            if (data == "success") {
              Swal.fire({
                title: "File request cancelled successfully",
                icon: "success",
                showConfirmButton: false,
                toast: true,
                position: "top-end",
                timer: 1500,
                timerProgressBar: true,
                iconColor: "white",
                customClass: {
                  popup: "colored-toast",
                },
              });
            }
            $("#tbl_pending_user").DataTable().ajax.reload();
            $("#tbl_pending_user").DataTable().order([0, "asc"]).draw();
          },
        });
      }
    });
  });

  var $tbl_approved_user = $('#tbl_approved_user').DataTable({
    dom: "Bfrtip",
    processing: true,
    responsive: true,
    order: [[0, "asc"]],
    lengthMenu: [
      [10, 25, 50, -1],
      [
        "Show 10 entries",
        "Show 25 entries",
        "Show 50 entries",
        "Show all entries",
      ],
    ],
    ajax: {
      url: "../../model/RequestModel.php?action=loadApprovedRequestUser",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "request_id" },
      { data: "file_name" },
      { data: "file_type" },
      { data: "reason" },
      { data: "remarks" },
      { data: "date_requested" },
      { data: "date_approved" },
      { data: "approved_by" },
      { data: "status" }
    ],
    columnDefs: [
      {
        // targets: [8, 9],
        targets: [9],
        orderable: false,
        searchable: false,
        className: "text-center",
      }
    ],
    buttons: [
      {
        text: '<i class="fas fa-eye fa-sm"></i> Show entries',
        extend: "pageLength",
        // titleAttr: 'Show entries',
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digital Archiving System Approved Requests",
        extend: "excel",
        titleAttr: "Export to excel",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-print"></i> Print',
        title: "Digital Archiving System Approved Requests",
        extend: "print",
        titleAttr: "Print table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-sync fa-sm"></i> Refresh',
        titleAttr: "Click to refresh table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        action: function (e, dt, node, config) {
          $("#tbl_approved_user").DataTable().ajax.reload();
          $("#tbl_approved_user").DataTable().order([0, "asc"]).draw();
        },
      },
    ]
  });

   // align dt-buttons to filter
   $("#tbl_approved_user_filter").addClass("float-right");
   $(".btn-group").addClass("float-left");

   var $tbl_rejected_user = $('#tbl_rejected_user').DataTable({
    dom: "Bfrtip",
    processing: true,
    responsive: true,
    order: [[0, "asc"]],
    lengthMenu: [
      [10, 25, 50, -1],
      [
        "Show 10 entries",
        "Show 25 entries",
        "Show 50 entries",
        "Show all entries",
      ],
    ],
    ajax: {
      url: "../../model/RequestModel.php?action=loadRejectedRequestUser",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "request_id" },
      { data: "file_name" },
      { data: "file_type" },
      { data: "reason" },
      { data: "remarks" },
      { data: "date_requested" },
      { data: "date_rejected" },
      { data: "rejected_by" },
      { data: "status" }
    ],
    columnDefs: [
      {
        targets: [9],
        orderable: false,
        searchable: false,
        className: "text-center",
      }
    ],
    buttons: [
      {
        text: '<i class="fas fa-eye fa-sm"></i> Show entries',
        extend: "pageLength",
        // titleAttr: 'Show entries',
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digital Archiving System Approved Requests",
        extend: "excel",
        titleAttr: "Export to excel",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-print"></i> Print',
        title: "Digital Archiving System Approved Requests",
        extend: "print",
        titleAttr: "Print table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-sync fa-sm"></i> Refresh',
        titleAttr: "Click to refresh table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        action: function (e, dt, node, config) {
          $("#tbl_rejected_user").DataTable().ajax.reload();
          $("#tbl_rejected_user").DataTable().order([0, "asc"]).draw();
        },
      },
    ]
  });
   // align dt-buttons to filter
  $("#tbl_rejected_user_filter").addClass("float-right");
  $(".btn-group").addClass("float-left");

  var $tbl_pending_admin = $('#tbl_pending_admin').DataTable({
    dom: "Bfrtip",
    processing: true,
    responsive: true,
    order: [[0, "asc"]],
    lengthMenu: [
      [10, 25, 50, -1],
      [
        "Show 10 entries",
        "Show 25 entries",
        "Show 50 entries",
        "Show all entries",
      ],
    ],
    ajax: {
      url: "../../model/RequestModel.php?action=loadPendingRequestAdmin",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "request_id" },
      { data: "picture" },
      { data: "requested_by" },
      { data: "file_name" },
      { data: "file_type" },
      { data: "reason" },
      { data: "date_requested" },
      { data: "status" },
      { data: "action"}
    ],
    columnDefs: [
      {
        targets: [8, 9],
        orderable: false,
        searchable: false,
        className: "text-center",
      },
      {
        targets: [2],
        orderable: false,
        className: "text-center",
        render: function (data, type, row) {
          return `<img src="../../assets/dist/img/users/${data}" class="img-circle" width="50" height="50">`;
        }
      },
      {
        targets: [4],
        render: function (data, type, row) {
          return `<a href="../../storage/files/${data}" target="_blank">${data}</a>`;
        }
      }
    ],
    buttons: [
      {
        text: '<i class="fas fa-eye fa-sm"></i> Show entries',
        extend: "pageLength",
        // titleAttr: 'Show entries',
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digital Archiving System Pending Requests",
        extend: "excel",
        titleAttr: "Export to excel",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-print"></i> Print',
        title: "Digital Archiving System Pending Requests",
        extend: "print",
        titleAttr: "Print table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-sync fa-sm"></i> Refresh',
        titleAttr: "Click to refresh table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        action: function (e, dt, node, config) {
          $("#tbl_pending_admin").DataTable().ajax.reload();
          $("#tbl_pending_admin").DataTable().order([0, "asc"]).draw();
        },
      },
    ]
  });

  // align dt-buttons to filter
  $("#tbl_pending_admin_filter").addClass("float-right");
  $(".btn-group").addClass("float-left");


  $('#file_approve_remarks, #file_process_remarks').summernote(
    {
      placeholder: 'Enter remarks for this request',
      height: 100,
      toolbar: [
        ['font', ['fontname', 'fontsize', 'bold', 'italic', 'underline', 'color']],
        ['script', ['strikethrough', 'superscript', 'subscript', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    }
   
  );

  $tbl_pending_admin.on("click", ".btn_approve_request", function () {

    var $id = $(this).attr("data-id");
    $.ajax({
      url: "../../model/RequestModel.php?action=getFileRequest",
      type: "POST",
      data: { id: $id },
      dataType: "json",
      success: function (data) {
        $('#file_approve_request_id').html(data.request_id);
        $("#file_approve_id").val(data.id);
        $("#file_approve_file_id").val(data.file_id);
        $('#file_approve_requested_by').html(data.requested_by);
        $("#file_approve_file_name").html(data.file_name);
        $("#file_approve_file_type").html(data.file_type);
        $("#file_approve_reason").html(data.reason);
        $("#file_approve_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric'}));
        $("#file_approve_date_requested").html(new Date(data.date_requested).toLocaleString('en-us', {year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric'}));
      }
    })

    $('#frm_approve_file_request').parents('div.modal').modal({ backdrop: 'static', keyboard: false });
    
    
  });

  (function () {
    "use strict";

    var frm_approve_file_request = document.querySelectorAll("#frm_approve_file_request");
    var frm_reject_file_request = document.querySelectorAll("#frm_reject_file_request");
    var frm_approve_reject = document.querySelectorAll("#frm_approve_reject");

    Array.prototype.slice.call(frm_approve_reject).forEach(function (form) {
      $("#btn_notif_approve_request_file").on("click", function (event) {
        if (!frm_approve_reject[0].checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          Swal.fire({
            title: "Please enter your remarks",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });
        } else {
          $(this).prop("type", "submit");
          $('#frm_approve_reject').on('submit', function(e){
            e.preventDefault();
        
            Swal.fire({
              title: "Are you sure?",
              text: "You want to approve this request?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#007bff",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, approve it!",
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url: "../../model/RequestModel.php?action=approveNotifRequest",
                  type: "POST",
                  data: $(this).serialize(),
                  beforeSend: function () {
                    Swal.fire({
                      title: "Approving file request...",
                      html: "Please wait...",
                      allowOutsideClick: false,
                      allowEscapeKey: false,
                      allowEnterKey: false,
                      showConfirmButton: false,
                      didOpen: () => {
                        Swal.showLoading();
                      },
                    });
                  },
                  success: function (data) {
                    if (data == "success") {
                      Swal.fire({
                        title: 'Request has been approved',
                        icon: 'success',
                        showConfirmButton: false,
                        toast: true,
                        position: "top-end",
                        timer: 1500,
                        timerProgressBar: true,
                        iconColor: "white",
                        customClass: {
                          popup: "colored-toast",
                        },
                      });
                      $tbl_pending_admin.ajax.reload();
                      $tbl_pending_admin.order([0, "asc"]).draw();
                      $("#tbl_approved_admin").DataTable().ajax.reload();
                      $("#tbl_approved_admin").DataTable().order([0, "asc"]).draw();
                      $("#tbl_rejected_admin").DataTable().ajax.reload();
                      $("#tbl_rejected_admin").DataTable().order([0, "asc"]).draw();
                    } else if(result == "empty reason"){
                      Swal.fire({
                        title: 'Please enter your reason',
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: "top-end",
                        timer: 1500,
                        timerProgressBar: true,
                        iconColor: "white",
                        customClass: {
                          popup: "colored-toast",
                        },
                      });
                    } else {
                      Swal.fire({
                        title: 'Request failed to approve',
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: "top-end",
                        timer: 1500,
                        timerProgressBar: true,
                        iconColor: "white",
                        customClass: {
                          popup: "colored-toast",
                        },
                      });
                    }
                  },
                });
        
                $('#frm_approve_reject').parents('div.modal').modal('hide');
              }
            });
          });
        }
        form.classList.add("was-validated");
      });
    });
    Array.prototype.slice.call(frm_approve_reject).forEach(function (form) {
      $("#btn_notif_reject_request_file").on("click", function (event) {
        if (!frm_approve_reject[0].checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          Swal.fire({
            title: "Please enter your remarks",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });
        } else {
          $(this).prop("type", "submit");
          $('#frm_approve_reject').on('submit', function(e){
            e.preventDefault();
        
            Swal.fire({
              title: "Are you sure?",
              text: "You want to reject this request?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#007bff",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, reject it!",
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url: "../../model/RequestModel.php?action=rejectNotifRequest",
                  type: "POST",
                  data: $(this).serialize(),
                  beforeSend: function () {
                    Swal.fire({
                      title: "Rejecting file request...",
                      html: "Please wait...",
                      allowOutsideClick: false,
                      allowEscapeKey: false,
                      allowEnterKey: false,
                      showConfirmButton: false,
                      didOpen: () => {
                        Swal.showLoading();
                      },
                    });
                  },
                  success: function (data) {
                    if (data == "success") {
                      Swal.fire({
                        title: 'Request has been rejected',
                        icon: 'success',
                        showConfirmButton: false,
                        toast: true,
                        position: "top-end",
                        timer: 1500,
                        timerProgressBar: true,
                        iconColor: "white",
                        customClass: {
                          popup: "colored-toast",
                        },
                      });
                      $tbl_pending_admin.ajax.reload();
                      $tbl_pending_admin.order([0, "asc"]).draw();
                      $("#tbl_approved_admin").DataTable().ajax.reload();
                      $("#tbl_approved_admin").DataTable().order([0, "asc"]).draw();
                      $("#tbl_rejected_admin").DataTable().ajax.reload();
                      $("#tbl_rejected_admin").DataTable().order([0, "asc"]).draw();
                    } else if(result == "empty reason"){
                      Swal.fire({
                        title: 'Please enter your reason',
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: "top-end",
                        timer: 1500,
                        timerProgressBar: true,
                        iconColor: "white",
                        customClass: {
                          popup: "colored-toast",
                        },
                      });
                    } else {
                      Swal.fire({
                        title: 'Request failed to approve',
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: "top-end",
                        timer: 1500,
                        timerProgressBar: true,
                        iconColor: "white",
                        customClass: {
                          popup: "colored-toast",
                        },
                      });
                    }
                  },
                });
        
                $('#frm_approve_reject').parents('div.modal').modal('hide');
              }
            });
          });
        }
        form.classList.add("was-validated");
      });
    });

    Array.prototype.slice.call(frm_approve_file_request).forEach(function (form) {
      $("#btn_approve_request_file").on("click", function (event) {
        if (!frm_approve_file_request[0].checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          Swal.fire({
            title: "Please enter your remarks",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });
        } else {
          $(this).prop("type", "submit");
        }
        form.classList.add("was-validated");
      });
    });
    Array.prototype.slice.call(frm_reject_file_request).forEach(function (form) {
      $("#btn_reject_request_file").on("click", function (event) {
        if (!frm_reject_file_request[0].checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          Swal.fire({
            title: "Please enter your remarks",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });
        } else {
          $(this).prop("type", "submit");
        }
        form.classList.add("was-validated");
      });
    });
  })();

  $('#frm_approve_file_request').on('submit', function(e){
    e.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "You want to approve this request?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#007bff",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, approve it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../model/RequestModel.php?action=approveRequest",
          type: "POST",
          data: $(this).serialize(),
          beforeSend: function () {
            Swal.fire({
              title: "Approving file request...",
              html: "Please wait...",
              allowOutsideClick: false,
              allowEscapeKey: false,
              allowEnterKey: false,
              showConfirmButton: false,
              didOpen: () => {
                Swal.showLoading();
              },
            });
          },
          success: function (data) {
            if (data == "success") {
              Swal.fire({
                title: 'Request has been approved',
                icon: 'success',
                showConfirmButton: false,
                toast: true,
                position: "top-end",
                timer: 1500,
                timerProgressBar: true,
                iconColor: "white",
                customClass: {
                  popup: "colored-toast",
                },
              });
              $tbl_pending_admin.ajax.reload();
              $tbl_pending_admin.order([0, "asc"]).draw();
            } else if(result == "empty reason"){
              Swal.fire({
                title: 'Please enter your reason',
                icon: 'error',
                showConfirmButton: false,
                toast: true,
                position: "top-end",
                timer: 1500,
                timerProgressBar: true,
                iconColor: "white",
                customClass: {
                  popup: "colored-toast",
                },
              });
            } else {
              Swal.fire({
                title: 'Request failed to approve',
                icon: 'error',
                showConfirmButton: false,
                toast: true,
                position: "top-end",
                timer: 1500,
                timerProgressBar: true,
                iconColor: "white",
                customClass: {
                  popup: "colored-toast",
                },
              });
            }
          },
        });

        $('#frm_approve_file_request').parents('div.modal').modal('hide');
      }
    });
  });

  $('#frm_reject_file_request').on('submit', function(e){
    e.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "You want to reject this request?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#007bff",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, reject it!",
    }).then((result) => {
      if (result.isConfirmed) {
        var id = $(this).attr("data-id");
        $.ajax({
          url: "../../model/RequestModel.php?action=rejectRequest",
          type: "POST",
          data: $(this).serialize(),
          beforeSend: function () {
            Swal.fire({
              title: "Rejecting file request...",
              html: "Please wait...",
              allowOutsideClick: false,
              allowEscapeKey: false,
              allowEnterKey: false,
              showConfirmButton: false,
              didOpen: () => {
                Swal.showLoading();
              },
            });
          },
          success: function (data) {
            if (data == "success") {
              Swal.fire({
                title: 'Request has been rejected',
                icon: 'success',
                showConfirmButton: false,
                toast: true,
                position: "top-end",
                timer: 1500,
                timerProgressBar: true,
                iconColor: "white",
                customClass: {
                  popup: "colored-toast",
                },
              });
              $tbl_pending_admin.ajax.reload();
              $tbl_pending_admin.order([0, "asc"]).draw();
            } else {
              Swal.fire({
                title: 'Request failed to reject',
                icon: 'error',
                showConfirmButton: false,
                toast: true,
                position: "top-end",
                timer: 1500,
                timerProgressBar: true,
                iconColor: "white",
                customClass: {
                  popup: "colored-toast",
                },
              });
            }
          },
        });

        $('#frm_reject_file_request').parents('div.modal').modal('hide');
      }
    });
  });

  $('#file_reject_remarks').summernote(
    {
      placeholder: 'Enter remarks for this request',
      height: 100,
      toolbar: [
        ['font', ['fontname', 'fontsize', 'bold', 'italic', 'underline', 'color']],
        ['script', ['strikethrough', 'superscript', 'subscript', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    }
   
  );

  $tbl_pending_admin.on("click", ".btn_reject_request", function () {

    var $id = $(this).attr("data-id");
    $.ajax({
      url: "../../model/RequestModel.php?action=getFileRequest",
      type: "POST",
      data: { id: $id },
      dataType: "json",
      success: function (data) {
        $('#file_reject_request_id').html(data.request_id);
        $("#file_reject_id").val(data.id);
        $("#file_reject_file_id").val(data.file_id);
        $('#file_reject_requested_by').html(data.requested_by);
        $("#file_reject_file_name").html(data.file_name);
        $("#file_reject_file_type").html(data.file_type);
        $("#file_reject_reason").html(data.reason);
        $("#file_reject_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric'}));
        $("#file_reject_date_requested").html(new Date(data.date_requested).toLocaleString('en-us', {year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric'}));
      }
    })

    $('#frm_reject_file_request').parents('div.modal').modal({ backdrop: 'static', keyboard: false });

    
  });

  var $tbl_approved_admin = $('#tbl_approved_admin').DataTable({
    dom: "Bfrtip",
    processing: true,
    responsive: true,
    order: [[0, "asc"]],
    lengthMenu: [
      [10, 25, 50, -1],
      [
        "Show 10 entries",
        "Show 25 entries",
        "Show 50 entries",
        "Show all entries",
      ],
    ],
    ajax: {
      url: "../../model/RequestModel.php?action=loadApprovedRequestAdmin",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "request_id" },
      { data: "picture" },
      { data: "requested_by" },
      { data: "file_name" },
      { data: "file_type" },
      { data: "reason" },
      { data: "remarks" },
      { data: "date_requested" },
      { data: "date_approved" },
      { data: "approved_by" },
      { data: "status" },
      { data: "release" }
    ],
    columnDefs: [
      {
        targets: [11, 12],
        orderable: false,
        searchable: false,
        className: "text-center",
      },
      {
        targets: [2],
        orderable: false,
        className: "text-center",
        render: function (data, type, row) {
          return `<img src="../../assets/dist/img/users/${data}" class="img-circle" width="50" height="50">`;
        }
      },
      {
        targets: [4],
        className: "text-center",
        render: function (data, type, row) {
          return `<a href="../../storage/files/${data}" target="_blank">${data}</a>`;
        }
      },
    ],
    buttons: [
      {
        text: '<i class="fas fa-eye fa-sm"></i> Show entries',
        extend: "pageLength",
        // titleAttr: 'Show entries',
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digital Archiving System Approved Requests",
        extend: "excel",
        titleAttr: "Export to excel",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-print"></i> Print',
        title: "Digital Archiving System Approved Requests",
        extend: "print",
        titleAttr: "Print table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-sync fa-sm"></i> Refresh',
        titleAttr: "Click to refresh table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        action: function (e, dt, node, config) {
          $("#tbl_approved_admin").DataTable().ajax.reload();
          $("#tbl_approved_admin").DataTable().order([0, "asc"]).draw();
        },
      },
    ]
  });

   // align dt-buttons to filter
   $("#tbl_approved_admin_filter").addClass("float-right");
   $(".btn-group").addClass("float-left");
   
   $tbl_approved_admin.on("click", ".switch_release", function () {
      var id = $(this).attr("data-id");
     
      $.ajax({
        url: "../../model/RequestModel.php?action=releaseRequest",
        type: "POST",
        data: { id: id },
        dataType: "json",
        beforeSend: function () {
          Swal.fire({
            title: "Please wait...",
            html: "Releasing request...",
            allowOutsideClick: false,
            onBeforeOpen: () => {
              Swal.showLoading();
            },
          });
        },
        success: function (data) {
          if (data == 'success') {
            $("#tbl_approved_admin").DataTable().ajax.reload();
            $("#tbl_approved_admin").DataTable().order([0, "asc"]).draw();
          }
        },
      });
   });

   var $tbl_rejected_admin = $('#tbl_rejected_admin').DataTable({
    dom: "Bfrtip",
    processing: true,
    responsive: true,
    order: [[0, "asc"]],
    lengthMenu: [
      [10, 25, 50, -1],
      [
        "Show 10 entries",
        "Show 25 entries",
        "Show 50 entries",
        "Show all entries",
      ],
    ],
    ajax: {
      url: "../../model/RequestModel.php?action=loadRejectedRequestAdmin",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "request_id" },
      { data: "picture" },
      { data: "requested_by" },
      { data: "file_name" },
      { data: "file_type" },
      { data: "reason" },
      { data: "remarks" },
      { data: "date_requested" },
      { data: "date_rejected" },
      { data: "rejected_by" },
      { data: "status" }
    ],
    columnDefs: [
      {
        targets: [11],
        orderable: false,
        searchable: false,
        className: "text-center",
      },
      {
        targets: [2],
        orderable: false,
        className: "text-center",
        render: function (data, type, row) {
          return `<img src="../../assets/dist/img/users/${data}" class="img-circle" width="50" height="50">`;
        }
      },
      {
        targets: [4],
        className: "text-center",
        render: function (data, type, row) {
          return `<a href="../../storage/files/${data}" target="_blank">${data}</a>`;
        }
      },
    ],
    buttons: [
      {
        text: '<i class="fas fa-eye fa-sm"></i> Show entries',
        extend: "pageLength",
        // titleAttr: 'Show entries',
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digital Archiving System Rejected Requests",
        extend: "excel",
        titleAttr: "Export to excel",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-print"></i> Print',
        title: "Digital Archiving System Rejected Requests",
        extend: "print",
        titleAttr: "Print table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
      {
        text: '<i class="fas fa-sync fa-sm"></i> Refresh',
        titleAttr: "Click to refresh table",
        className: "btn btn-sm bg-primary",
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
        action: function (e, dt, node, config) {
          $("#tbl_rejected_admin").DataTable().ajax.reload();
          $("#tbl_rejected_admin").DataTable().order([0, "asc"]).draw();
        },
      },
    ]
  });
   // align dt-buttons to filter
  $("#tbl_rejected_admin_filter").addClass("float-right");
  $(".btn-group").addClass("float-left");
});