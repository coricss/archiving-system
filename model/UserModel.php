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
        'picture' => $row['picture'],
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
                      <button class='btn btn-primary btn-sm btn_reset_password' title='Reset password' data-id='{$row['id']}'>
                        <i class='fas fa-sync'></i>
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
    $password = password_hash("IETI_".date('Y'), PASSWORD_DEFAULT);
    $role = $_POST['slc_role'];
    $date_added = date('Y-m-d H:i:s');
    $picture = time().$_FILES['file_picture']['name'];
    $file_loc = "../assets/dist/img/users/".$picture;

    $name_sql = "SELECT * FROM user_accounts WHERE first_name = '$fname' AND last_name = '$lname'";
    $user_name = mysqli_query($con, $name_sql);

    $email_sql = "SELECT * FROM user_accounts WHERE email = '$email' OR username = '$username'";
    $email_username = mysqli_query($con, $email_sql);

    if(mysqli_num_rows($user_name) > 0) {

      echo 'user_exists';

    } else if(mysqli_num_rows($email_username) > 0){

      echo 'email_exists';
      
    } else {

      if($_FILES['file_picture']['name'] != '') {
        move_uploaded_file($_FILES["file_picture"]["tmp_name"], $file_loc);

        $query = "INSERT INTO user_accounts (user_id, picture, first_name, middle_name, last_name, phone_no, email, address, username, password, is_admin, status, login_attempts, date_added) VALUES ('$userid', '$picture', '$fname', '$mname', '$lname', '$phone', '$email', '$address', '$username', '$password', '$role', 1, 3, '$date_added')";

      } else {
        $query = "INSERT INTO user_accounts (user_id, picture, first_name, middle_name, last_name, phone_no, email, address, username, password, is_admin, status, login_attempts, date_added) VALUES ('$userid', 'default.png', '$fname', '$mname', '$lname', '$phone', '$email', '$address', '$username', '$password', '$role', 1, 3, '$date_added')";
      }

      $result = mysqli_query($con, $query);

      if($result) {
        echo 'success';
      } else {
        echo 'error';
      }
    }
  } else if($_GET['action'] == 'getUserDetails') {
    $query = "SELECT id, picture, first_name, middle_name, last_name, phone_no, email, address, username, is_admin, status FROM user_accounts WHERE id = {$_GET['id']}";
    $data = mysqli_query($con, $query);
    
    $row = mysqli_fetch_assoc($data);

    echo json_encode($row);

  } else if($_GET['action'] == 'updateUserDetails') {

    $picture = time().$_FILES['file_edit_picture']['name'];
    $file_loc = "../assets/dist/img/users/".$picture;

    $userImg = "SELECT picture FROM user_accounts WHERE id = {$_POST['txt_user_id']}";
    $data = mysqli_query($con, $userImg);
    $row = mysqli_fetch_assoc($data);

    $user_name = "SELECT * FROM user_accounts WHERE first_name = '{$_POST['txt_edit_fname']}' AND last_name = '{$_POST['txt_edit_lname']}' AND id != {$_POST['txt_user_id']}";
    $username_result = mysqli_query($con, $user_name);

    $email_username = "SELECT * FROM user_accounts WHERE (email = '{$_POST['txt_edit_email']}' OR username = '{$_POST['txt_edit_username']}') AND id != {$_POST['txt_user_id']}";
    $email_username_result = mysqli_query($con, $email_username);

    if(mysqli_num_rows($username_result) > 0){
      echo 'user_exists';
    } else if (mysqli_num_rows($email_username_result) > 0) {
      echo 'email_exists';
    } else {

      if($_FILES['file_edit_picture']['name'] != '') {
        if(move_uploaded_file($_FILES['file_edit_picture']['tmp_name'], $file_loc)){
          if($row['picture'] != 'default.png') {
            unlink("../assets/dist/img/users/".$row['picture']);

            $query = "UPDATE user_accounts SET picture = '$picture', first_name = '{$_POST['txt_edit_fname']}', middle_name = '{$_POST['txt_edit_mname']}', last_name = '{$_POST['txt_edit_lname']}', phone_no = '{$_POST['txt_edit_phone']}', email = '{$_POST['txt_edit_email']}', address = '{$_POST['txt_edit_address']}', username = '{$_POST['txt_edit_username']}', is_admin = '{$_POST['slc_edit_role']}' WHERE id = {$_POST['txt_user_id']}";
          } else {
            $query = "UPDATE user_accounts SET picture = '$picture', first_name = '{$_POST['txt_edit_fname']}', middle_name = '{$_POST['txt_edit_mname']}', last_name = '{$_POST['txt_edit_lname']}', phone_no = '{$_POST['txt_edit_phone']}', email = '{$_POST['txt_edit_email']}', address = '{$_POST['txt_edit_address']}', username = '{$_POST['txt_edit_username']}', is_admin = '{$_POST['slc_edit_role']}' WHERE id = {$_POST['txt_user_id']}";
          }
        } else {
          $query = "UPDATE user_accounts SET first_name = '{$_POST['txt_edit_fname']}', middle_name = '{$_POST['txt_edit_mname']}', last_name = '{$_POST['txt_edit_lname']}', phone_no = '{$_POST['txt_edit_phone']}', email = '{$_POST['txt_edit_email']}', address = '{$_POST['txt_edit_address']}', username = '{$_POST['txt_edit_username']}', is_admin = '{$_POST['slc_edit_role']}' WHERE id = {$_POST['txt_user_id']}";
        }
      } else {
        $query = "UPDATE user_accounts SET first_name = '{$_POST['txt_edit_fname']}', middle_name = '{$_POST['txt_edit_mname']}', last_name = '{$_POST['txt_edit_lname']}', phone_no = '{$_POST['txt_edit_phone']}', email = '{$_POST['txt_edit_email']}', address = '{$_POST['txt_edit_address']}', username = '{$_POST['txt_edit_username']}', is_admin = '{$_POST['slc_edit_role']}' WHERE id = {$_POST['txt_user_id']}";
      }

      $result = mysqli_query($con, $query);

      if($result) {
        echo 'success';
      } else {
        echo 'error';
      }
    }

  } else if($_GET['action'] == 'activateUser') {
      $query = "UPDATE user_accounts SET status = 1 WHERE id = {$_POST['id']}";
      $result = mysqli_query($con, $query);

      if($result) {
        echo 'success';
      } else {
        echo 'error';
      }
  } else if($_GET['action'] == 'deactivateUser') {
    $query = "UPDATE user_accounts SET status = 0 WHERE id = {$_POST['id']}";
    $result = mysqli_query($con, $query);

    if($result) {
      echo 'success';
    } else {
      echo 'error';
    }
  } else if($_GET['action'] == 'resetPassword') {
    $password = password_hash("IETI_".date('Y'), PASSWORD_DEFAULT);

    $query = "UPDATE user_accounts SET password = '$password' WHERE id = {$_POST['id']}";
    // $2y$10$jmKrofwnN7983ZAb8eb8huVCoUr1tdZubSfUtpKGKORjF9c54tc0u
    $result = mysqli_query($con, $query);

    if($result) {
      echo 'success';
    } else {
      echo 'error';
    }
  }