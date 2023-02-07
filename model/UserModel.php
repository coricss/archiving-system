<?php 
  include_once('../database/connection.php');

  if($_GET['action'] == 'loadUserDetails') {
    $query = "SELECT * FROM user_accounts ORDER BY id";

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
        'role' => $row['is_admin'] == 1 ? 'Admin' : ($row['is_admin'] == 2 ? 'Director' : 'User'),
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'date_added' => date('M d, Y - h:i A', strtotime($row['date_added'])),
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
    $fname = mysqli_real_escape_string($con, $_POST['txt_fname']);
    $mname = mysqli_real_escape_string($con, $_POST['txt_mname']);
    $lname = mysqli_real_escape_string($con, $_POST['txt_lname']);
    $phone = mysqli_real_escape_string($con, $_POST['txt_phone']);
    $email = mysqli_real_escape_string($con, $_POST['txt_email']);
    $address = mysqli_real_escape_string($con, $_POST['txt_address']);
    $username = mysqli_real_escape_string($con, $_POST['txt_username']);
    $password = password_hash("IETI_".$userid, PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($con, $_POST['slc_role']);
    $date_added = date('Y-m-d H:i:s');
    $picture = time().mysqli_real_escape_string($con, $_FILES['file_picture']['name']);
    $file_loc = "../assets/dist/img/users/".$picture;

    $name_sql = "SELECT * FROM user_accounts WHERE first_name = '$fname' AND last_name = '$lname'";
    $user_name = mysqli_query($con, $name_sql);

    $email_sql = "SELECT * FROM user_accounts WHERE email = '$email' OR username = '$username'";
    $email_username = mysqli_query($con, $email_sql);


  
    if(mysqli_num_rows($user_name) > 0) {

      echo 'user_exists';

    } else if(mysqli_num_rows($email_username) > 0){

      echo 'email_exists';
      
    } else if($role == 2) {
      
      $director_sql = "SELECT * FROM user_accounts WHERE is_admin = 2 AND status = 1";
      $director = mysqli_query($con, $director_sql);

      if(mysqli_num_rows($director) > 0){

        echo 'director_exists';
        
      } else {
        if($_FILES['file_picture']['name'] != '') {
          move_uploaded_file($_FILES["file_picture"]["tmp_name"], $file_loc);
  
          $query = "INSERT INTO user_accounts (user_id, picture, first_name, middle_name, last_name, phone_no, email, address, username, password, is_admin, status, bg_theme_id, login_attempts, date_added) VALUES ('$userid', '$picture', '$fname', '$mname', '$lname', '$phone', '$email', '$address', '$username', '$password', '$role', 1, 1, 3, '$date_added')";
  
        } else {
          $query = "INSERT INTO user_accounts (user_id, picture, first_name, middle_name, last_name, phone_no, email, address, username, password, is_admin, status, bg_theme_id, login_attempts, date_added) VALUES ('$userid', 'default.png', '$fname', '$mname', '$lname', '$phone', '$email', '$address', '$username', '$password', '$role', 1, 1, 3, '$date_added')";
        }
  
        $result = mysqli_query($con, $query);
  
        if($result) {
          echo 'success';
        } else {
          echo 'error';
        }
      }

    } else {

      if($_FILES['file_picture']['name'] != '') {
        move_uploaded_file($_FILES["file_picture"]["tmp_name"], $file_loc);

        $query = "INSERT INTO user_accounts (user_id, picture, first_name, middle_name, last_name, phone_no, email, address, username, password, is_admin, status, bg_theme_id, login_attempts, date_added) VALUES ('$userid', '$picture', '$fname', '$mname', '$lname', '$phone', '$email', '$address', '$username', '$password', '$role', 1, 1, 3, '$date_added')";

      } else {
        $query = "INSERT INTO user_accounts (user_id, picture, first_name, middle_name, last_name, phone_no, email, address, username, password, is_admin, status, bg_theme_id, login_attempts, date_added) VALUES ('$userid', 'default.png', '$fname', '$mname', '$lname', '$phone', '$email', '$address', '$username', '$password', '$role', 1, 1, 3, '$date_added')";
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

    $picture = time().mysqli_real_escape_string($con, $_FILES['file_edit_picture']['name']);
    $file_loc = "../assets/dist/img/users/".$picture;

    $user_id = mysqli_real_escape_string($con, $_POST['txt_user_id']);
    $txt_edit_fname = mysqli_real_escape_string($con, $_POST['txt_edit_fname']);
    $txt_edit_lname = mysqli_real_escape_string($con, $_POST['txt_edit_lname']);
    $txt_edit_mname = mysqli_real_escape_string($con, $_POST['txt_edit_mname']);

    $txt_edit_email = mysqli_real_escape_string($con, $_POST['txt_edit_email']);
    $txt_edit_username = mysqli_real_escape_string($con, $_POST['txt_edit_username']);

    $txt_edit_phone = mysqli_real_escape_string($con, $_POST['txt_edit_phone']);
    $txt_edit_address = mysqli_real_escape_string($con, $_POST['txt_edit_address']);
    $slc_edit_role = mysqli_real_escape_string($con, $_POST['slc_edit_role']);

    $userImg = "SELECT picture FROM user_accounts WHERE id = $user_id";
    $data = mysqli_query($con, $userImg);
    $row = mysqli_fetch_assoc($data);

    $user_name = "SELECT * FROM user_accounts WHERE first_name = '$txt_edit_fname' AND last_name = '$txt_edit_lname' AND id != $user_id";
    $username_result = mysqli_query($con, $user_name);

    $email_username = "SELECT * FROM user_accounts WHERE (email = '$txt_edit_email' OR username = '$txt_edit_username') AND id != $user_id";
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
          } 
          $query = "UPDATE user_accounts SET picture = '$picture', first_name = '$txt_edit_fname', middle_name = '$txt_edit_mname', last_name = '$txt_edit_lname', phone_no = '$txt_edit_phone', email = '$txt_edit_email', address = '$txt_edit_address', username = '$txt_edit_username', is_admin = '$slc_edit_role' WHERE id = $user_id";
          
        } else {
          $query = "UPDATE user_accounts SET first_name = '$txt_edit_fname', middle_name = '$txt_edit_mname', last_name = '$txt_edit_lname', phone_no = '$txt_edit_phone', email = '$txt_edit_email', address = '$txt_edit_address', username = '$txt_edit_username', is_admin = '$slc_edit_role' WHERE id = $user_id";
        }
      } else {
        $query = "UPDATE user_accounts SET first_name = '$txt_edit_fname', middle_name = '$txt_edit_mname', last_name = '$txt_edit_lname', phone_no = '$txt_edit_phone', email = '$txt_edit_email', address = '$txt_edit_address', username = '$txt_edit_username', is_admin = '$slc_edit_role' WHERE id = $user_id";
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

    $sql = "SELECT * FROM user_accounts WHERE id = {$_POST['id']}";
    $data = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($data);

    $user_id = $row['user_id'];

    $password = password_hash("IETI_".$user_id, PASSWORD_DEFAULT);

    $query = "UPDATE user_accounts SET password = '$password' WHERE id = {$_POST['id']}";
    // $2y$10$jmKrofwnN7983ZAb8eb8huVCoUr1tdZubSfUtpKGKORjF9c54tc0u
    $result = mysqli_query($con, $query);

    if($result) {
      echo 'success';
    } else {
      echo 'error';
    }
  }