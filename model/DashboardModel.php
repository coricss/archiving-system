<?php

  include_once('../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  if($_GET['action'] == 'countData') {

    $count_data = [];
    
    $user_query = "SELECT COUNT(*) AS total_users FROM user_accounts";
    $user_result = mysqli_query($con, $user_query);
    $user_row = mysqli_fetch_assoc($user_result);

    $files_query = "SELECT COUNT(*) AS total_files FROM file_details";
    $files_result = mysqli_query($con, $files_query);
    $files_row = mysqli_fetch_assoc($files_result);

    $approved_files = "SELECT COUNT(*) AS approved_files FROM file_requests WHERE is_approved = 1";
    $approved_files_result = mysqli_query($con, $approved_files);
    $approved_files_row = mysqli_fetch_assoc($approved_files_result);

    $rejected_files = "SELECT COUNT(*) AS rejected_files FROM file_requests WHERE is_approved = 2";
    $rejected_files_result = mysqli_query($con, $rejected_files);
    $rejected_files_row = mysqli_fetch_assoc($rejected_files_result);
    
    $count_data = [
      'total_users' => $user_row['total_users'],
      'total_files' => $files_row['total_files'],
      'approved_files' => $approved_files_row['approved_files'],
      'rejected_files' => $rejected_files_row['rejected_files']
    ];

    echo json_encode($count_data);
  } else if ($_GET['action'] == 'countFileArchivesPerBatch') {

    $years = $_GET['years'];

    $count = count($years);

    for($i=0; $i<$count; $i++) {
      $file_archive_query = "SELECT COUNT(*) AS file_per_batch FROM file_details WHERE batch = $years[$i]";
      $file_archive_result = mysqli_query($con, $file_archive_query);
      $file_archive = mysqli_fetch_assoc($file_archive_result);

      $result[] = $file_archive['file_per_batch'];
    }

    echo json_encode($result);
  } else if ($_GET['action'] == 'countFileTypes') {

    $file_type_query = "SELECT file_type FROM file_types";
    $file_type_result = mysqli_query($con, $file_type_query);

    $id=0;
    while($file_type_row = mysqli_fetch_assoc($file_type_result)) {
      $file_type[] = $file_type_row['file_type'];

      $file_id[] = $id+=1;
    }

    $count = count($file_type);

    for($i=0; $i<$count; $i++) {
      $file_count_query = "SELECT COUNT(*) AS total_file_type FROM file_requests AS requests INNER JOIN file_details AS files ON requests.file_id = files.id INNER JOIN file_types AS types ON files.file_type_id = types.id WHERE types.file_type = '$file_type[$i]'";
      $file_count_result = mysqli_query($con, $file_count_query);
      $file_count = mysqli_fetch_assoc($file_count_result);

      $total_file_type[] = $file_count['total_file_type'];
    }

    // echo count($file_type);
    // $count_file_type_sql = "SELECT COUNT(*) FROM file_types WHERE"

    $result = [
      'file_type' => $file_type,
      'total_file_type' => $total_file_type
    ];

    echo json_encode($result);

  }
