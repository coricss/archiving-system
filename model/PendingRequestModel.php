<?php 
  include_once('../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  if ($_GET['action'] == 'loadPendingRequestUser') {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.status AS status FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id WHERE requests.user_id = '$user_id' AND requests.is_approved = 0";
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
                    <button class='btn btn-success btn-sm btn_file_request px-2' title='Make a file request' data-id='{$row['file_id']}'>
                      <i class='fas fa-edit'></i>
                    </button>
                    <button class='btn btn-danger btn-sm btn_file_request px-2' title='Make a file request' data-id='{$row['file_id']}'>
                      <i class='fas fa-times'></i>
                    </button>
                  "
      ];
    }

    echo json_encode($output);
  }