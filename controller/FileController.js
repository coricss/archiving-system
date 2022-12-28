$(function () {
  var $tbl_file_types = $("#tbl_file_types").DataTable({
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
      url: "../../model/FileModel.php?action=loadFileTypes",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "file_type" },

      { data: "created_by" },
      { data: "date_created" },
      { data: "status" },
      { data: "action" },
    ],
    deferRender: true,
    lengthChange: false,
    columnDefs: [
      { targets: [4, 5], className: "text-center", orderable: false },
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
        text: '<i class="fa fa-plus"></i> Add file type',
        className: "btn btn-sm bg-primary",
        titleAttr: "Add User",
        action: function (e, dt, node, config) {
          $("#frm_file_type")
            .parents("div.modal")
            .modal({ backdrop: "static", keyboard: true });
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digita Archiving System File Types",
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
        title: "Digita Archiving System File Types",
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
          $("#tbl_file_types").DataTable().ajax.reload();
          $("#tbl_file_types").DataTable().order([0, "asc"]).draw();
        },
      },
    ],
  });

  // align dt-buttons to filter
  $("#tbl_file_types_filter").addClass("float-right");
  $(".btn-group").addClass("float-left");

  $(".btn-close-files").on("click", function () {
    var form_file_type = $("#frm_file_type");
    var form_edit_file_type = $("#frm_edit_file_type");
    close_reset_form(form_file_type);
    close_reset_form(form_edit_file_type);
  });

  function close_reset_form(form) {
    form.parents("div.modal").modal("hide");
    form.trigger("reset");
    form.removeClass("was-validated");
    form.find("input").removeClass("is-valid is-invalid");
    form.find("select").removeClass("is-valid is-invalid");
    form.find("div.invalid-feedback").remove();
  }

  // Add file type

  (function () {
    "use strict";
    var add_file_type_form = document.querySelectorAll("#frm_file_type");
    var edit_file_type_form = document.querySelectorAll("#frm_edit_file_type");

    Array.prototype.slice.call(add_file_type_form).forEach(function (form) {
      $("#btn_save_file_type").on("click", function (event) {
        if (!add_file_type_form[0].checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          $(this).prop("type", "submit");
        }
        form.classList.add("was-validated");
      });
    });

    Array.prototype.slice.call(edit_file_type_form).forEach(function (form) {
      $("#btn_update_file_type").on("click", function (event) {
        if (!edit_file_type_form[0].checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          $(this).prop("type", "submit");
        }
        form.classList.add("was-validated");
      });
    });
  })();

  $("#frm_file_type").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../model/FileModel.php?action=addFileType",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function (result) {
        if (result == "success") {
          $("#frm_file_type").trigger("reset");
          $("#frm_file_type").find("input").removeClass("is-valid is-invalid");
          $("#frm_file_type").find("select").removeClass("is-valid is-invalid");
          $("#frm_file_type").find("div.invalid-feedback").remove();
          $("#frm_file_type").parents("div.modal").modal("hide");
          $("#tbl_file_types").DataTable().ajax.reload();
          $("#tbl_file_types").DataTable().order([0, "asc"]).draw();
          Swal.fire({
            title: "New file type added!",
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
        } else if (result == "file type exists") {
          Swal.fire({
            title: "File type exists!",
            icon: "info",
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
      },
    });
  });

  //EDIT FILE TYPE

  $tbl_file_types.on("click", ".btn_edit_file_type", function () {
    var id = $(this).attr("data-id");

    $.ajax({
      url: "../../model/FileModel.php?action=getFileType",
      type: "GET",
      data: { id: id },
      dataType: "json",
      success: function (result) {
        $("#txt_file_type_id").val(result.id);
        $("#txt_edit_file_type").val(result.file_type);
        $("#frm_edit_file_type")
          .parents("div.modal")
          .modal({ backdrop: "static", keyboard: true });
      },
    });
  });

  $("#frm_edit_file_type").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../model/FileModel.php?action=updateFileType",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function (result) {
        if (result == "success") {
          $("#frm_edit_file_type").trigger("reset");
          $("#frm_edit_file_type")
            .find("input")
            .removeClass("is-valid is-invalid");
          $("#frm_edit_file_type")
            .find("select")
            .removeClass("is-valid is-invalid");
          $("#frm_edit_file_type").find("div.invalid-feedback").remove();
          $("#frm_edit_file_type").parents("div.modal").modal("hide");
          $("#tbl_file_types").DataTable().ajax.reload();
          $("#tbl_file_types").DataTable().order([0, "asc"]).draw();

          Swal.fire({
            title: "File type was updated!",
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
        } else if (result == "file type exists") {
          Swal.fire({
            title: "File type exists!",
            icon: "info",
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
      },
    });
  });

  $tbl_file_types.on("click", ".btn_activate_file_type", function () {
    var id = $(this).attr("data-id");

    $.ajax({
      url: "../../model/FileModel.php?action=activateFileType",
      type: "POST",
      data: { id: id },
      success: function (result) {
        if (result == "success") {
          Swal.fire({
            title: 'File type activated!',
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
          $("#tbl_file_types").DataTable().ajax.reload();
        }
      },
    });
  });

  $tbl_file_types.on("click", ".btn_deactivate_file_type", function () {
    var id = $(this).attr("data-id");
    
    $.ajax({
      url: "../../model/FileModel.php?action=deactivateFileType",
      type: "POST",
      data: { id: id },
      success: function (result) {
        if (result == "success") {
          Swal.fire({
            title: 'File type deactivated!',
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
          $("#tbl_file_types").DataTable().ajax.reload();
        }
      },
    });
  });
});
