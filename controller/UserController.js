$(function(){
  loadUsers();

  $('#tbl_users').DataTable();
  function loadUsers(){
    $('#tbl_users').DataTable({
      processing: true,
      responsive: true,
      ajax: {
        url: "../../model/UserModel.php?action=loadUsers",
        type: "GET",
        dataType: "json",
        dataSrc: ""
      },
      columns: [
        { data: "id" },
        { data: "fullname" },
        { data: "phone" },
        { data: "email" },
        { data: "address" },
        { data: "username" },
        { data: "role" },
        { data: "status" },
        { data: "action" },
      ],
      columnDefs: [
        {
          targets: [8],
          orderable: false,
          className: "text-center"
        },
      ]
          
    });
    // $.ajax({
    //   url: "../../model/UserModel.php?action=loadUsers",
    //   type: "GET",
    //   dataType: "json",
    //   success: function(result){
    //     $('#tbl_users').DataTable({
    //       dom: 'Bfrtip',
    //       data: result,
    //       columns: [
    //         { data: "id" },
    //         { data: "fullname" },
    //         { data: "phone" },
    //         { data: "email" },
    //         { data: "address" },
    //         { data: "username" },
    //         { data: "role" },
    //         { data: "status" },
    //         { data: "action" },
    //       ]
    //     });
  
    //     console.log(result);
    //   }
    // });
  }
  
})