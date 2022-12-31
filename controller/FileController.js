$(function () {

  $(".btn-close-files").on("click", function () {
    var form_file_type = $("#frm_file_type");
    var form_edit_file_type = $("#frm_edit_file_type");
    var form_file = $("#frm_file");
    // var form_edit_file_type = $("#frm_edit_file");
    close_reset_form(form_file_type);
    close_reset_form(form_edit_file_type);
    close_reset_form(form_file);
    // close_reset_form(form_edit_file);
  });

  function close_reset_form(form) {
    form.parents("div.modal").modal("hide");
    form.trigger("reset");
    form.removeClass("was-validated");
    form.find("input").removeClass("is-valid is-invalid");
    form.find("select").html("<option  value='' disabled='true' selected='true'>-- Please select --</option>");
    form.find("select").removeClass("is-valid is-invalid");
    form.find("div.invalid-feedback").remove();
  }

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
          $("#frm_file_type").removeClass("was-validated");
          $("#frm_file_type").find("div.invalid-feedback").remove();
          $("#frm_file_type").parents("div.modal").modal("hide");
          $("#tbl_file_types").DataTable().ajax.reload();
          $("#tbl_file_types").DataTable().order([0, "asc"]).draw();
          Swal.fire({
            title: "New file type was added!",
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
          $("#frm_edit_file_type").removeClass("was-validated");
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

  //FILES

  var $tbl_files = $("#tbl_files").DataTable({
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
      url: "../../model/FileModel.php?action=loadFiles",
      type: "GET",
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "picture" },
      { data: "owner" },
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
      { targets: [7, 8], className: "text-center", orderable: false },
      {
        targets: [1],
        orderable: false,
        className: "text-center",
        render: function (data, type, row) {
          return `<img src="../../assets/dist/img/users/${data}" class="img-circle" width="50" height="50">`;
        }
      },
      {
        targets: [3],
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
        text: '<i class="fa fa-plus"></i> Add file',
        className: "btn btn-sm bg-primary",
        titleAttr: "Add File",
        action: function (e, dt, node, config) {
          $("#frm_file")
            .parents("div.modal")
            .modal({ backdrop: "static", keyboard: true });
          $.ajax({
            url: "../../model/FileModel.php?action=loadActiveFileTypes",
            type: "GET",
            dataType: "json",
            success: function(data){
              $('#slc_file_type').select2({
                theme: 'bootstrap4',
                dropdownPosition: 'below'
              });
              for(var i=0; i<data.length; i++){
                $("#slc_file_type").append("<option value="+data[i].file_type_id+">"+data[i].file_type+"</option>")
              }
            }
          });
          $.ajax({
            url: "../../model/FileModel.php?action=loadActiveStudents",
            type: "GET",
            dataType: "json",
            success: function(data){
              $('#slc_owner').select2({
                theme: 'bootstrap4',
                dropdownPosition: 'below'
              });
              for(var i=0; i<data.length; i++){
                $("#slc_owner").append("<option value="+data[i].userid+">"+data[i].fullname+"</option>")
              }
            }
          });
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digita Archiving System Files",
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
        title: "Digita Archiving System Files",
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
          $("#tbl_files").DataTable().ajax.reload();
          $("#tbl_files").DataTable().order([0, "asc"]).draw();
        },
      },
    ],
  });

  // align dt-buttons to filter
  $("#tbl_files_filter").addClass("float-right");
  $(".btn-group").addClass("float-left");


  // Add file

  (function () {
    "use strict";
    var add_file_form = document.querySelectorAll("#frm_file");
    // var edit_file_form = document.querySelectorAll("#frm_edit_file");

    Array.prototype.slice.call(add_file_form).forEach(function (form) {
      $("#btn_save_file").on("click", function (event) {
        if (!add_file_form[0].checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          $(this).prop("type", "submit");
        }
        form.classList.add("was-validated");
      });
    });

    // Array.prototype.slice.call(edit_file_type_form).forEach(function (form) {
    //   $("#btn_update_file_type").on("click", function (event) {
    //     if (!edit_file_type_form[0].checkValidity()) {
    //       event.preventDefault();
    //       event.stopPropagation();
    //     } else {
    //       $(this).prop("type", "submit");
    //     }
    //     form.classList.add("was-validated");
    //   });
    // });
  })();

  $("#frm_file").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "../../model/FileModel.php?action=addFile",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function (result) {
        if(result == 'success') {
          $("#frm_file").trigger("reset");
          $("#frm_file").removeClass("was-validataed");
          $("#frm_file").find("div.invalid-feedback").remove();
          $("#frm_file").parents("div.modal").modal("hide");
          $("#tbl_files").DataTable().ajax.reload();
          $("#tbl_files").DataTable().order([0, "asc"]).draw();

          Swal.fire({
            title: "New file was added!",
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

        } else if (result == 'file too large'){
          Swal.fire({
            title: "File too large",
            text: "File size must not exceed 3MB",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            width: 450,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });
        } else if (result == 'invalid file type') {
          Swal.fire({
            title: "Invalid file type",
            text: "File type must be pdf, docx, xlsx & pptx",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            width: 450,
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


  //Edit file 

  $tbl_files.on("click", ".btn_edit_file", function () {
    var id = $(this).attr("data-id");

    $.ajax({
      url: "../../model/FileModel.php?action=getFile",
      type: "GET",
      data: { id: id },
      dataType: "json",
      success: function (result) {

        // $('#slc_edit_owner, #slc_edit_file_type').select2({
        //   theme: 'bootstrap4',
        //   dropdownPosition: 'below'
        // });

        $.ajax({
          url: "../../model/FileModel.php?action=loadActiveStudents",
          type: "GET",
          dataType: "json",
          success: function(data){
            $('#slc_edit_owner').select2({
              theme: 'bootstrap4',
              dropdownPosition: 'below'
            });
            for(var i=0; i<data.length; i++){
              $("#slc_edit_owner").append("<option value="+data[i].userid+">"+data[i].fullname+"</option>")
            }
          }
        });
        
        $.ajax({
          url: "../../model/FileModel.php?action=loadActiveFileTypes",
          type: "GET",
          dataType: "json",
          success: function(data){
            $('#slc_edit_file_type').select2({
              theme: 'bootstrap4',
              dropdownPosition: 'below'
            });
            for(var i=0; i<data.length; i++){
              $("#slc_edit_file_type").append("<option value="+data[i].file_type_id+">"+data[i].file_type+"</option>")
            }
          }
        });
        $("#txt_file_id").val(result.id);
        $("#slc_edit_owner").html(`<option value=${result.user_id}>${result.owner}</option>`);
        $("#slc_edit_file_type").html(`<option value=${result.file_type_id}>${result.file_type}</option>`);
        $('#recent_file').attr('href', `../../storage/files/${result.file_name}`);
        $("#frm_edit_file")
          .parents("div.modal")
          .modal({ backdrop: "static", keyboard: true });
      },
    });
  });

  $("#frm_edit_file").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "../../model/FileModel.php?action=updateFile",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function (result) {
        if(result == 'success') {
          $("#frm_edit_file").trigger("reset");
          $("#frm_edit_file").removeClass("was-validataed");
          $("#frm_edit_file").find("div.invalid-feedback").remove();
          $("#frm_edit_file").parents("div.modal").modal("hide");
          $("#tbl_files").DataTable().ajax.reload();
          $("#tbl_files").DataTable().order([0, "asc"]).draw();

          Swal.fire({
            title: "File was updated!",
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

        } else if (result == 'file too large'){
          Swal.fire({
            title: "File too large",
            text: "File size must not exceed 3MB",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            width: 450,
            timerProgressBar: true,
            iconColor: "white",
            customClass: {
              popup: "colored-toast",
            },
          });
        } else if (result == 'invalid file type') {
          Swal.fire({
            title: "Invalid file type",
            text: "File type must be pdf, docx, xlsx & pptx",
            icon: "error",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 1500,
            width: 450,
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
  
  $tbl_files.on("click", ".btn_activate_file", function () {
    var id = $(this).attr("data-id");

    $.ajax({
      url: "../../model/FileModel.php?action=activateFile",
      type: "POST",
      data: { id: id },
      success: function (result) {
        if (result == "success") {
          Swal.fire({
            title: 'File activated!',
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
          $("#tbl_files").DataTable().ajax.reload();
        }
      },
    });
  });

  $tbl_files.on("click", ".btn_deactivate_file", function () {
    var id = $(this).attr("data-id");

    $.ajax({
      url: "../../model/FileModel.php?action=deactivateFile",
      type: "POST",
      data: { id: id },
      success: function (result) {
        if (result == "success") {
          Swal.fire({
            title: 'File deactivated!',
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
          $("#tbl_files").DataTable().ajax.reload();
        }
      },
    });
  });

});
