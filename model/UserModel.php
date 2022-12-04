<?php 
  include_once('../database/connection.php');

  if($_GET['action'] == 'loadUserDetails') {
    $query = "SELECT * FROM user_accounts";

    $data = mysqli_query($con, $query);

    $output = [];

    $count = 0;

  
    while($row = mysqli_fetch_assoc($data)) {
      
      $count++;

      $output[] = [
        'id' => $count,
        'userid' => $row['user_id'],
        'fullname' => $row['first_name']." ".$row['middle_name']." ".$row['last_name'],
        'phone' => $row['phone_no'],
        'email' => $row['email'],
        'address' => $row['address'],
        'username' => $row['username'],
        'role' => $row['is_admin'] == 1 ? 'Admin' : 'User',
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'date_added' => date('F d, Y', strtotime($row['date_added'])),
        'action' => "
                      <button class='btn btn-success btn-sm btn_edit_user' title='Edit details' data-id='{$row['id']}'>
                        <i class='fas fa-edit'></i>
                      </button>
                      <button class='btn btn-primary btn-sm' title='Reset password'>
                        <i class='fas fa-sync'></i>
                      </button>
                      <button class='btn btn-danger btn-sm' title='Deactivate'>
                        <i class='fas fa-user-times'></i>
                      </button>
                    "
      ];
    }

    echo json_encode($output);

  } else if($_GET['action'] == 'addUserDetails') {
    $userid = random_int(100000, 999999);
    $fname = $_POST['txt_fname'];
    $mname = $_POST['txt_mname'];
    $lname = $_POST['txt_lname'];
    $phone = $_POST['txt_phone'];
    $email = $_POST['txt_email'];
    $address = $_POST['txt_address'];
    $username = $_POST['txt_username'];
    $password = "IETI_".date('Y');
    $role = $_POST['slc_role'];
    $date_added = date('Y-m-d H:i:s');

    $query = "INSERT INTO user_accounts (user_id, first_name, middle_name, last_name, phone_no, email, address, username, password, is_admin, status, date_added) VALUES ('$userid', '$fname', '$mname', '$lname', '$phone', '$email', '$address', '$username', '$password', '$role', 1, '$date_added')";

    $result = mysqli_query($con, $query);

    if($result) {
      echo 'success';
    } else {
      echo 'error';
    }
  } else if($_GET['action'] == 'getUserDetails') {
    $query = "SELECT id, first_name, middle_name, last_name, phone_no, email, address, username, is_admin FROM user_accounts WHERE id = {$_GET['id']}";
    $data = mysqli_query($con, $query);
    
    $row = mysqli_fetch_assoc($data);

    echo json_encode($row);

  } else if($_GET['action'] == 'updateUserDetails') {

    $query = "UPDATE user_accounts SET first_name = '{$_POST['txt_edit_fname']}', middle_name = '{$_POST['txt_edit_mname']}', last_name = '{$_POST['txt_edit_lname']}', phone_no = '{$_POST['txt_edit_phone']}', email = '{$_POST['txt_edit_email']}', address = '{$_POST['txt_edit_address']}', username = '{$_POST['txt_edit_username']}', is_admin = '{$_POST['slc_edit_role']}' WHERE id = {$_POST['txt_user_id']}";

    $result = mysqli_query($con, $query);

    if($result) {
      echo 'success';
    } else {
      echo 'error';
    }

  }