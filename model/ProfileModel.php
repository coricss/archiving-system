<?php 
  include_once('../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  if($_GET['action'] == 'loadProfile'){
    $userid = $_SESSION['user_id'];
    $query = "SELECT * FROM user_accounts WHERE user_id = '$userid'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $data = array(
      'user_id' => $row['user_id'],
      'first_name' => $row['first_name'],
      'last_name' => $row['last_name'],
      'middle_name' => $row['middle_name'],
      'username' => $row['username'],
      'email' => $row['email'],
      'phone' => $row['phone_no'],
      'address' => $row['address'],
      'picture' => $row['picture'],
      'status' => $row['status'],
      'is_admin' => $row['is_admin'],
      'login_attempts' => $row['login_attempts'],
      'date_added' => $row['date_added']
    );
    echo json_encode($data);
  } else if($_GET['action'] == 'checkUserIfExists'){

    $edit_firstname = $_POST['edit_first_name'];
    $edit_lastname = $_POST['edit_last_name'];

    $edit_username = $_POST['edit_username'];

    $edit_email = $_POST['edit_email'];
    
    $name_sql = "SELECT first_name, last_name  FROM user_accounts WHERE first_name = '$edit_firstname' AND last_name = '$edit_lastname' AND user_id != '$_SESSION[user_id]'";
    $user_name = mysqli_query($con, $name_sql);

    $username_sql = "SELECT username  FROM user_accounts WHERE username = '$edit_username' AND user_id != '$_SESSION[user_id]'";
    $username = mysqli_query($con, $username_sql);

    $email_sql = "SELECT email  FROM user_accounts WHERE email = '$edit_email' AND user_id != '$_SESSION[user_id]'";
    $email = mysqli_query($con, $email_sql);

    if(mysqli_num_rows($user_name) > 0){
      echo 'user_exists';
    } else if(mysqli_num_rows($username) > 0){
      echo 'username_exists';
    } else if(mysqli_num_rows($email) > 0){
      echo 'email_exists';
    }


  }else if ($_GET['action'] == 'checkCurrentPassword'){

    $userid = $_SESSION['user_id'];

    $current_password = $_POST['current_password'];
    // $current_password = 'Admin_22';

    $query = "SELECT * FROM user_accounts WHERE user_id = '$userid'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if(password_verify($current_password, $row['password'])){
      echo 'success';
    } else {
      echo 'error';
    }
  } else if ($_GET['action'] == 'updateProfile'){

    $userid = $_SESSION['user_id'];

    $edit_firstname = $_POST['edit_first_name'];
    $edit_lastname = $_POST['edit_last_name'];
    $edit_middlename = $_POST['edit_middle_name'];
    $edit_username = $_POST['edit_username'];
    $edit_email = $_POST['edit_email'];
    $edit_phone = $_POST['edit_phone'];
    $edit_address = $_POST['edit_address'];

    $query = "UPDATE user_accounts SET first_name = '$edit_firstname', last_name = '$edit_lastname', middle_name = '$edit_middlename', username = '$edit_username', email = '$edit_email', phone_no = '$edit_phone', address = '$edit_address' WHERE user_id = '$userid'";

    if(mysqli_query($con, $query)){
      echo 'success';
    } else {
      echo 'error';
    }

  } else if ($_GET['action'] == 'updatePicture') {

    $userid = $_SESSION['user_id'];

    $picture = time().$_FILES['profile-picture']['name'];
    $file_loc = "../assets/dist/img/users/".$picture;

    $userImg = "SELECT picture FROM user_accounts WHERE user_id = '$userid'";
    $data = mysqli_query($con, $userImg);
    $row = mysqli_fetch_assoc($data);

    if($row['picture'] != 'default.png'){
      unlink("../assets/dist/img/users/".$row['picture']);

      $picture_tmp = $_FILES['profile-picture']['tmp_name'];

      $query = "UPDATE user_accounts SET picture = '$picture' WHERE user_id = '$userid'";

      if(mysqli_query($con, $query)){
        move_uploaded_file($picture_tmp, '../assets/dist/img/users/'.$picture);
        echo 'success';
      } else {
        echo 'error';
      }
    }

  } else if ($_GET['action'] == 'deactivateProfile') {
    
    $userid = $_SESSION['user_id'];

    $query = "UPDATE user_accounts SET status = '0' WHERE user_id = '$userid'";

    if(mysqli_query($con, $query)){
      echo 'success';
    } else {
      echo 'error';
    }
  } else if ($_GET['action'] == 'activateProfile') {
    
    $userid = $_SESSION['user_id'];

    $query = "UPDATE user_accounts SET status = '1' WHERE user_id = '$userid'";

    if(mysqli_query($con, $query)){
      echo 'success';
    } else {
      echo 'error';
    }
  }