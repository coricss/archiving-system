<?php 
  if(!isset($_SESSION)) {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'admin')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['announcements'] = 'active';

  unset($_SESSION['user_management']);
  unset($_SESSION['profile']);
  unset($_SESSION['file_archive']);
  unset($_SESSION['pending_admin']);
  unset($_SESSION['approved_admin']);
  unset($_SESSION['rejected_admin']);

  include_once('includes/header.php');
  include_once('includes/topbar.php');
  include_once('includes/sidebar.php');
?>

<!-- CONTENT -->
<div class="content-wrapper" style="min-height: 1599.06px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Announcements</h1>
        </div>
        <!-- <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Layout</a></li>
          <li class="breadcrumb-item active">Fixed Footer Layout</li>
          </ol>
        </div> -->
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- <div class="text-center" style="width: 100%">
         
        </div>  -->
        <div class="col-md-6">
          <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fweb.facebook.com%2Fieticalamba%2Fposts%2Fpfbid02Sh9ja5mXszew3VWdAUVjmGZ72guJxmjZXsNEggHN5ke4Fs6v3MTmYRkM32rPqcSxl&show_text=true&width=400" width="400" height="520" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
        </div>
        <div class="col-md-6">
          <div class="fb-container w-100">
           
          <div>
        </div>
        
      </div>
    </div>
  </section>
</div>

<?php
  include_once('includes/footer.php');
?>