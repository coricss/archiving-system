<?php 
  include_once('../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  if ($_GET['action'] == 'loadStudents') {
    $query = "SELECT * FROM user_accounts WHERE is_admin = 0 ORDER BY first_name";

    $data = mysqli_query($con, $query);

    $output = [];

    $count = 0;

  
    while($row = mysqli_fetch_assoc($data)) {
      
      $count++;

      $output[] = [
        'id' => $count,
        'userid' => $row['user_id'],
        'picture' => $row['picture'],
        'fullname' => $row['first_name']." ".$row['middle_name']." ".$row['last_name'],
        'phone' => $row['phone_no'],
        'email' => $row['email'],
        'address' => $row['address'],
        'username' => $row['username'],
        'role' => $row['is_admin'] == 1 ? 'Admin' : 'User',
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'date_added' => date('M d, Y - h:i A', strtotime($row['date_added'])),
        'action' => "
                      <button class='btn btn-success btn-sm btn_edit_user' title='Edit details' data-id='{$row['id']}'>
                        <i class='fas fa-edit'></i>
                      </button>
                      <button class='btn btn-primary btn-sm btn_reset_password' title='Reset password' data-id='{$row['id']}'>
                        <i class='fas fa-sync'></i>
                    "
      ];
    }

    echo json_encode($output);

  } else if ($_GET['action'] == 'loadActiveStudents') {
    $query = "SELECT * FROM user_accounts WHERE is_admin = 0 AND status = 1 ORDER BY first_name";

    $data = mysqli_query($con, $query);

    $output = [];

    $count = 0;

  
    while($row = mysqli_fetch_assoc($data)) {
      
      $count++;

      $output[] = [
        'id' => $count,
        'userid' => $row['user_id'],
        'picture' => $row['picture'],
        'fullname' => $row['first_name']." ".$row['middle_name']." ".$row['last_name'],
        'phone' => $row['phone_no'],
        'email' => $row['email'],
        'address' => $row['address'],
        'username' => $row['username'],
        'role' => $row['is_admin'] == 1 ? 'Admin' : 'User',
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'date_added' => date('M d, Y - h:i A', strtotime($row['date_added']))
      ];
    }

    echo json_encode($output);

  } else if($_GET['action'] == 'loadFileTypes') {
    
    $sql = "SELECT types.id as id, types.file_type as file_type, types.status as status, CONCAT(users.first_name, ' ',users.last_name) as admin, types.date_created FROM file_types as types LEFT JOIN user_accounts as users ON types.created_by = users.user_id ORDER BY types.id";
    $data = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($data)) {

      $count++;

      $output[] = [
        'id' => $count,
        'file_type_id' => $row['id'],
        'file_type' => $row['file_type'],
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'created_by' => $row['admin'],
        'date_created' => date('M d, Y - h:i A', strtotime($row['date_created'])),
        'action' => $row['status'] == 0 ? 
                      "
                        <button class='btn btn-success btn-sm btn_edit_file_type px-2' title='Edit details' data-id='{$row['id']}'>
                          <i class='fas fa-edit'></i>
                        </button>
                        <button class='btn btn-primary btn-sm btn_activate_file_type px-2' title='Activate file type' data-id='{$row['id']}'>
                          <i class='fas fa-check-circle'></i>
                        </button>
                      " 
                    : 
                      "
                        <button class='btn btn-success btn-sm btn_edit_file_type px-2' title='Edit details' data-id='{$row['id']}'>
                          <i class='fas fa-edit'></i>
                        </button>
                        <button class='btn btn-danger btn-sm btn_deactivate_file_type px-2' title='Deactivate file type' data-id='{$row['id']}'>
                          <i class='fas fa-ban'></i>
                        </button>
                      "
      ];
    }

    echo json_encode($output);

  } else if($_GET['action'] == 'loadActiveFileTypes') {
    
    $sql = "SELECT types.id as id, types.file_type as file_type, types.status as status, CONCAT(users.first_name, ' ',users.last_name) as admin, types.date_created FROM file_types as types LEFT JOIN user_accounts as users ON types.created_by = users.user_id WHERE types.status = 1 ORDER BY types.id";
    $data = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($data)) {

      $count++;

      $output[] = [
        'id' => $count,
        'file_type_id' => $row['id'],
        'file_type' => $row['file_type'],
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'created_by' => $row['admin'],
        'date_created' => date('M d, Y - h:i A', strtotime($row['date_created']))
      ];
    }

    echo json_encode($output);

  } else if ($_GET['action'] == 'addFileType') {
    $file_type = mysqli_real_escape_string($con, $_POST['txt_file_type']);
    $created_by = $_SESSION['user_id'];
    $date_created = date('Y-m-d H:i:s');

    $sql_file_type = "SELECT * FROM file_types WHERE file_type = '$file_type'";
    $file_type_name = mysqli_query($con, $sql_file_type);

    if(mysqli_num_rows($file_type_name) > 0){
      echo "file type exists";
    } else{
      $sql = "INSERT INTO file_types (file_type, status, created_by, date_created) VALUES ('$file_type', 1, '$created_by', '$date_created')";
      $result = mysqli_query($con, $sql);

      if($result) {
        echo "success";
      } else {
        echo "error";
      }
    }
    
  } else if ($_GET['action'] == 'getFileType') {

    $sql = "SELECT id, file_type FROM file_types WHERE id = {$_GET['id']}";
    $data = mysqli_query($con, $sql);
    
    $row = mysqli_fetch_assoc($data);

    echo json_encode($row);

  } else if ($_GET['action'] == 'updateFileType') {
    $id = $_POST['txt_file_type_id'];
    $file_type = mysqli_real_escape_string($con, $_POST['txt_edit_file_type']);

    $sql_file_type = "SELECT * FROM file_types WHERE file_type = '$file_type' AND id != $id";
    $file_type_name = mysqli_query($con, $sql_file_type);
    
    if(mysqli_num_rows($file_type_name) > 0) {
      echo "file type exists";
    } else {
      $sql = "UPDATE file_types SET file_type = '$file_type' WHERE id = $id";
      $data = mysqli_query($con, $sql);
  
      if($data) {
        echo "success";
      } else {
        echo "error";
      }
    }

  } else if ($_GET['action'] == 'activateFileType') {
    $id = $_POST['id'];

    $sql = "UPDATE file_types SET status = 1 WHERE id = '$id'";
    $data = mysqli_query($con, $sql);

    if($data) {
      echo "success";
    } else {
      echo "error";
    }
  } else if ($_GET['action'] == 'deactivateFileType') {
    $id = $_POST['id'];

    $sql = "UPDATE file_types SET status = 0 WHERE id = '$id'";
    $data = mysqli_query($con, $sql);

    if($data) {
      echo "success";
    } else {
      echo "error";
    }
  } else if($_GET['action'] == 'loadFiles') {

    $sql = "SELECT files.id AS id, files.user_id AS user_id, CONCAT(users.first_name, ' ', users.last_name) AS owner, users.picture AS picture, files.file_name AS file_name, types.id AS file_type_id, types.file_type AS file_type, files.uploaded_by AS uploaded_by_id, CONCAT(uploader.first_name, ' ', uploader.last_name) AS uploader, files.status AS status, files.batch AS batch, files.date_uploaded AS date_uploaded FROM file_details AS files INNER JOIN file_types AS types ON files.file_type_id = types.id INNER JOIN user_accounts AS users ON files.user_id = users.user_id INNER JOIN user_accounts AS uploader ON files.uploaded_by = uploader.user_id ORDER BY files.date_uploaded";
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
        'batch' => $row['batch'],
        'action' => $row['status'] == 0 ? 
                      "
                        <button class='btn btn-success btn-sm btn_edit_file px-2' title='Edit file details' data-id='{$row['id']}'>
                          <i class='fas fa-edit'></i>
                        </button>
                        <button class='btn btn-primary btn-sm btn_activate_file px-2' title='Activate file status' data-id='{$row['id']}'>
                          <i class='fas fa-check-circle'></i>
                        </button>
                      " 
                    : 
                      "
                        <button class='btn btn-success btn-sm btn_edit_file px-2' title='Edit file details' data-id='{$row['id']}'>
                          <i class='fas fa-edit'></i>
                        </button>
                        <button class='btn btn-danger btn-sm btn_deactivate_file px-2' title='Deactivate file status' data-id='{$row['id']}'>
                          <i class='fas fa-ban'></i>
                        </button>
                      "
      ];

    }

    echo json_encode($output);
  } else if ($_GET['action'] == 'addFile') {
    
    $owner = mysqli_real_escape_string($con, $_POST['slc_owner']);
    $file_type = mysqli_real_escape_string($con, $_POST['slc_file_type']);
    $file =  time().mysqli_real_escape_string($con, $_FILES['file_record']['name']);
    $batch = mysqli_real_escape_string($con, $_POST['slc_batch']);
    $file_loc = "../storage/files/".$file;
    $uploaded_by = $_SESSION['user_id'];
    $date_uploaded = date('Y-m-d H:i:s');

    $file_ext = pathinfo($_FILES['file_record']['name'], PATHINFO_EXTENSION);

    if($_FILES['file_record']['size'] > 3145728) {
      echo "file too large";
    } else if (($file_ext != 'pdf') && ($file_ext != 'docx') && ($file_ext != 'xlsx') && ($file_ext != 'csv') && ($file_ext != 'pptx')) {
      echo "invalid file type";
    } else {
      move_uploaded_file($_FILES["file_record"]["tmp_name"], $file_loc);

      $sql = "INSERT INTO file_details (user_id, file_type_id, file_name, status, batch, uploaded_by, date_uploaded) VALUES ('$owner', '$file_type', '$file', 1, '$batch', '$uploaded_by', '$date_uploaded')";
      $result = mysqli_query($con, $sql);

      if($result) {
        echo "success";
      } else {
        echo "error";
      }
    }
    
  } else if ($_GET['action'] == 'getFile') {

    $sql = "SELECT files.id AS id, files.user_id AS user_id, CONCAT(users.first_name, ' ', users.last_name) AS owner, users.picture AS picture, files.file_name AS file_name, types.id AS file_type_id, types.file_type AS file_type, files.uploaded_by AS uploaded_by_id, CONCAT(uploader.first_name, ' ', uploader.last_name) AS uploader, files.status AS status, files.batch AS batch, files.date_uploaded AS date_uploaded FROM file_details AS files INNER JOIN file_types AS types ON files.file_type_id = types.id INNER JOIN user_accounts AS users ON files.user_id = users.user_id INNER JOIN user_accounts AS uploader ON files.uploaded_by = uploader.user_id WHERE files.id = {$_GET['id']}";
    $data = mysqli_query($con, $sql);

    $row = mysqli_fetch_assoc($data);
    
    echo json_encode($row);

  } else if ($_GET['action'] == 'updateFile') {

    $id = mysqli_real_escape_string($con, $_POST['txt_file_id']);
    $owner = mysqli_real_escape_string($con, $_POST['slc_edit_owner']);
    $file_type = mysqli_real_escape_string($con, $_POST['slc_edit_file_type']);
    $edit_batch = mysqli_real_escape_string($con, $_POST['slc_edit_batch']);
    $file =  time().mysqli_real_escape_string($con, $_FILES['file_edit_record']['name']);
    $file_loc = "../storage/files/".$file;

    $file_ext = pathinfo($_FILES['file_edit_record']['name'], PATHINFO_EXTENSION);

    $sql = "SELECT file_name FROM file_details WHERE id = $id";
    $data = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($data);

    if($_FILES['file_edit_record']['name'] == ''){
      
      $sql = "UPDATE file_details SET user_id = '$owner', file_type_id = '$file_type', batch = '$edit_batch' WHERE id = $id";
      $result = mysqli_query($con, $sql);

      if($result) {
        echo "success";
      } else {
        echo "error";
      }

    } else {
      if($_FILES['file_edit_record']['size'] > 3145728) {
        echo "file too large";
      } else if (($file_ext != 'pdf') && ($file_ext != 'docx') && ($file_ext != 'xlsx') && ($file_ext != 'csv') && ($file_ext != 'pptx')) {
        echo "invalid file type";
      } else {

        unlink("../storage/files/".$row['file_name']);

        move_uploaded_file($_FILES["file_edit_record"]["tmp_name"], $file_loc);
  
        $sql = "UPDATE file_details SET user_id = '$owner', file_type_id = '$file_type', batch = '$edit_batch', file_name = '$file' WHERE id = $id";
        $result = mysqli_query($con, $sql);
  
        if($result) {
          echo "success";
        } else {
          echo "error";
        }
      }
    }

    
    
  } else if ($_GET['action'] == 'activateFile') {

    $id = mysqli_real_escape_string($con, $_POST['id']);

    $sql = "UPDATE file_details SET status = 1 WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if($result) {
      echo "success";
    } else {
      echo "error";
    }
    
  } else if ($_GET['action'] == 'deactivateFile') {

    $id = mysqli_real_escape_string($con, $_POST['id']);

    $sql = "UPDATE file_details SET status = 0 WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if($result) {
      echo "success";
    } else {
      echo "error";
    }
    
  }