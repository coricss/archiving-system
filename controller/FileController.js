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
        title: "Digital Archiving System File Types",
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
        title: "Digital Archiving System File Types",
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
  $('#sel_file_type').select2({
    theme: 'bootstrap4',
    dropdownPosition: 'below',
    width: '100%',
    placeholder: 'File type',
  });
  $('#sel_owner').select2({
    theme: 'bootstrap4',
    dropdownPosition: 'below',
    width: '100%',
    placeholder: 'Owner',
  });
  $('#sel_batch').select2({
    theme: 'bootstrap4',
    dropdownPosition: 'below',
    width: '100%',
    placeholder: 'Batch',
  });
  $('#sel_date_uploaded').select2({
    theme: 'bootstrap4',
    dropdownPosition: 'below',
    width: '100%',
    placeholder: 'Date Uploaded',
  });

  var $tbl_files = $("#tbl_files").DataTable({
    dom: "Bfrtip",
    // processing: true,
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
      { data: "batch" },
      { data: "binary" },
      { data: "status" },
      { data: "action" }
    ],
    deferRender: true,
    lengthChange: false,
    columnDefs: [
      {
        targets: [8],
        className: "text-center",
        render: function (data, type, row) {
          return `<a href="../../storage/binary_files/${data}" target="_blank"><i class="fas fa-download"></i></a>`;
        }
      },
      { targets: [9, 10], className: "text-center", orderable: false },
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

          $('#slc_batch').select2({
            theme: 'bootstrap4',
            dropdownPosition: 'below'
          });
        
          var select = document.getElementById("slc_batch");
          var currentYear = new Date().getFullYear();
          var yearEstablished = 2017;
          var yearDiff = currentYear - yearEstablished;
        
          for (var i = currentYear; i >= currentYear - yearDiff; i--) {
            var option = document.createElement("option");
            option.value = i;
            option.text = i;
            select.appendChild(option);
          }
        },
      },
      {
        text: '<i class="fas fa-download"></i> Export',
        title: "Digital Archiving System Files",
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
        title: "Digital Archiving System Files",
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
          $("#sel_file_type, #sel_owner, #sel_batch, #sel_date_uploaded").val("ALL").trigger("change");
        },
      },
    ],
    initComplete: function(settings, json) {
      var api = this.api();

      // FILE TYPE FILTER
      api.columns(4).each(function (index) {
        var column = this;

        var select = $('#sel_file_type');

        var option = api.columns(4).data()[0].length > 0 ? '<option value="ALL">File type</option>' : '<option value=""></option>';

        select.empty().html(option).select2().on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            var search = val !== 'ALL' ? val : '';

            column
                .search(search ? '^' + search + '$' : '', true, false)
                .draw();
        }).val('').trigger('change.select2');

        api.column(4).data().unique().sort().each(function (value, j) {
            if (value !== null) {
                select.append('<option value="' + value + '">' + value + '</option>');
            }
        });

        select.select2({
            theme: 'bootstrap4',
            dropdownPosition: 'below',
            placeholder: 'Select category name'
        })
      });

      // OWNER FILTER
      api.columns(2).each(function (index) {
        var column = this;

        var select = $('#sel_owner');

        var option = api.columns(2).data()[0].length > 0 ? '<option value="ALL">Owner</option>' : '<option value=""></option>';

        select.empty().html(option).select2().on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            var search = val !== 'ALL' ? val : '';

            column
                .search(search ? '^' + search + '$' : '', true, false)
                .draw();
        }).val('').trigger('change.select2');

        api.column(2).data().unique().sort().each(function (value, j) {
            if (value !== null) {
                select.append('<option value="' + value + '">' + value + '</option>');
            }
        });

        select.select2({
            theme: 'bootstrap4',
            dropdownPosition: 'below',
            placeholder: 'Select category name'
        })
      });

      // BATCH FILTER
      api.columns(7).each(function (index) {
        var column = this;

        var select = $('#sel_batch');

        var option = api.columns(7).data()[0].length > 0 ? '<option value="ALL">Batch</option>' : '<option value=""></option>';

        select.empty().html(option).select2().on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            var search = val !== 'ALL' ? val : '';

            column
                .search(search ? '^' + search + '$' : '', true, false)
                .draw();
        }).val('').trigger('change.select2');

        api.column(7).data().unique().sort().each(function (value, j) {
            if (value !== null) {
                select.append('<option value="' + value + '">' + value + '</option>');
            }
        });

        select.select2({
            theme: 'bootstrap4',
            dropdownPosition: 'below',
            placeholder: 'Select category name'
        })
      });

      // DATE UPLOADED FILTER
      api.columns(6).each(function (index) {
        var column = this;

        var select = $('#sel_date_uploaded');

        var option = api.columns(6).data()[0].length > 0 ? '<option value="ALL">Date Uploaded</option>' : '<option value=""></option>';

        select.empty().html(option).select2().on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            var search = val !== 'ALL' ? val : '';

            column
                .search(search ? '^' + search + '$' : '', true, false)
                .draw();
        }).val('').trigger('change.select2');

        api.column(6).data().unique().sort().each(function (value, j) {
            if (value !== null) {
                select.append('<option value="' + value + '">' + value + '</option>');
            }
        });

        select.select2({
            theme: 'bootstrap4',
            dropdownPosition: 'below',
            placeholder: 'Select category name'
        })
      });
    }
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
        $("#slc_edit_batch").html(`<option value=${result.batch}>${result.batch}</option>`);

        $('#slc_edit_batch').select2({
          theme: 'bootstrap4',
          dropdownPosition: 'below'
        });
      
        var select = document.getElementById("slc_edit_batch");
        var currentYear = new Date().getFullYear();
        var yearEstablished = 2017;
        var yearDiff = currentYear - yearEstablished;
      
        for (var i = currentYear; i >= currentYear - yearDiff; i--) {
          var option = document.createElement("option");
          option.value = i;
          option.text = i;
          select.appendChild(option);
        }

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

  var $tbl_old_files = $("#tbl_old_files").DataTable({
    dom: "Bfrtip",
    // processing: true,
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
      url: "../../model/FileModel.php?action=loadOldFiles",
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
      { data: "batch" },
      { data: "status" },
      { data: "action" },
    ],
    deferRender: true,
    lengthChange: false,
    columnDefs: [
      { targets: [8, 9], className: "text-center", orderable: false },
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
        text: '<i class="fas fa-download"></i> Export',
        title: "Digital Archiving System Old Files",
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
        title: "Digital Archiving System Old Files",
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
          $("#tbl_old_files").DataTable().ajax.reload();
          $("#tbl_old_files").DataTable().order([0, "asc"]).draw();
          $("#sel_file_type, #sel_owner, #sel_batch, #sel_date_uploaded").val("ALL").trigger("change");
        },
      },
    ],
    initComplete: function(settings, json) {
      var api = this.api();

      // FILE TYPE FILTER
      api.columns(4).each(function (index) {
        var column = this;

        var select = $('#sel_file_type');

        var option = api.columns(4).data()[0].length > 0 ? '<option value="ALL">File type</option>' : '<option value=""></option>';

        select.empty().html(option).select2().on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            var search = val !== 'ALL' ? val : '';

            column
                .search(search ? '^' + search + '$' : '', true, false)
                .draw();
        }).val('').trigger('change.select2');

        api.column(4).data().unique().sort().each(function (value, j) {
            if (value !== null) {
                select.append('<option value="' + value + '">' + value + '</option>');
            }
        });

        select.select2({
            theme: 'bootstrap4',
            dropdownPosition: 'below',
            placeholder: 'Select category name'
        })
      });

      // OWNER FILTER
      api.columns(2).each(function (index) {
        var column = this;

        var select = $('#sel_owner');

        var option = api.columns(2).data()[0].length > 0 ? '<option value="ALL">Owner</option>' : '<option value=""></option>';

        select.empty().html(option).select2().on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            var search = val !== 'ALL' ? val : '';

            column
                .search(search ? '^' + search + '$' : '', true, false)
                .draw();
        }).val('').trigger('change.select2');

        api.column(2).data().unique().sort().each(function (value, j) {
            if (value !== null) {
                select.append('<option value="' + value + '">' + value + '</option>');
            }
        });

        select.select2({
            theme: 'bootstrap4',
            dropdownPosition: 'below',
            placeholder: 'Select category name'
        })
      });

      // BATCH FILTER
      api.columns(7).each(function (index) {
        var column = this;

        var select = $('#sel_batch');

        var option = api.columns(7).data()[0].length > 0 ? '<option value="ALL">Batch</option>' : '<option value=""></option>';

        select.empty().html(option).select2().on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            var search = val !== 'ALL' ? val : '';

            column
                .search(search ? '^' + search + '$' : '', true, false)
                .draw();
        }).val('').trigger('change.select2');

        api.column(7).data().unique().sort().each(function (value, j) {
            if (value !== null) {
                select.append('<option value="' + value + '">' + value + '</option>');
            }
        });

        select.select2({
            theme: 'bootstrap4',
            dropdownPosition: 'below',
            placeholder: 'Select category name'
        })
      });

      // DATE UPLOADED FILTER
      api.columns(6).each(function (index) {
        var column = this;

        var select = $('#sel_date_uploaded');

        var option = api.columns(6).data()[0].length > 0 ? '<option value="ALL">Date Uploaded</option>' : '<option value=""></option>';

        select.empty().html(option).select2().on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            var search = val !== 'ALL' ? val : '';

            column
                .search(search ? '^' + search + '$' : '', true, false)
                .draw();
        }).val('').trigger('change.select2');

        api.column(6).data().unique().sort().each(function (value, j) {
            if (value !== null) {
                select.append('<option value="' + value + '">' + value + '</option>');
            }
        });

        select.select2({
            theme: 'bootstrap4',
            dropdownPosition: 'below',
            placeholder: 'Select category name'
        })
      });
    }
  });

  // align dt-buttons to filter
  $("#tbl_old_files_filter").addClass("float-right");
  $(".btn-group").addClass("float-left");

  $tbl_old_files.on("click", ".btn_delete_file", function () {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if(result.isConfirmed) {
        var file_id = $(this).attr('data-id');
        $.ajax({
          url: "../../model/FileModel.php?action=deleteOldFile",
          type: "POST",
          data: {
            file_id: file_id,
          },
          cache: false,
          success: function (response) {
            if (response == "success") {
              Swal.fire({
                title: "Successfully Deleted!",
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
              $("#tbl_old_files").DataTable().ajax.reload();
            } else {
              Swal.fire({
                title: "Something went wrong!",
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
              $("#tbl_old_files").DataTable().ajax.reload();
            }
          }
        });
      }
    });
  })
});
