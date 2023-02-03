<?php 
  if(!isset($_SESSION)) {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'admin')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['dashboard'] = 'active';

  unset($_SESSION['user_management']);
  unset($_SESSION['profile']);
  unset($_SESSION['file_archive']);
  unset($_SESSION['pending_admin']);
  unset($_SESSION['approved_admin']);
  unset($_SESSION['rejected_admin']);
  unset($_SESSION['announcements']);

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
          <h1>Dashboard</h1>
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
      <div class="row mb-3">
        <div class="col-md-3">
          <div class="small-box bg-warning">
              <div class="overlay dark">
                <<i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
              <div class="inner">
                  <h3 id="total-users"></h3>
                  <p>Total Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a id="small-box-footer-new-emp" href="../admin/user_management.php" style="cursor: pointer" class="small-box-footer">View details <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="small-box bg-info">
              <div class="overlay dark">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
              <div class="inner">
                  <h3 id="total-file-archives"></h3>
                  <p>File Archives</p>
              </div>
              <div class="icon">
                <i class="fas fa-copy"></i>
              </div>
              <a id="small-box-footer-new-emp" href="../admin/file_archive.php" style="cursor: pointer" class="small-box-footer">View details <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="small-box bg-success">
              <div class="overlay dark">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
              <div class="inner">
                  <h3 id="total-approved-requests"></h3>
                  <p>Approved Requests</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-check"></i>
              </div>
              <a id="small-box-footer-new-emp" href="../admin/approved_requests.php" style="cursor: pointer" class="small-box-footer">View details <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="small-box bg-danger">
              <div class="overlay dark">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
              <div class="inner">
                  <h3 id="total-rejected-requests"></h3>
                  <p>Rejected Requests</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-times"></i>
              </div>
              <a id="small-box-footer-new-emp" href="../admin/rejected_requests.php" style="cursor: pointer" class="small-box-footer">View details <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-lg-7">
          <div class="card card-success card-outline">
              <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i>
                    File Archive Graph
                  </h3>
              </div>
              <div class="card-body">
                <canvas class="w-100" id="card-file-bar-graph" style="max-height: 450px !important; height: 450px !important"></canvas>
              </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card card-success card-outline">
              <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    File Requests
                  </h3>
              </div>
              <div class="card-body">
                <canvas class="w-100" id="card-file-pie-graph" style="max-height: 450px !important; height: 450px !important"></canvas>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
  include_once('includes/footer.php');
?>
<script src="../../controller/DashboardController.js"></script>