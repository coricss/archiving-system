<?php
  include_once('../database/connection.php');
  
  if(!isset($_SESSION)) {
    session_start();
  }

  if ($_GET['action'] == 'updatePassword') {

    $userid = $_SESSION['id'];
    $newpassword = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirmpassword = mysqli_real_escape_string($con, $_POST['confirm_new_password']);

    if ($newpassword == $confirmpassword) {
      $hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
      $query = $con->query("UPDATE user_accounts SET password = '$hashedpassword' WHERE id = '$userid'");
      echo 'success';
    } else {
      echo 'error';
    }
    
  } else if ($_GET['action'] == 'changePassword') {

    $userid = $_SESSION['id'];
    $oldpassword = mysqli_real_escape_string($con, $_POST['update_current_password']);
    $newpassword = mysqli_real_escape_string($con, $_POST['update_new_password']);
    $confirmpassword = mysqli_real_escape_string($con, $_POST['update_confirm_password']);

    $query = "SELECT * FROM user_accounts WHERE id = '$userid'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    if (password_verify($oldpassword, $row['password'])) {
      if ($newpassword == $confirmpassword) {
        $hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
        $query = $con->query("UPDATE user_accounts SET password = '$hashedpassword' WHERE id = '$userid'");
        echo 'success';
      } else {
        echo 'error';
      }
    } else {
      echo 'wrong password';
    }

  }