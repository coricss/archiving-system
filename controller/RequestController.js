$(function (){
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
      { data: "file_name" },
      { data: "file_type" },
      { data: "reason" },
      { data: "date_requested" },
      { data: "status" },
      { data: "action"}
    ],
    columnDefs: [
      {
        targets: [5, 6],
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
        title: "Digita Archiving System Pending Requests",
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
        title: "Digita Archiving System Pending Requests",
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

  $tbl_pending_user.on("click", ".btn_edit_file_request", function () {
    var $id = $(this).attr("data-id");
    $.ajax({
      url: "../../model/RequestModel.php?action=getFileRequest",
      type: "POST",
      data: { id: $id },
      dataType: "json",
      success: function (data) {
        $("#txt_edit_file_id").val(data.id);
        $("#file_edit_name").html(data.file_name);
        $("#edit_file_type").html(data.file_type);
        $("#txt_edit_reason").summernote('code', data.reason);
        $("#edit_date_uploaded").html(new Date(data.date_uploaded).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
        $("#edit_date_requested").html(new Date(data.date_requested).toLocaleString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
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
      { data: "file_name" },
      { data: "file_type" },
      { data: "reason" },
      { data: "remarks" },
      { data: "date_requested" },
      { data: "status" },
      { data: "action" }
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
        title: "Digita Archiving System Approved Requests",
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
        title: "Digita Archiving System Approved Requests",
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
});