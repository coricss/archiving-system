<?php 
  include_once('../database/connection.php');
  include_once('../email/EmailNotification.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  
  $receiverCC_sql = "SELECT * FROM `user_accounts` WHERE `is_admin` = 1";
  $receiverCC_query = mysqli_query($con, $receiverCC_sql);
  $receiverCC = [];
  while($row = mysqli_fetch_assoc($receiverCC_query)) {
    array_push($receiverCC, $row['email']);
  }

  $receiverBCC_sql = "SELECT * FROM `user_accounts` WHERE `is_admin` = 2";
  $receiverBCC_query = mysqli_query($con, $receiverBCC_sql);
  $receiverBccRow = mysqli_fetch_assoc($receiverBCC_query);
  $receiverBCC = $receiverBccRow['email'];

  if($_GET['action'] == 'loadActiveFiles') {


    $user_id = $_SESSION['user_id'];

    $sql = "SELECT files.id AS id, files.user_id AS user_id, CONCAT(users.first_name, ' ', users.last_name) AS owner, users.picture AS picture, files.file_name AS file_name, types.id AS file_type_id, types.file_type AS file_type, files.uploaded_by AS uploaded_by_id, CONCAT(uploader.first_name, ' ', uploader.last_name) AS uploader, files.status AS status, files.date_uploaded AS date_uploaded FROM file_details AS files INNER JOIN file_types AS types ON files.file_type_id = types.id INNER JOIN user_accounts AS users ON files.user_id = users.user_id INNER JOIN user_accounts AS uploader ON files.uploaded_by = uploader.user_id WHERE files.user_id = $user_id AND files.status = 1 ORDER BY files.date_uploaded";

    $data = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($data)) {

      $count++;

      $output[] = [
        'id' => $count,
        'owner_id' => $row['user_id'],
        'owner' => $row['owner'],
        'picture' => $row['picture'],
        'file_name' => $row['file_name'],
        'file_type_id' => $row['file_type_id'],
        'file_type' => $row['file_type'],
        'uploaded_by_id' => $row['uploaded_by_id'],
        'uploaded_by' => $row['uploader'],
        'date_uploaded' => date('M d, Y - h:i A', strtotime($row['date_uploaded'])),
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'action' => "
                      <button class='btn btn-primary btn-sm btn_file_request px-2' title='Make a file request' data-id='{$row['id']}'>
                        <i class='fas fa-question'></i>
                      </button>
                    " 
                    
      ];
    }
    echo json_encode($output);
    
  } else if ($_GET['action'] == 'getFileDetails') {

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT files.id AS id, files.user_id AS user_id, CONCAT(users.first_name, ' ', users.last_name) AS owner, users.picture AS picture, files.file_name AS file_name, types.id AS file_type_id, types.file_type AS file_type, files.uploaded_by AS uploaded_by_id, CONCAT(uploader.first_name, ' ', uploader.last_name) AS uploader, files.status AS status, files.date_uploaded AS date_uploaded FROM file_details AS files INNER JOIN file_types AS types ON files.file_type_id = types.id INNER JOIN user_accounts AS users ON files.user_id = users.user_id INNER JOIN user_accounts AS uploader ON files.uploaded_by = uploader.user_id WHERE files.user_id = $user_id AND files.id = {$_GET['id']}";

    $data = mysqli_query($con, $sql);

    $row = mysqli_fetch_assoc($data);

    echo json_encode($row);

  } else if($_GET['action'] == 'requestFile'){

      $user_id = $_SESSION['user_id'];

      $user_name = $_SESSION['fullname'];
      $user_email = $_SESSION['email'];
      $receiverCCUser = [$user_email];

      $date_created = date('Y-m-d H:i:s');

      if(mysqli_real_escape_string($con, $_POST['txt_reason']) === "<br>") {
        echo 'empty reason';
      } else {
        $user_id = $_SESSION['user_id'];
        $file_id = mysqli_real_escape_string($con, $_POST['txt_file_id']);
        $reason = mysqli_real_escape_string($con, $_POST['txt_reason']);
        $date_requested = date('Y-m-d H:i:s');

        $request_id = 'IETI'.random_int(100000, 999999);
    
        $sql = "INSERT INTO file_requests (request_id, file_id, user_id, reason, is_approved, is_director_approved, is_released, remarks, status, date_requested) VALUES ('$request_id', $file_id, $user_id, '$reason', 0, 0, 0, NULL, 1, '$date_requested')";

        // $notif = "INSERT INTO notifications (user_id, file_id, activity, status, date_created) VALUES ($user_id, $file_id, 'request', 1, '$date_created')";

        if((mysqli_query($con, $sql))) {

           //ADMIN EMAIL
          generateEmail($request_id, 'ieti.system2023@gmail.com', $receiverCC, 'ieti.system2023@gmail.com', 'You have a new file request from <b>'.$user_name.'</b>.<br><br>Reason: '.$reason.'<br><br> Please check your dashboard for more details.');

          //USER EMAIL
          generateEmail($request_id, $user_email, $receiverCCUser, $user_email, 'You have been successfully requested a file. <br><br> Please wait for furthermore announcements regarding this request. Thank you.');

          echo 'success';
        } else {
          echo 'error';
        }
      }
      
    
  }