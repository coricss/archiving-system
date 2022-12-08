<?php
  include_once('../database/connection.php');

  if($_GET['action'] == 'userLogin'){
    $userid = $_POST['txt_userid'];
    $password = $_POST['txt_userpassword'];

    $query = "SELECT * FROM user_accounts WHERE user_id = '$userid' OR username ='$userid'";
    $result = mysqli_query($con, $query);

 
    $row = mysqli_fetch_assoc($result);
  
    if ($row['status'] == 1) {
      if(($row['user_id']==$userid || $row['username'] == $userid) && (password_verify($password, $row['password']))){
        if ($row['is_admin'] == 1) {
          session_start();
          $_SESSION['id'] = $row['id'];
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['fullname'] = $row['first_name'] . ' ' . $row['last_name'];
          $_SESSION['user_name'] = $row['username'];
          $_SESSION['user_role'] = $row['is_admin'];
          $_SESSION['user_picture'] = $row['picture'];
          $_SESSION['user_type'] = 'admin';
  
          echo 'admin';
        } else {
          session_start();
          $_SESSION['id'] = $row['id'];
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['fullname'] = $row['first_name'] . ' ' . $row['last_name'];
          $_SESSION['user_name'] = $row['username'];
          $_SESSION['user_role'] = $row['is_admin'];
          $_SESSION['user_picture'] = $row['picture'];
          $_SESSION['user_type'] = 'user';
          echo 'user';
        }
      } else {
        
        //login attempts
        $query = "SELECT * FROM user_accounts WHERE user_id = '$userid' OR username ='$userid'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $attempts = $row['login_attempts'];
        $attempts = $attempts - 1;
        $query = "UPDATE user_accounts SET login_attempts = '$attempts' WHERE user_id = '$userid' OR username ='$userid'";
        $result = mysqli_query($con, $query);
  
        //check if account is locked
        $query = "SELECT * FROM user_accounts WHERE user_id = '$userid' OR username ='$userid'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $attempts = $row['login_attempts'];
        $status = $row['status'];
        if ($attempts <= 0 && $status == 1) {
          $query = "UPDATE user_accounts SET status = 0 WHERE user_id = '$userid' OR username ='$userid'";
          $result = mysqli_query($con, $query);
        }

        $data = [
          'attempts' => $attempts,
          'data' => 'error'
        ];

        echo json_encode($data);
      }
    } else {
      echo 'locked';
    }
    

    
  } else if ($_GET['action'] == 'logoutUser') {
    session_start();
    session_destroy();
    echo 'success';
  }