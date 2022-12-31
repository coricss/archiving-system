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
      url: "../../model/PendingRequestModel.php?action=loadPendingRequestUser",
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
        title: "Digita Archiving System File Requests",
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
        title: "Digita Archiving System File Requests",
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
})