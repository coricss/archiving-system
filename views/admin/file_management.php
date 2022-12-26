<?php 
  if(!isset($_SESSION))
  {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'admin')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['file_management'] = 'active';

  unset($_SESSION['dashboard']);
  unset($_SESSION['profile']);
  unset($_SESSION['user_management']);

  include_once('includes/header.php');
  include_once('includes/topbar.php');
  include_once('includes/sidebar.php');
?>

<?php
  include_once('includes/footer.php');
?>