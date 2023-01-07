$(function () {
  var $tbl_archives = $('#tbl_archives').DataTable({
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
      url: "../../model/ArchiveModel.php?action=loadActiveFiles",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "file_name" },
      { data: "file_type" },
      { data: "uploaded_by" },
      { data: "date_uploaded" },
      { data: "status" },
      { data: "action" }
    ],
    deferRender: true,
    lengthChange: false,
    columnDefs: [
      {
        targets: [ 5, 6],
        orderable: false,
        className: "text-center",
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
        title: "Digital Archiving System My Archives",
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
        title: "Digital Archiving System My Archives",
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
          $("#tbl_archives").DataTable().ajax.reload();
          $("#tbl_archives").DataTable().order([0, "asc"]).draw();
        },
      },
    ]
        
  });
  
  // align dt-buttons to filter
  $("#tbl_archives_filter").addClass("float-right");
  $(".btn-group").addClass("float-left");

  $tbl_archives.on("click", ".btn_file_request", function () {
    var id = $(this).attr("data-id");

    $.ajax({
      url: "../../model/ArchiveModel.php?action=getFileDetails",
      type: "GET",
      data: { id: id },
      dataType: "json",
      success: function (data) {

        $("#txt_file_id").val(data.id);

        $("#file_name").html(data.file_name);
        $("#file_type").html(data.file_type);
        $("#uploaded_by").html(data.uploader);
        $("#date_uploaded").html(new Date(data.date_uploaded).toLocaleDateString('en-us', {year: 'numeric', month: 'long', day: 'numeric'}));
      },
    });

    $('#requestFileModal').modal({backdrop: 'static', keyboard: false});


  });

  $('#txt_reason').summernote(
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

 
  (function () {
    "use strict";

    var frm_file_request = document.querySelectorAll("#frm_file_request");

    Array.prototype.slice.call(frm_file_request).forEach(function (form) {
      $("#btn_request_file").on("click", function (event) {
        if (!frm_file_request[0].checkValidity()) {
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


  $("#frm_file_request").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../model/ArchiveModel.php?action=requestFile",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function (result) {
        if (result == "success") {
          Swal.fire({
            title: 'File request sent!',
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
          $("#tbl_archives").DataTable().ajax.reload();
          $("#tbl_archives").DataTable().order([0, "asc"]).draw();
          $("#requestFileModal").modal("hide");
          $("#frm_file_request")[0].reset();
          $("#frm_file_request").removeClass("was-validated");
          $("#txt_reason").summernote('reset');
        } else if (result == "empty reason") {
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
        } else if (result == 'already requested') {
          Swal.fire({
            title: 'You have already requested this file',
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
  });

  $(".btn-close-request").on("click", function () {
    $("#txt_reason").summernote('reset');
  });

});