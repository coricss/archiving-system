<?php 
  include_once('../database/connection.php');

  if($_GET['action'] == 'loadUsers') {
    $query = "SELECT * FROM user_accounts";

    $data = mysqli_query($con, $query);

    $output = [];

    if(mysqli_num_rows($data) > 0) {
      while($row = mysqli_fetch_assoc($data)) {
        $output[] = [
          'id' => $row['id'],
          'fullname' => $row['first_name']." ".$row['middle_name']." ".$row['last_name'],
          'phone' => $row['phone_no'],
          'email' => $row['email'],
          'address' => $row['address'],
          'username' => $row['username'],
          'role' => $row['is_admin'] == 1 ? 'Admin' : 'User',
          'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
          'action' => "
                        <button class='btn btn-success btn-sm'>
                          <i class='fas fa-edit'></i>
                          Edit
                        </button>
                        <button class='btn btn-danger btn-sm'>
                          <i class='fas fa-user-times'></i>
                          Deactivate
                        </button>
                      "
        ];
      }

      echo json_encode($output);

    }
  }