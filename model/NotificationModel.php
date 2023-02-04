<?php
  include_once('../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }


  function get_time_ago($timestamp){  
    $time_ago          = strtotime($timestamp);  
    $current_time      = time();  
    $time_difference   = $current_time - $time_ago;  
    $seconds           = $time_difference;  
    $minutes           = round($seconds / 60 );           // value 60 is seconds  
    $hours             = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
    $days              = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
    $weeks             = round($seconds / 604800);          // 7*24*60*60;  
    $months            = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
    $years             = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
    if($seconds <= 60) {  
        return "Just now";  
    }else if($minutes <=60){  
        if($minutes==1){  
            return "a minute ago";  
        }  
        else{  
            return $minutes." minutes ago";  
        }  
    }else if($hours <=24){
        if($hours==1){  
            return "an hour ago";  
        }else{  
            return $hours." hours ago";  
        }  
    }else if($days <=7){  
        if($days==1){  
            return "a day ago";  
        }else{  
            return $days." days ago";  
        }  
    }else if($weeks <= 4.3){  
        if($weeks==1){  
            return "a week ago";  
        }else{  
            return $weeks." weeks ago";  
        }  
    }
    else if($months <=12){  
        if($months==1){  
            return "a month ago";  
        }else{  
            return $months." months ago";  
        }  
    }
    else{  
        if($years==1){  
            return "a year ago";  
        }else{  
            return $years." years ago";  
        }  
    } 
  }


  if($_GET['action'] == 'countNotif') {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];

    if($user_type != 'director'){
      $query_admin_notif = "SELECT 
                              requests.id AS request_id,
                              requests.user_id AS user_id,
                              users.picture AS user_picture,
                              CONCAT(users.first_name, ' ', users.last_name) AS requested_by,
                              requests.file_id AS file_id,
                              requests.is_approved AS activity,
                              requests.status AS request_status,
                              requests.date_requested AS date_created,
                              admins.picture AS admin_picture,
                              CONCAT(admins.first_name, ' ', admins.last_name) AS processed_by,
                              requests.date_processed AS date_processed
                            FROM
                                file_requests AS requests
                                    INNER JOIN
                                user_accounts AS users ON requests.user_id = users.user_id
                                    LEFT JOIN
                                user_accounts AS admins ON requests.processed_by = admins.user_id
                                WHERE
                                (requests.processed_by != $user_id
                                    OR requests.processed_by IS NULL)
                                    AND (requests.date_processed >= DATE_SUB(NOW(), INTERVAL 3 DAY)
                                    OR requests.date_processed IS NULL)
                                    AND (requests.status = 1
                                    OR requests.is_approved = 2) ORDER BY requests.id DESC ";
      $result_admin_notif = mysqli_query($con, $query_admin_notif);

      $count_admin_notif = mysqli_num_rows($result_admin_notif);

      $query_user_notif = "SELECT 
                            requests.id AS request_id,
                            requests.user_id AS user_id,
                            users.picture AS user_picture,
                            CONCAT(users.first_name, ' ', users.last_name) AS requested_by,
                            requests.file_id AS file_id,
                            requests.is_approved AS activity,
                            requests.status AS request_status,
                            requests.date_requested AS date_created,
                            admins.picture AS admin_picture,
                            CONCAT(admins.first_name, ' ', admins.last_name) AS processed_by,
                            requests.date_processed AS date_processed
                          FROM
                              file_requests AS requests
                                  INNER JOIN
                              user_accounts AS users ON requests.user_id = users.user_id
                                  LEFT JOIN
                              user_accounts AS admins ON requests.processed_by = admins.user_id
                              WHERE
                        requests.user_id = $user_id
                                  AND requests.date_processed >= DATE_SUB(NOW(), INTERVAL 3 DAY)
                                  AND requests.is_approved != 0 ORDER BY requests.id DESC ";

      $result_user_notif = mysqli_query($con, $query_user_notif);

      $count_user_notif = mysqli_num_rows($result_user_notif);

      $notif_array = [
        'admin_notif' => $count_admin_notif,
        'user_notif' => $count_user_notif
      ];

      echo json_encode($notif_array);
    } else {
      $query_admin_notif = "SELECT 
                              requests.id AS request_id,
                              requests.user_id AS user_id,
                              users.picture AS user_picture,
                              CONCAT(users.first_name, ' ', users.last_name) AS requested_by,
                              requests.file_id AS file_id,
                              requests.is_approved AS activity,
                              requests.status AS request_status,
                              requests.date_requested AS date_created,
                              admins.picture AS admin_picture,
                              CONCAT(admins.first_name, ' ', admins.last_name) AS processed_by,
                              requests.date_processed AS date_processed
                            FROM
                                file_requests AS requests
                                    INNER JOIN
                                user_accounts AS users ON requests.user_id = users.user_id
                                    LEFT JOIN
                                user_accounts AS admins ON requests.processed_by = admins.user_id
                                WHERE
                                  requests.is_approved = 1 OR requests.is_approved = 2 OR requests.is_released = 1
                                ORDER BY requests.id DESC ";
      $result_admin_notif = mysqli_query($con, $query_admin_notif);

      $count_admin_notif = mysqli_num_rows($result_admin_notif);

      $notif_array = [
        'admin_notif' => $count_admin_notif
      ];

      echo json_encode($notif_array);
    }
  } else if ($_GET['action'] == 'adminNotification') {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];

    if($user_type != 'director'){

      $query_admin_notif = "SELECT 
                              requests.id AS request_id,
                              requests.user_id AS user_id,
                              users.picture AS user_picture,
                              CONCAT(users.first_name, ' ', users.last_name) AS requested_by,
                              requests.file_id AS file_id,
                              requests.is_approved AS activity,
                              requests.status AS request_status,
                              requests.date_requested AS date_created,
                              admins.picture AS admin_picture,
                              CONCAT(admins.first_name, ' ', admins.last_name) AS processed_by,
                              requests.date_processed AS date_processed
                            FROM
                                file_requests AS requests
                                    INNER JOIN
                                user_accounts AS users ON requests.user_id = users.user_id
                                    LEFT JOIN
                                user_accounts AS admins ON requests.processed_by = admins.user_id
                                WHERE
                                (requests.processed_by != $user_id
                                    OR requests.processed_by IS NULL)
                                    AND (requests.date_processed >= DATE_SUB(NOW(), INTERVAL 3 DAY)
                                    OR requests.date_processed IS NULL)
                                    AND (requests.status = 1
                                    OR requests.is_approved = 2) ORDER BY requests.id DESC ";
      $admin_notif = mysqli_query($con, $query_admin_notif);

      if(mysqli_num_rows($admin_notif) > 0) {
        while($row = mysqli_fetch_assoc($admin_notif)) {
    
          $request_id = $row['request_id'];
          $user_id = $row['user_id'];
          $file_id = $row['file_id'];
    

          if($row['activity'] == 0) {
            $activity = 'requested a file';
            $name = $row['requested_by'];
            $picture = $row['user_picture'];
            $date = $row['date_created'];
          } else if($row['activity'] == 1) {
            $activity = 'approved a request';
            $name = $row['processed_by'];
            $picture = $row['admin_picture'];
            $date = $row['date_processed'];
          } else if($row['activity'] == 2) {
            $activity = 'rejected a request';
            $name = $row['processed_by'];
            $picture = $row['admin_picture'];
            $date = $row['date_processed'];
          }

          echo "
            <div class='dropdown-divider'></div>
            <button class='dropdown-item bg-light notif-item' request-id={$request_id} activity={$row['activity']}>
              <div class='notif-row'>
                <image width='60px' height='60px' src='../../assets/dist/img/users/{$picture}' class='img-circle'>
                  <div class='notif-activity'>
                    <p class='notif-msg'>
                      <b>{$name}</b>
                      <small>{$activity}</small>
                    </p>
                    <div style='align-contents: center;'>
                      <i class='far fa-clock text-muted' style='font-size: 13px; margin-right: 3px'></i>
                      <small class='notif-time text-muted' style='font-size: 12px;'>".get_time_ago($date)."</small>
                    </div>
                  </div>
              </div>
            </button>
            <div class='dropdown-divider'></div>
          ";
        }
      } else {
        echo "
          <div class='dropdown-divider'></div>
          <button class='dropdown-item bg-light'>
            <div class='p-3 text-center'>
              <h5>No notification</h5>
            </div>
          </button>
          <div class='dropdown-divider'></div>
        ";
      }
    } else {
      $query_admin_notif = "SELECT 
                              requests.id AS request_id,
                              requests.user_id AS user_id,
                              users.picture AS user_picture,
                              CONCAT(users.first_name, ' ', users.last_name) AS requested_by,
                              requests.file_id AS file_id,
                              requests.is_approved AS activity,
                              requests.status AS request_status,
                              requests.date_requested AS date_created,
                              admins.picture AS admin_picture,
                              CONCAT(admins.first_name, ' ', admins.last_name) AS processed_by,
                              requests.date_processed AS date_processed
                            FROM
                                file_requests AS requests
                                    INNER JOIN
                                user_accounts AS users ON requests.user_id = users.user_id
                                    LEFT JOIN
                                user_accounts AS admins ON requests.processed_by = admins.user_id
                                WHERE
                                  requests.is_approved = 1 OR requests.is_approved = 2 OR requests.is_released = 1
                                ORDER BY requests.id DESC ";
      $admin_notif = mysqli_query($con, $query_admin_notif);

      if(mysqli_num_rows($admin_notif) > 0) {
        while($row = mysqli_fetch_assoc($admin_notif)) {
    
          $request_id = $row['request_id'];
          $user_id = $row['user_id'];
          $file_id = $row['file_id'];
    

          if($row['activity'] == 0) {
            $activity = 'requested a file';
            $name = $row['requested_by'];
            $picture = $row['user_picture'];
            $date = $row['date_created'];
          } else if($row['activity'] == 1) {
            $activity = 'approved a request';
            $name = $row['processed_by'];
            $picture = $row['admin_picture'];
            $date = $row['date_processed'];
          } else if($row['activity'] == 2) {
            $activity = 'rejected a request';
            $name = $row['processed_by'];
            $picture = $row['admin_picture'];
            $date = $row['date_processed'];
          }

          echo "
            <div class='dropdown-divider'></div>
            <button class='dropdown-item bg-light notif-item' request-id={$request_id} activity={$row['activity']}>
              <div class='notif-row'>
                <image width='60px' height='60px' src='../../assets/dist/img/users/{$picture}' class='img-circle'>
                  <div class='notif-activity'>
                    <p class='notif-msg'>
                      <b>{$name}</b>
                      <small>{$activity}</small>
                    </p>
                    <div style='align-contents: center;'>
                      <i class='far fa-clock text-muted' style='font-size: 13px; margin-right: 3px'></i>
                      <small class='notif-time text-muted' style='font-size: 12px;'>".get_time_ago($date)."</small>
                    </div>
                  </div>
              </div>
            </button>
            <div class='dropdown-divider'></div>
          ";
        }
      } else {
        echo "
          <div class='dropdown-divider'></div>
          <button class='dropdown-item bg-light'>
            <div class='p-3 text-center'>
              <h5>No notification</h5>
            </div>
          </button>
          <div class='dropdown-divider'></div>
        ";
      }
    }

  } else if ($_GET['action'] == 'userNotification') {
    $user_id = $_SESSION['user_id'];

    $query_user_notif = "SELECT 
                          requests.id AS request_id,
                          requests.user_id AS user_id,
                          users.picture AS user_picture,
                          CONCAT(users.first_name, ' ', users.last_name) AS requested_by,
                          requests.file_id AS file_id,
                          requests.is_approved AS activity,
                          requests.status AS request_status,
                          requests.date_requested AS date_created,
                          admins.picture AS admin_picture,
                          CONCAT(admins.first_name, ' ', admins.last_name) AS processed_by,
                          requests.date_processed AS date_processed
                        FROM
                            file_requests AS requests
                                INNER JOIN
                            user_accounts AS users ON requests.user_id = users.user_id
                                LEFT JOIN
                            user_accounts AS admins ON requests.processed_by = admins.user_id
                            WHERE
                              requests.user_id = $user_id
                                AND requests.date_processed >= DATE_SUB(NOW(), INTERVAL 3 DAY)
                                AND requests.is_approved != 0 ORDER BY requests.id DESC ";
    $user_notif = mysqli_query($con, $query_user_notif);

    if(mysqli_num_rows($user_notif) > 0) {
      while($row = mysqli_fetch_assoc($user_notif)) {
  
        $request_id = $row['request_id'];
        $user_id = $row['user_id'];
        $file_id = $row['file_id'];
   

        if($row['activity'] == 0) {
          $activity = 'requested a file';
          $name = $row['requested_by'];
          $picture = $row['user_picture'];
          $date = $row['date_created'];
        } else if($row['activity'] == 1) {
          $activity = 'approved your request';
          $name = $row['processed_by'];
          $picture = $row['admin_picture'];
          $date = $row['date_processed'];
        } else if($row['activity'] == 2) {
          $activity = 'rejected your request';
          $name = $row['processed_by'];
          $picture = $row['admin_picture'];
          $date = $row['date_processed'];
        }

        echo "
          <div class='dropdown-divider'></div>
          <button class='dropdown-item bg-light notif-item' request-id={$request_id} activity={$row['activity']}>
            <div class='notif-row'>
              <image width='60px' height='60px' src='../../assets/dist/img/users/{$picture}' class='img-circle'>
                <div class='notif-activity'>
                  <p class='notif-msg'>
                    <b>{$name}</b>
                    <small>{$activity}</small>
                  </p>
                  <div style='align-contents: center;'>
                    <i class='far fa-clock text-muted' style='font-size: 13px; margin-right: 3px'></i>
                    <small class='notif-time text-muted' style='font-size: 12px;'>".get_time_ago($date)."</small>
                  </div>
                </div>
            </div>
          </button>
          <div class='dropdown-divider'></div>
        ";
      }
    } else {
      echo "
        <div class='dropdown-divider'></div>
        <button class='dropdown-item bg-light'>
          <div class='p-3 text-center'>
            <h5>No notification</h5>
          </div>
        </button>
        <div class='dropdown-divider'></div>
      ";
    }
  }