<?php 
  if(!isset($_SESSION)) {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'admin') && ($_SESSION['user_type'] != 'director')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['rejected_admin'] = 'active';

  unset($_SESSION['announcements']);
  unset($_SESSION['profile']);
  unset($_SESSION['file_archive']);
  unset($_SESSION['user_management']);
  unset($_SESSION['archives_admin']);
  unset($_SESSION['approved_admin']);
  unset($_SESSION['pending_admin']);
  unset($_SESSION['dashboard']);

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
          <h1>Rejected Requests</h1>
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
        <div class="col-12">
          <div class="card card-success card-outline">
            <div class="card-body" style="display: block;">
              <table class="table table-bordered table-hover table-sm w-100" id="tbl_rejected_admin">
                <thead class="bg-success">
                  <tr>
                    <th>#</th>
                    <th>Request ID</th>
                    <th>Picture</th>
                    <th>Requested by</th>
                    <th>File name</th>
                    <th>File type</th>
                    <th>Reason</th>
                    <th>Remarks</th>
                    <th>Date requested</th>
                    <th>Date rejected</th>
                    <th>Rejected by</th>
                    <th>Status</th>
                  </tr>
                </thead>
              </table>
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