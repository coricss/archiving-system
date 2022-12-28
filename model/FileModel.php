<?php 
  include_once('../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  if($_GET['action'] == 'loadFileTypes') {
    
    $sql = "SELECT types.id as id, types.file_type as file_type, types.status as status, CONCAT(users.first_name, ' ',users.last_name) as admin, types.date_created FROM file_types as types LEFT JOIN user_accounts as users ON types.created_by = users.user_id";
    $data = mysqli_query($con, $sql);

    $output = [];

    $count = 0;

    while($row = mysqli_fetch_assoc($data)) {

      $count++;

      $res = "dsa";

      $res .= "das";

      $output[] = [
        'id' => $count,
        'file_type' => $row['file_type'],
        'status' => $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
        'created_by' => $row['admin'],
        'date_created' => date('F d, Y', strtotime($row['date_created'])),
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
  }