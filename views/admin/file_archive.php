<?php 
  if(!isset($_SESSION))
  {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'admin')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['file_archive'] = 'active';

  unset($_SESSION['dashboard']);
  unset($_SESSION['profile']);
  unset($_SESSION['user_management']);

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
          <h1>File Archives</h1>
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
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-file-tab" data-toggle="tab" data-target="#nav-file" type="button" role="tab" aria-controls="nav-file" aria-selected="true">Files</button>
                  <button class="nav-link" id="nav-file-type-tab" data-toggle="tab" data-target="#nav-file-type" type="button" role="tab" aria-controls="nav-file-type" aria-selected="false">File Types</button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active py-3" id="nav-file" role="tabpanel" aria-labelledby="nav-file-tab">
                  <table class="table table-bordered table-hover table-sm w-100" id="tbl_files">
                    <thead class="bg-success">
                      <tr>
                        <th>#</th>
                        <th>Owner</th>
                        <th>Picture</th>
                        <th>File name</th>
                        <th>File type</th>
                        <th>Status</th>
                        <th>Uploaded by</th>
                        <th>Date uploaded</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="tab-pane fade py-3" id="nav-file-type" role="tabpanel" aria-labelledby="nav-file-type-tab">
                  <table class="table table-bordered table-hover table-sm w-100" id="tbl_file_types">
                      <thead class="bg-success">
                        <tr>
                          <th>#</th>
                          <th>File type</th>
                          <th>Created by</th>
                          <th>Date created</th>
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
      </div>
    </div>
  </section>

   <!-- MODALS -->

  <!-- ADD FILE TYPE -->
  <div class="modal fade" id="addFileTypeModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Add File Type</h4>
          <button type="button" class="close btn-close-files" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_file_type">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="txt_file_type">File type</label>
                  <input type="text" class="form-control" id="txt_file_type" name="txt_file_type" placeholder="Enter file type" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_save_file_type">Save</button>
            <button type="button" class="btn btn-outline-secondary btn-close-files" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div> 
  <!-- EDIT FILE TYPE -->
  <div class="modal fade" id="editFileTypeModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Edit File Type</h4>
          <button type="button" class="close btn-close-files" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_edit_file_type">
        <input type="hidden" id="txt_file_type_id" name="txt_file_type_id">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="txt_edit_file_type">File type</label>
                  <input type="text" class="form-control" id="txt_edit_file_type" name="txt_edit_file_type" placeholder="Enter file type" required>
                </div>
              </div>
             
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_update_file_type">Save</button>
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