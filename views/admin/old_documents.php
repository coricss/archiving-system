<?php 
  if(!isset($_SESSION)) {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'admin') && ($_SESSION['user_type'] != 'director')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['old_documents'] = 'active';

  unset($_SESSION['user_management']);
  unset($_SESSION['profile']);
  unset($_SESSION['file_management']);
  unset($_SESSION['pending_admin']);
  unset($_SESSION['approved_admin']);
  unset($_SESSION['rejected_admin']);
  unset($_SESSION['dashboard']);
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
          <h1>Old Documents</h1>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row mb-3">
      <div class="col-12">
          <div class="card card-success card-outline">
            <div class="card-body" style="display: block;">
                <b>Filter by:</b>
                <div class="row">
                  <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <select class="form-control" id="sel_file_type" name="sel_file_type">
                        <!-- <option value="0">File type</option> -->
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <select class="form-control" id="sel_owner" name="sel_owner">
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <select class="form-control" id="sel_batch" name="sel_batch">
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <select class="form-control" id="sel_date_uploaded" name="sel_date_uploaded">
                      </select>
                    </div>
                  </div>
                </div>
                
                <table class="table table-bordered table-hover table-sm w-100" id="tbl_old_files">
                  <thead class="bg-success">
                    <tr>
                      <th>#</th>
                      <th>Picture</th>
                      <th>Owner</th>
                      <th>File name</th>
                      <th>File type</th>
                      <th>Uploaded by</th>
                      <th>Date uploaded</th>
                      <th>Batch</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                </table>
              </div>
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