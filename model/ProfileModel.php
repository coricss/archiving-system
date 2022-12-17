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
  }