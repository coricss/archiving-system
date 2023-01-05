<?php 
  include_once('../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  if ($_GET['action'] == 'loadPendingRequestUser') {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.status AS status FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id WHERE requests.user_id = '$user_id' AND requests.is_approved = 0";
    $result = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($result)) {
      $count++;
      $output[] = [
        'id' => $count,
        'file_id' => $row['file_id'],
        'file_name' => $row['file_name'],
        'file_type_id' => $row['file_type_id'],
        'file_type' => $row['file_type'],
        'reason' => $row['reason'],
        'date_requested' =>  date('F d, Y', strtotime($row['date_requested'])),
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'action' => "
                    <button class='btn btn-success btn-sm btn_edit_file_request px-2' title='Edit file request reason' data-id='{$row['id']}'>
                      <i class='fas fa-edit'></i>
                    </button>
                    <button class='btn btn-danger btn-sm btn_cancel_file_request px-2' title='Cancel file request' data-id='{$row['id']}'>
                      <i class='fas fa-times'></i>
                    </button>
                  "
      ];
    }

    echo json_encode($output);
  } else if ($_GET['action'] == 'getFileRequest') {
    $file_id = $_POST['id'];

    $sql = "SELECT requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, files.date_uploaded AS date_uploaded, requests.date_requested AS date_requested, requests.status AS status FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id WHERE requests.is_approved = 0 AND requests.id = '$file_id'";
    $result = mysqli_query($con, $sql);

    $row = mysqli_fetch_assoc($result);

    echo json_encode($row);

  } else if ($_GET['action'] == 'updateFileRequest') {
    $request_id = $_POST['txt_edit_file_id'];
    $reason = mysqli_real_escape_string($con, $_POST['txt_edit_reason']);

    if($reason === "<br>") {
      echo 'empty reason';
    } else {
      $sql = "UPDATE file_requests SET reason = '$reason' WHERE id = '$request_id'";
      $result = mysqli_query($con, $sql);

      if($result) {
        echo 'success';
      } else {
        echo 'error';
      }
    }
  } else if ($_GET['action'] == 'cancelFileRequest') {
    $id = $_POST['id'];

    $sql = "DELETE FROM file_requests WHERE id = '$id'";
    $result = mysqli_query($con, $sql);

    if($result) {
      echo 'success';
    } else {
      echo 'error';
    }
  } else if ($_GET['action'] == 'loadApprovedRequestUser') {

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.status AS status, requests.remarks AS remarks FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id WHERE requests.user_id = '$user_id' AND requests.is_approved = 1";
    $result = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($result)) {
      $count++;
      $output[] = [
        'id' => $count,
        'file_id' => $row['file_id'],
        'file_name' => $row['file_name'],
        'file_type_id' => $row['file_type_id'],
        'file_type' => $row['file_type'],
        'reason' => $row['reason'],
        'date_requested' =>  date('F d, Y', strtotime($row['date_requested'])),
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'remarks' => $row['remarks'],
        'action' => "
                    <a target='_blank' href='../../storage/files/{$row['file_name']}' type='button' class='btn btn-primary btn-sm btn_download_file_request px-2' title='Download file' data-id='{$row['id']}'>
                      <i class='fas fa-file-download'></i>
                    </a>
                  "
      ];
    }

    echo json_encode($output);
  }