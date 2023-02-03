<?php 
  if(!isset($_SESSION)) {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'user')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['track'] = 'active';

  unset($_SESSION['announcements']);
  unset($_SESSION['profile']);
  unset($_SESSION['archives']);
  unset($_SESSION['approved']);
  unset($_SESSION['rejected']);
  unset($_SESSION['pending']);

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
          <h1>Track Requests</h1>
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
              <table class="table table-bordered table-hover table-sm w-100" id="tbl_track_user">
                <thead class="bg-success">
                  <tr>
                    <th>#</th>
                    <th>Request ID</th>
                    <th>File name</th>
                    <th>File type</th>
                    <th>Reason</th>
                    <th>Date requested</th>
                    <th>Status</th>
                    <th>Track</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TRACK REQUEST MODAL -->
  <div class="modal fade" id="trackRequestFileModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Track File Request</h4>
          <button type="button" class="close btn-close-files" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_track_file_request" enctype=multipart/form-data>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <b>Request ID</b>
                      <p id="txt_track_request_id"></p>
                    </div>
                    <div class="col-md-4">
                      <b>File name</b>
                      <p id="file_track_name" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis"></p>
                    </div>
                    <div class="col-md-4">
                      <b>File type</b>
                      <p id="track_file_type"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <b>Date uploaded</b>
                      <p id="track_date_uploaded"></p>
                    </div>
                    <div class="col-md-4">
                      <b>Date requested</b>
                      <p id="track_date_requested"></p>
                    </div>
                    <div class="col-md-4">
                      <b>Reason</b>
                      <p id="txt_track_reason"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <center>
                  <div class="stepper-wrapper">
                    <div class="stepper-item" id="step_requested">
                      <div class="step-counter"></div>
                      <div class="step-name">
                        <span>Requested</span>
                      </div>
                    </div>
                    <div class="stepper-item" id="step_admin">
                      <div class="step-counter"></div>
                      <div class="step-name">
                        <span>Admin</span>
                      </div>
                    </div>
                    <div class="stepper-item" id="step_director">
                      <div class="step-counter"></div>
                      <div class="step-name">
                        <span>Director</span>
                      </div>
                    </div>
                    <div class="stepper-item" id="step_released">
                      <div class="step-counter"></div>
                      <div class="step-name">
                        <span>Released</span>
                      </div>
                    </div>
                  </div>
                </center>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-close-files" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div> 
</div>
<?php
  include_once('includes/footer.php');
?>