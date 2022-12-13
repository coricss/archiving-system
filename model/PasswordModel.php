<?php
  include_once('../database/connection.php');
  
  if(!isset($_SESSION)) {
    session_start();
  }

  if ($_GET['action'] == 'updateAdminPassword') {

    $userid = $_SESSION['id'];
    $newpassword = $_POST['new_password'];
    $confirmpassword = $_POST['confirm_new_password'];


    $query = "SELECT * FROM user_accounts WHERE user_id = '$userid'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    
    if ($newpassword == $confirmpassword) {
      $hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
      $query = $con->query("UPDATE user_accounts SET password = '$hashedpassword' WHERE id = '$userid'");
      echo 'success';
    } else {
      echo 'error';
    }
    
  } 