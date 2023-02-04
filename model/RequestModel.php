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

  if ($_GET['action'] == 'loadTrackRequestUser') {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT requests.request_id AS request_id, requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.status AS status FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id ";
    // WHERE requests.user_id = '$user_id' AND (requests.is_approved = 0 OR requests.is_director_approved = 0) AND requests.status = 1
    $result = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($result)) {
      $count++;
      $output[] = [
        'id' => $count,
        'request_id' => $row['request_id'],
        'file_id' => $row['file_id'],
        'file_name' => $row['file_name'],
        'file_type_id' => $row['file_type_id'],
        'file_type' => $row['file_type'],
        'reason' => $row['reason'],
        'date_requested' =>  date('M d, Y - h:i A', strtotime($row['date_requested'])),
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'action' => "
                    <button class='btn btn-success btn-sm btn_edit_file_request px-2' title='Edit file request reason' data-id='{$row['id']}'>
                      <i class='fas fa-edit'></i>
                    </button>
                    <button class='btn btn-danger btn-sm btn_cancel_file_request px-2' title='Cancel file request' data-id='{$row['id']}'>
                      <i class='fas fa-times fa-lg'></i>
                    </button>
                  ",
        'track' => "
                      <button class='btn btn-primary btn-sm btn_track_request px-2' title='Track request' data-id='{$row['id']}'>
                        <i class='fas fa-eye'></i>
                      </button>
                    "
      ];
    }

    echo json_encode($output);
  } else if ($_GET['action'] == 'loadPendingRequestUser') {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT requests.request_id AS request_id, requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.status AS status FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id WHERE requests.user_id = '$user_id' AND (requests.is_approved = 0 OR requests.is_director_approved = 0) AND requests.status = 1";
    $result = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($result)) {
      $count++;
      $output[] = [
        'id' => $count,
        'request_id' => $row['request_id'],
        'file_id' => $row['file_id'],
        'file_name' => $row['file_name'],
        'file_type_id' => $row['file_type_id'],
        'file_type' => $row['file_type'],
        'reason' => $row['reason'],
        'date_requested' =>  date('M d, Y - h:i A', strtotime($row['date_requested'])),
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'action' => "
                    <button class='btn btn-success btn-sm btn_edit_file_request px-2' title='Edit file request reason' data-id='{$row['id']}'>
                      <i class='fas fa-edit'></i>
                    </button>
                    <button class='btn btn-danger btn-sm btn_cancel_file_request px-2' title='Cancel file request' data-id='{$row['id']}'>
                      <i class='fas fa-times fa-lg'></i>
                    </button>
                  "
      ];
    }

    echo json_encode($output);
  } else if ($_GET['action'] == 'loadPendingRequestAdmin') {

    $user_type = $_SESSION['user_type'];

    if($user_type == 'admin') {
      $sql = "SELECT users.picture AS picture, CONCAT(users.first_name, ' ', users.last_name) AS requested_by, requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.is_approved AS is_approved, requests.status AS status FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id WHERE requests.is_approved = 0 AND requests.status = 1";
      $result = mysqli_query($con, $sql);
  
      $output = [];
  
      $count = 0;
  
      while($row = mysqli_fetch_assoc($result)) {
        $count++;

        $output[] = [
          'id' => $count,
          'request_id' => $row['request_id'],
          'file_id' => $row['file_id'],
          'picture' => $row['picture'],
          'requested_by' => $row['requested_by'],
          'file_name' => $row['file_name'],
          'file_type_id' => $row['file_type_id'],
          'file_type' => $row['file_type'],
          'reason' => $row['reason'],
          'date_requested' =>  date('M d, Y - h:i A', strtotime($row['date_requested'])),
          'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
          'action' => "
                      <button class='btn btn-success btn-sm btn_approve_request px-2' title='Approve' data-id='{$row['id']}'>
                        <i class='fas fa-thumbs-up'></i>
                      </button>
                      <button class='btn btn-danger btn-sm btn_reject_request px-2' title='Reject' data-id='{$row['id']}'>
                        <i class='fas fa-thumbs-down fa-flip-horizontal'></i>
                      </button>
                    "
        ];
      }
  
      echo json_encode($output);
    } else if($user_type == 'director') {
      $sql = "SELECT users.picture AS picture, CONCAT(users.first_name, ' ', users.last_name) AS requested_by, requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.status AS status FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id WHERE requests.is_approved = 1 AND requests.is_director_approved = 0 AND requests.status = 1";
      $result = mysqli_query($con, $sql);
  
      $output = [];
  
      $count = 0;
  
      while($row = mysqli_fetch_assoc($result)) {
        $count++;
        $output[] = [
          'id' => $count,
          'request_id' => $row['request_id'],
          'file_id' => $row['file_id'],
          'picture' => $row['picture'],
          'requested_by' => $row['requested_by'],
          'file_name' => $row['file_name'],
          'file_type_id' => $row['file_type_id'],
          'file_type' => $row['file_type'],
          'reason' => $row['reason'],
          'date_requested' =>  date('M d, Y - h:i A', strtotime($row['date_requested'])),
          'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
          'action' => "
                      <button class='btn btn-success btn-sm btn_approve_request px-2' title='Approve' data-id='{$row['id']}'>
                        <i class='fas fa-thumbs-up'></i>
                      </button>
                      <button class='btn btn-danger btn-sm btn_reject_request px-2' title='Reject' data-id='{$row['id']}'>
                        <i class='fas fa-thumbs-down fa-flip-horizontal'></i>
                      </button>
                    ",
          'track' => "
                      <button class='btn btn-primary btn-sm btn_track_request px-2' title='Track' data-id='{$row['id']}'>
                        <i class='fas fa-search'></i>
                      </button>
                    "
        ];
      }
  
      echo json_encode($output);
    }

    
  } else if ($_GET['action'] == 'approveRequest') {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    $admin_name = $_SESSION['fullname'];

    $request_id = $_POST['file_approve_id'];
    $file_id = $_POST['file_approve_file_id'];
    $remarks = mysqli_real_escape_string($con, $_POST['file_approve_remarks']);
    $date = date('Y-m-d H:i:s');

    $user_email_sql = "SELECT users.email AS email, requests.request_id AS requestid FROM file_requests AS requests INNER JOIN user_accounts AS users ON requests.user_id = users.user_id WHERE requests.id = '$request_id'";
    $user_email_result = mysqli_query($con, $user_email_sql);
    $user_email_row = mysqli_fetch_assoc($user_email_result);
    $user_email = $user_email_row['email'];
    $requestid = $user_email_row['requestid'];

    if($user_type == 'admin') {
      if($remarks === "<br>") {
        echo 'empty reason';
      } else {
        $sql = "UPDATE file_requests SET is_approved = 1, remarks = '$remarks', processed_by = '$user_id', date_processed = '$date' WHERE id = '$request_id'";
        $result = mysqli_query($con, $sql);

        if ($result) {

          generateEmail($requestid, $user_email, $receiverCC, $receiverBCC, 'Admin <b>'.$admin_name.'</b> approved request file: <b>'.$requestid.'</b>.<br><br>Remarks: '.$remarks.'<br><br> Please check the system for more details.');

          echo 'success';
        } else {
          echo 'error';
        }
      }
    } else if ($user_type == 'director') {
      if($remarks === "<br>") {
        echo 'empty reason';
      } else {
        $sql = "UPDATE file_requests SET is_director_approved = 1, remarks = '$remarks', processed_by = '$user_id', date_processed = '$date' WHERE id = '$request_id'";
        $result = mysqli_query($con, $sql);

        if ($result) {

          generateEmail($requestid, $user_email, $receiverCC, $receiverBCC, 'Director <b>'.$admin_name.'</b> approved request file: <b>'.$requestid.'</b>.<br><br>Remarks: '.$remarks.'<br><br> Please check the system for more details.');

          echo 'success';
        } else {
          echo 'error';
        }
      }
    }

  } else if ($_GET['action'] == 'approveNotifRequest') {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    $admin_name = $_SESSION['fullname'];

    $request_id = $_POST['file_process_id'];
    $file_id = $_POST['file_process_file_id'];
    $remarks = mysqli_real_escape_string($con, $_POST['file_process_remarks']);
    $date = date('Y-m-d H:i:s');

    $user_email_sql = "SELECT users.email AS email, requests.request_id AS requestid FROM file_requests AS requests INNER JOIN user_accounts AS users ON requests.user_id = users.user_id WHERE requests.id = '$request_id'";
    $user_email_result = mysqli_query($con, $user_email_sql);
    $user_email_row = mysqli_fetch_assoc($user_email_result);
    $user_email = $user_email_row['email'];
    $requestid = $user_email_row['requestid'];

    if($user_type == 'admin') {
      if($remarks === "<br>") {
        echo 'empty reason';
      } else {
        $sql = "UPDATE file_requests SET is_approved = 1, remarks = '$remarks', processed_by = '$user_id', date_processed = '$date' WHERE id = '$request_id'";
        $result = mysqli_query($con, $sql);
  
        if ($result) {

          generateEmail($requestid, $user_email, $receiverCC, $receiverBCC, 'Admin <b>'.$admin_name.'</b> approved request file: <b>'.$requestid.'</b>.<br><br>Remarks: '.$remarks.'<br><br> Please check the system for more details.');

          echo 'success';
        } else {
          echo 'error';
        }
      }
    } else if ($user_type == 'director') {
      if($remarks === "<br>") {
        echo 'empty reason';
      } else {
        $sql = "UPDATE file_requests SET is_director_approved = 1, remarks = '$remarks', processed_by = '$user_id', date_processed = '$date' WHERE id = '$request_id'";
        $result = mysqli_query($con, $sql);
  
        if ($result) {

          
          generateEmail($requestid, $user_email, $receiverCC, $receiverBCC, 'Director <b>'.$admin_name.'</b> approved request file: <b>'.$requestid.'</b>.<br><br>Remarks: '.$remarks.'<br><br> Please check the system for more details.');

          echo 'success';
        } else {
          echo 'error';
        }
      }
    }

  } else if ($_GET['action'] == 'rejectRequest') {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    $admin_name = $_SESSION['fullname'];

    $request_id = $_POST['file_reject_id'];
    $file_id = $_POST['file_reject_file_id'];
    $remarks = mysqli_real_escape_string($con, $_POST['file_reject_remarks']);
    $date = date('Y-m-d H:i:s');

    $user_email_sql = "SELECT users.email AS email, requests.request_id AS requestid FROM file_requests AS requests INNER JOIN user_accounts AS users ON requests.user_id = users.user_id WHERE requests.id = '$request_id'";
    $user_email_result = mysqli_query($con, $user_email_sql);
    $user_email_row = mysqli_fetch_assoc($user_email_result);
    $user_email = $user_email_row['email'];
    $requestid = $user_email_row['requestid'];

    if($user_type == 'admin') {
      if($remarks === "<br>") {
        echo 'empty reason';
      } else {
        $sql = "UPDATE file_requests SET is_approved = 2, remarks = '$remarks', processed_by = '$user_id', date_processed = '$date', status = 0 WHERE id = '$request_id'";
        $result = mysqli_query($con, $sql);
  
        if ($result) {

          generateEmail($requestid, $user_email, $receiverCC, $receiverBCC, 'Admin <b>'.$admin_name.'</b> rejected request file: <b>'.$requestid.'</b>.<br><br>Remarks: '.$remarks.'<br><br> Please check the system for more details.');

          echo 'success';
        } else {
          echo 'error';
        }
      }
    } else if($user_type == 'director'){
      if($remarks === "<br>") {
        echo 'empty reason';
      } else {
        $sql = "UPDATE file_requests SET is_director_approved = 2, remarks = '$remarks', processed_by = '$user_id', date_processed = '$date', status = 0 WHERE id = '$request_id'";
        $result = mysqli_query($con, $sql);

  
        if ($result) {

          generateEmail($requestid, $user_email, $receiverCC, $receiverBCC, 'Director <b>'.$admin_name.'</b> rejected request file: <b>'.$requestid.'</b>.<br><br>Remarks: '.$remarks.'<br><br> Please check the system for more details.');

          echo 'success';
        } else {
          echo 'error';
        }
      }
    }

    

  } else if ($_GET['action'] == 'rejectNotifRequest') {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    $admin_name = $_SESSION['fullname'];

    $request_id = $_POST['file_process_id'];
    $file_id = $_POST['file_process_file_id'];
    $remarks = mysqli_real_escape_string($con, $_POST['file_process_remarks']);
    $date = date('Y-m-d H:i:s');

    $user_email_sql = "SELECT users.email AS email, requests.request_id AS requestid FROM file_requests AS requests INNER JOIN user_accounts AS users ON requests.user_id = users.user_id WHERE requests.id = '$request_id'";
    $user_email_result = mysqli_query($con, $user_email_sql);
    $user_email_row = mysqli_fetch_assoc($user_email_result);
    $user_email = $user_email_row['email'];
    $requestid = $user_email_row['requestid'];

    if($remarks === "<br>") {
      echo 'empty reason';
    } else {
      $sql = "UPDATE file_requests SET is_approved = 2, remarks = '$remarks', processed_by = '$user_id', date_processed = '$date', status = 0 WHERE id = '$request_id'";
      $result = mysqli_query($con, $sql);

      if ($result) {

        
        generateEmail($requestid, $user_email, $receiverCC, $receiverBCC, 'Admin <b>'.$admin_name.'</b> rejected request file: <b>'.$requestid.'</b>.<br><br>Remarks: '.$remarks.'<br><br> Please check the system for more details.');

        echo 'success';
      } else {
        echo 'error';
      }
    }

  } else if ($_GET['action'] == 'getFileRequest') {
    $file_id = $_POST['id'];

    $sql = "SELECT CONCAT(users.first_name, ' ', users.last_name) AS requested_by, CONCAT(admins.first_name, ' ', admins.last_name) AS processed_by, requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.remarks AS remarks, files.date_uploaded AS date_uploaded, requests.date_requested AS date_requested, requests.date_processed AS date_processed, requests.status AS status, requests.is_approved AS is_approved, requests.is_director_approved AS is_director_approved, requests.is_released AS is_released FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id LEFT JOIN user_accounts AS admins ON admins.user_id = requests.processed_by WHERE requests.id = $file_id";
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
    $user_name = $_SESSION['fullname'];

    $sql = "UPDATE file_requests SET status = 0 WHERE id = '$id'";
    $result = mysqli_query($con, $sql);

    $user_email_sql = "SELECT users.email AS email, requests.request_id AS requestid FROM file_requests AS requests INNER JOIN user_accounts AS users ON requests.user_id = users.user_id WHERE requests.id = $id";
    $user_email_result = mysqli_query($con, $user_email_sql);
    $user_email_row = mysqli_fetch_assoc($user_email_result);
    $user_email = $user_email_row['email'];
    $requestid = $user_email_row['requestid'];

    // $notif_sql = "UPDATE notifications SET status = 0 WHERE notif_id = '$id'";
    // $notif_result = mysqli_query($con, $notif_sql);

    if($result) {

      generateEmail($requestid, 'ieti.system2023@gmail.com', $receiverCC, $receiverBCC, '<b>'.$user_name.'</b> canceled a file request: <b>'.$requestid.'<br><br> Please check the system for more details.');

      echo 'success';
    } else {
      echo 'error';
    }
  } else if ($_GET['action'] == 'loadApprovedRequestUser') {

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.date_processed AS date_approved, CONCAT(admins.first_name, ' ', admins.last_name) AS approved_by, requests.status AS status, requests.remarks AS remarks FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id INNER JOIN user_accounts AS admins ON admins.user_id = requests.processed_by WHERE requests.user_id = '$user_id' AND requests.is_director_approved = 1";
    $result = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($result)) {
      $count++;
      $output[] = [
        'id' => $count,
        'request_id' => $row['request_id'],
        'file_id' => $row['file_id'],
        'file_name' => $row['file_name'],
        'file_type_id' => $row['file_type_id'],
        'file_type' => $row['file_type'],
        'reason' => $row['reason'],
        'date_requested' =>  date('M d, Y - h:i A', strtotime($row['date_requested'])),
        'date_approved' =>  date('M d, Y - h:i A', strtotime($row['date_approved'])),
        'approved_by' => $row['approved_by'],
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
  } else if ($_GET['action'] == 'loadApprovedRequestAdmin') {

    $user_type = $_SESSION['user_type'];
    
    if($user_type == 'admin') {

      $sql = "SELECT users.picture AS picture, CONCAT(users.first_name, ' ', users.last_name) AS requested_by, requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.date_processed AS date_approved, CONCAT(admins.first_name, ' ', admins.last_name) AS approved_by, requests.status AS status, requests.remarks AS remarks, requests.is_director_approved AS is_director_approved, requests.is_released AS is_released FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id INNER JOIN user_accounts AS admins ON admins.user_id = requests.processed_by WHERE requests.is_approved = 1 OR requests.is_director_approved = 1";
      $result = mysqli_query($con, $sql);
  
      $output = [];
  
      $count = 0;
  
      while($row = mysqli_fetch_assoc($result)) {
        $count++;

        $row['is_director_approved'] == 1 ? $disable = '' : $disable = 'disabled';
        $row['is_released'] == 1 ? $check = 'checked' : $check = '';

        $output[] = [
          'id' => $count,
          'request_id' => $row['request_id'],
          'file_id' => $row['file_id'],
          'picture' => $row['picture'],
          'requested_by' => $row['requested_by'],
          'file_name' => $row['file_name'],
          'file_type_id' => $row['file_type_id'],
          'file_type' => $row['file_type'],
          'reason' => $row['reason'],
          'date_requested' =>  date('M d, Y - h:i A', strtotime($row['date_requested'])),
          'date_approved' =>  date('M d, Y - h:i A', strtotime($row['date_approved'])),
          'approved_by' => $row['approved_by'],
          'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
          'remarks' => $row['remarks'],
          'release' => "
                      <div class='custom-control custom-switch'>
                        <input type='checkbox' class='custom-control-input switch_release' id='switch_release_{$row['id']}' data-id='{$row['id']}' data-status='{$row['status']}' data-file_id='{$row['file_id']}' data-file_name='{$row['file_name']}' data-file_type_id='{$row['file_type_id']}' data-file_type='{$row['file_type']}' data-request_id='{$row['request_id']}' data-requested_by='{$row['requested_by']}' data-picture='{$row['picture']}' data-reason='{$row['reason']}' data-date_requested='{$row['date_requested']}' data-date_approved='{$row['date_approved']}' data-approved_by='{$row['approved_by']}' data-remarks='{$row['remarks']}' data-status='{$row['status']}' data-toggle='tooltip' data-placement='top' title='Release file' $disable $check>
                          <label class='custom-control-label' for='switch_release_{$row['id']}'></label>
                        </div>
                        "
        ];
      }
  
      echo json_encode($output);
    } else if($user_type == 'director') {
      $sql = "SELECT users.picture AS picture, CONCAT(users.first_name, ' ', users.last_name) AS requested_by, requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.date_processed AS date_approved, CONCAT(admins.first_name, ' ', admins.last_name) AS approved_by, requests.status AS status, requests.remarks AS remarks, requests.is_released AS is_released FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id INNER JOIN user_accounts AS admins ON admins.user_id = requests.processed_by WHERE requests.is_director_approved = 1";
      $result = mysqli_query($con, $sql);
  
      $output = [];
  
      $count = 0;
  
      while($row = mysqli_fetch_assoc($result)) {
        $count++;
        $output[] = [
          'id' => $count,
          'request_id' => $row['request_id'],
          'file_id' => $row['file_id'],
          'picture' => $row['picture'],
          'requested_by' => $row['requested_by'],
          'file_name' => $row['file_name'],
          'file_type_id' => $row['file_type_id'],
          'file_type' => $row['file_type'],
          'reason' => $row['reason'],
          'date_requested' =>  date('M d, Y - h:i A', strtotime($row['date_requested'])),
          'date_approved' =>  date('M d, Y - h:i A', strtotime($row['date_approved'])),
          'approved_by' => $row['approved_by'],
          'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
          'remarks' => $row['remarks'],
          'release' => $row['is_released'] == 1 ? '<span class="badge badge-success">Released</span>' : '<span class="badge badge-primary">For release</span>'
        ];
      }
  
      echo json_encode($output);
    }
    
  } else if ($_GET['action'] == 'releaseRequest') {
    
    $id = $_POST['id'];
    $admin_name = $_SESSION['fullname'];

    $select_request_sql = "SELECT * FROM file_requests WHERE id = $id";
    $select_request_result = mysqli_query($con, $select_request_sql);
    $select_request_row = mysqli_fetch_assoc($select_request_result);
    
    if($select_request_row['is_released'] == 0) {

      $release_query = "UPDATE file_requests SET is_released = 1 WHERE id = $id";
      $release_result = mysqli_query($con, $release_query);

      $user_email_sql = "SELECT users.email AS email, requests.request_id AS requestid FROM file_requests AS requests INNER JOIN user_accounts AS users ON requests.user_id = users.user_id WHERE requests.id = $id";
      $user_email_result = mysqli_query($con, $user_email_sql);
      $user_email_row = mysqli_fetch_assoc($user_email_result);
      $user_email = $user_email_row['email'];
      $requestid = $user_email_row['requestid'];
  
      if ($release_result) {

        generateEmail($requestid, $user_email, $receiverCC, $receiverBCC, 'Admin <b>'.$admin_name.'</b> released a file: <b>'.$requestid.'</b>.<br><br> Please contact admin for more details.');

        echo 'success';
      } else {
        echo 'error';
      }

    } else {

      $release_query = "UPDATE file_requests SET is_released = 0 WHERE id = $id";
      $release_result = mysqli_query($con, $release_query);
  
      if ($release_result) {
        echo 'success';
      } else {
        echo 'error';
      }

    }


  } else if ($_GET['action'] == 'loadRejectedRequestUser') {
    
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.date_processed AS date_rejected, CONCAT(admins.first_name, ' ', admins.last_name) AS rejected_by, requests.status AS status, requests.remarks AS remarks FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id INNER JOIN user_accounts AS admins ON admins.user_id = requests.processed_by WHERE requests.user_id = '$user_id' AND (requests.is_approved = 2 OR requests.is_director_approved = 2)";
    $result = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($result)) {
      $count++;
      $output[] = [
        'id' => $count,
        'request_id' => $row['request_id'],
        'file_id' => $row['file_id'],
        'file_name' => $row['file_name'],
        'file_type_id' => $row['file_type_id'],
        'file_type' => $row['file_type'],
        'reason' => $row['reason'],
        'date_requested' =>  date('M d, Y - h:i A', strtotime($row['date_requested'])),
        'date_rejected' =>  date('M d, Y - h:i A', strtotime($row['date_rejected'])),
        'rejected_by' => $row['rejected_by'],
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'remarks' => $row['remarks']
      ];
    }

    echo json_encode($output);
  } else if ($_GET['action'] == 'loadRejectedRequestAdmin') {
    

    $sql = "SELECT users.picture AS picture, CONCAT(users.first_name, ' ', users.last_name) AS requested_by, requests.request_id AS request_id, requests.id AS id, requests.file_id AS file_id, files.file_name, types.id AS file_type_id, types.file_type AS file_type, requests.reason AS reason, requests.date_requested, requests.date_processed AS date_rejected, CONCAT(admins.first_name, ' ', admins.last_name) AS rejected_by, requests.status AS status, requests.remarks AS remarks FROM file_requests AS requests INNER JOIN file_details AS files ON files.id = requests.file_id INNER JOIN file_types AS types ON types.id = files.file_type_id INNER JOIN user_accounts AS users ON users.user_id = files.user_id INNER JOIN user_accounts AS admins ON admins.user_id = requests.processed_by WHERE requests.is_approved = 2 OR requests.is_director_approved = 2";
    $result = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($result)) {
      $count++;
      $output[] = [
        'id' => $count,
        'request_id' => $row['request_id'],
        'file_id' => $row['file_id'],
        'picture' => $row['picture'],
        'requested_by' => $row['requested_by'],
        'file_name' => $row['file_name'],
        'file_type_id' => $row['file_type_id'],
        'file_type' => $row['file_type'],
        'reason' => $row['reason'],
        'date_requested' =>  date('M d, Y - h:i A', strtotime($row['date_requested'])),
        'date_rejected' =>  date('M d, Y - h:i A', strtotime($row['date_rejected'])),
        'rejected_by' => $row['rejected_by'],
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'remarks' => $row['remarks']
      ];
    }

    echo json_encode($output);
  }