<?php 
  if(!isset($_SESSION)) {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'admin')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['pending_admin'] = 'active';

  unset($_SESSION['dashboard']);
  unset($_SESSION['profile']);
  unset($_SESSION['file_archive']);
  unset($_SESSION['user_management']);
  unset($_SESSION['archives_admin']);
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
          <h1>Pending Requests</h1>
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
              <table class="table table-bordered table-hover table-sm w-100" id="tbl_pending_admin">
                <thead class="bg-success">
                  <tr>
                    <th>#</th>
                    <th>Picture</th>
                    <th>Requested by</th>
                    <th>File name</th>
                    <th>File type</th>
                    <th>Reason</th>
                    <th>Date requested</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- APPROVE REQUEST MODAL -->
  <div class="modal fade" id="approveRequestFileModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Approve Request</h4>
          <button type="button" class="close btn-close-files" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_approve_file_request" enctype=multipart/form-data>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Requested by</b>
                      <p id="file_approve_requested_by"></p>
                      <input type="hidden" name="file_approve_id" id="file_approve_id">
                      <input type="hidden" name="file_approve_file_id" id="file_approve_file_id">
                    </div>
                    <div class="col-md-6">
                      <b>File name</b>
                      <p id="file_approve_file_name"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Date uploaded</b>
                      <p id="file_approve_date_uploaded"></p>
                    </div>
                    <div class="col-md-6">
                      <b>File type</b>
                      <p id="file_approve_file_type"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Date requested</b>
                      <p id="file_approve_date_requested"></p>
                    </div>
                    <div class="col-md-6">
                      <b>Reason</b>
                      <p id="file_approve_reason"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="file_approve_remarks">Remarks</label>
                  <textarea class="form-control" name="file_approve_remarks" id="file_approve_remarks" rows="3" placeholder="Enter remarks for this request" style="resize: none" required></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn_approve_request_file">Approve</button>
            <button type="button" class="btn btn-outline-secondary btn-close-files" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div> 
</div>
<!-- REJECT REQUEST MODAL -->
<div class="modal fade" id="rejectRequestFileModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Reject Request</h4>
          <button type="button" class="close btn-close-files" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_reject_file_request" enctype=multipart/form-data>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Requested by</b>
                      <p id="file_reject_requested_by"></p>
                      <input type="hidden" name="file_reject_id" id="file_reject_id">
                      <input type="hidden" name="file_reject_file_id" id="file_reject_file_id">
                    </div>
                    <div class="col-md-6">
                      <b>File name</b>
                      <p id="file_reject_file_name"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Date uploaded</b>
                      <p id="file_reject_date_uploaded"></p>
                    </div>
                    <div class="col-md-6">
                      <b>File type</b>
                      <p id="file_reject_file_type"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Date requested</b>
                      <p id="file_reject_date_requested"></p>
                    </div>
                    <div class="col-md-6">
                      <b>Reason</b>
                      <p id="file_reject_reason"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="file_reject_remarks">Remarks</label>
                  <textarea class="form-control" name="file_reject_remarks" id="file_reject_remarks" rows="3" placeholder="Enter remarks for this request" style="resize: none" required></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn_reject_request_file">Reject</button>
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