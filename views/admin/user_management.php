<?php 
  if(!isset($_SESSION))
  {
    session_start();
  }

  $_SESSION['user_management'] = 'active';

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
          <h1>User Management</h1>
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
          <div class="card">
            <div class="card-body" style="display: block;">
              <table class="table table-bordered table-hover table-sm w-100" id="tbl_users">
                <thead class="bg-success">
                  <tr>
                    <th>#</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Date added</th>
                    <th>Actions</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- <div class="card-footer" style="display: block;">
              Footer
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MODALS -->

  <!-- ADD USERS -->
  <div class="modal fade" id="addUserModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Add New User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_user_details">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_fname">First Name</label>
                  <input type="text" class="form-control" id="txt_fname" name="txt_fname" placeholder="Enter first name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_mname">Middle Name</label>
                  <input type="text" class="form-control" id="txt_mname" name="txt_mname" placeholder="Enter middle name">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_lname">Last Name</label>
                  <input type="text" class="form-control" id="txt_lname" name="txt_lname" placeholder="Enter last name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_phone">Phone</label>
                  <input type="text" class="form-control" id="txt_phone" name="txt_phone" placeholder="Enter phone number" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_email">Email</label>
                  <input type="text" class="form-control" id="txt_email" name="txt_email" placeholder="Enter email address" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_address">Address</label>
                  <input type="text" class="form-control" id="txt_address" name="txt_address" placeholder="Enter address" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_username">Username</label>
                  <input type="text" class="form-control" id="txt_username" name="txt_username" placeholder="Enter username" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                <label for="slc_role">Role</label>
                  <select class="form-control" id="slc_role" name="slc_role" required>
                    <option value="">Select Role</option>
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn_save_user">Save</button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div> 

  <!-- EDIT USERS -->
  <div class="modal fade" id="editUserModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Edit User Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_edit_user_details">
          <input type="hidden" id="txt_user_id" name="txt_user_id">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_edit_fname">First Name</label>
                  <input type="text" class="form-control" id="txt_edit_fname" name="txt_edit_fname" placeholder="Enter first name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_edit_mname">Middle Name</label>
                  <input type="text" class="form-control" id="txt_edit_mname" name="txt_edit_mname" placeholder="Enter middle name">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_edit_lname">Last Name</label>
                  <input type="text" class="form-control" id="txt_edit_lname" name="txt_edit_lname" placeholder="Enter last name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_edit_phone">Phone</label>
                  <input type="text" class="form-control" id="txt_edit_phone" name="txt_edit_phone" placeholder="Enter phone number" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_edit_email">Email</label>
                  <input type="text" class="form-control" id="txt_edit_email" name="txt_edit_email" placeholder="Enter email address" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_edit_address">Address</label>
                  <input type="text" class="form-control" id="txt_edit_address" name="txt_edit_address" placeholder="Enter address" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txt_edit_username">Username</label>
                  <input type="text" class="form-control" id="txt_edit_username" name="txt_edit_username" placeholder="Enter username" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                <label for="slc_edit_role">Role</label>
                  <select class="form-control" id="slc_edit_role" name="slc_edit_role" required>
                    <option value="">Select Role</option>
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn_save_user">Save</button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>  
</div>

<?php
  include_once('includes/footer.php');
?>