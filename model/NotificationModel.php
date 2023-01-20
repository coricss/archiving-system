<?php
  include_once('../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  if($_GET['action'] == 'countNotif') {
    $user_id = $_SESSION['user_id'];

    $query_admin_notif = "SELECT * FROM notifications WHERE user_id != $user_id OR processed_by != $user_id";
    $result_admin_notif = mysqli_query($con, $query_admin_notif);

    $count_admin_notif = mysqli_num_rows($result_admin_notif);

    $query_user_notif = "SELECT * FROM notifications WHERE activity != 'request'";

    $result_user_notif = mysqli_query($con, $query_user_notif);

    $count_user_notif = mysqli_num_rows($result_user_notif);

    $notif_array = [
      'admin_notif' => $count_admin_notif,
      'user_notif' => $count_user_notif
    ];

    echo json_encode($notif_array);
  }