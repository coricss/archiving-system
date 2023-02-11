<?php
  include_once('../database/connection.php');
  include_once('../email/EmailNotification.php');
  session_start();

  if($_GET['action'] == 'userLogin'){
    $userid = mysqli_real_escape_string($con, $_POST['txt_userid']);
    $password = mysqli_real_escape_string($con, $_POST['txt_userpassword']);

    $query = "SELECT * FROM user_accounts WHERE user_id = '$userid' OR username ='$userid'";
    $result = mysqli_query($con, $query);

 
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0 ) {
      if ($row['status'] == 1) {
        if(($row['user_id']==$userid || $row['username'] == $userid) && (password_verify($password, $row['password']))){
          if ($row['is_admin'] == 1) {

            $_SESSION['id'] = $row['id'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['fullname'] = $row['first_name'] . ' ' . $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_name'] = $row['username'];
            $_SESSION['user_role'] = $row['is_admin'];
            $_SESSION['user_picture'] = $row['picture'];
            $_SESSION['user_type'] = 'admin';

            echo 'admin';
          } else if ($row['is_admin'] == 2) {

            $_SESSION['id'] = $row['id'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['fullname'] = $row['first_name'] . ' ' . $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_name'] = $row['username'];
            $_SESSION['user_role'] = $row['is_admin'];
            $_SESSION['user_picture'] = $row['picture'];
            $_SESSION['user_type'] = 'director';

            echo 'director';
          } else {

            $_SESSION['id'] = $row['id'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['fullname'] = $row['first_name'] . ' ' . $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_name'] = $row['username'];
            $_SESSION['user_role'] = $row['is_admin'];
            $_SESSION['user_picture'] = $row['picture'];
            $_SESSION['user_type'] = 'user';

            echo 'user';
          }

          $sql = "UPDATE user_accounts SET login_attempts = 3 WHERE user_id = '$userid' OR username ='$userid'";
          $result = mysqli_query($con, $sql);
          
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
  } else {
    echo 'no user found';
  }
    

    
  } else if ($_GET['action'] == 'sendCode') {
      $email = mysqli_real_escape_string($con, $_POST['registered_email']);

      $query = "SELECT * FROM user_accounts WHERE email = '$email'";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_assoc($result);

      $_SESSION['id'] = $row['id'];

      if(mysqli_num_rows($result) > 0 ) {
        $code = rand(100000, 999999);
        $query = "UPDATE user_accounts SET forgot_pass_code = '$code' WHERE email = '$email'";
        $result = mysqli_query($con, $query);

        sendCode($email, $code);

        echo 'success';

      } else {
        echo 'no email found';
      }

  } else if ($_GET['action'] == 'verifyCode') {
    $code = mysqli_real_escape_string($con, $_POST['recovery_code']);
    $id = $_SESSION['id'];

    $query = "SELECT * FROM user_accounts WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row['forgot_pass_code'] == $code) {

      $user_id = $row['user_id'];

      $password = password_hash("IETI_".$user_id, PASSWORD_DEFAULT);

      $query = "UPDATE user_accounts SET password = '$password' WHERE id = $id";
      $result = mysqli_query($con, $query);

      echo 'success';
    } else {
      echo 'error';
    }

  } else if ($_GET['action'] == 'logoutUser') {
    session_destroy();
    echo 'success';
  }