<?php 

  include_once('../../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'user')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['profile'] = 'active';

  unset($_SESSION['announcements']);
  unset($_SESSION['archives']);
  unset($_SESSION['pending']);
  unset($_SESSION['approved']);
  unset($_SESSION['rejected']);
  unset($_SESSION['track']);

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
          <h1>Manage Profile</h1>
        </div>
      </div>
      
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-success card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle display-picture" id="profile-user-img" src="../../assets/dist/img/users/default.png" alt="User profile picture" style="width: 200px; height: 200px">
                <form id="upload-picture-form" enctype="multipart/form-data">
                  <input type="file" id="profile-picture" name="profile-picture" style="display: none;">
                  <input type="submit" id="upload-picture" style="display: none;">
                </form>
              </div>
              <p class="text-muted text-center m-0 mt-2 profile-username" id="profile-username">
              </p>
              <h3 class="profile-name text-center" id="profile-name">
              </h3>
              <br>
              <div class="px-4">
              <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-between">
                      <i class="fas fa-user fa-sm mr-1"></i>
                      <b>User ID: </b> 
                    </div>
                    <a class="profile-userid" id="profile-userid">
                    </a>
                  </li>
                  <li class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-between">
                      <i class="fas fa-envelope fa-sm mr-1"></i>
                      <b>Email: </b> 
                    </div>
                    <a class="profile-email" id="profile-email">
                    </a>
                  </li>
                  <li class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-between">
                      <i class="fas fa-phone fa-sm mr-1"></i>
                      <b>Phone: </b>
                    </div> 
                    <a class="profile-phone" id="profile-phone">
                    </a>
                  </li>
                  <li class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-between">
                      <i class="fas fa-map-marker-alt fa-sm mr-1"></i>
                      <b>Address: </b>
                    </div>
                    <a class="profile-address" id="profile-address">
                    </a>
                  </li>
                  <li class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-between">
                      <i class="fas fa-calendar-alt fa-sm mr-1fa-sm mr-1"></i>
                      <b>Joined: </b>
                    </div> 
                    <a class="profile-date-added" id="profile-date-added">
                    </a>
                  </li>
                </ul>
                <div class="py-4 mb-1">
                  <button type="button" class="btn btn-success btn-block m-0" id="btn_activate_profile" style="display: none">
                    <i class="fas fa-user-check fa-sm mr-1"></i>
                    Activate this account
                  </button>
                  <button type="button" class="btn btn-danger btn-block m-0" id="btn_deactivate_profile" style="display: none">
                    <i class="fas fa-user-times fa-sm mr-1"></i>
                    Deactivate this account
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="card card-success card-outline w-100">
              <div class="card-header bg-success">
                <h3 class="card-title">Edit Details</h3>
              </div>
              <div class="card-body">
                <form id="frm_edit_profile">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="edit_first_name">First name</label>
                        <input type="text" class="form-control" id="edit_first_name" name="edit_first_name" placeholder="Enter first name" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="edit_middle_name">Middle name</label>
                        <input type="text" class="form-control" id="edit_middle_name" name="edit_middle_name" placeholder="Enter middle name">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="edit_last_name">Last name</label>
                        <input type="text" class="form-control" id="edit_last_name" name="edit_last_name" placeholder="Enter last name" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="edit_username">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="edit_username" placeholder="Enter username" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="text" class="form-control" id="edit_email" name="edit_email" placeholder="Enter email address" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="edit_phone">Phone</label>
                        <input type="text" class="form-control" id="edit_phone" name="edit_phone" placeholder="09X-XXX-XXXX" maxlength="11" pattern="(\+?\d{2}?\s?\d{3}\s?\d{3}\s?\d{4})|([0]\d{3}\s?\d{3}\s?\d{4})" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="edit_address">Address</label>
                        <input type="text" class="form-control" id="edit_address" name="edit_address" placeholder="Enter address" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group mt-4 text-center">
                       <button type="button" class="btn btn-primary btn-update-details">Update details</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- modal enter current password -->
          <div class="modal fade" id="modal_enter_current_password" tabindex="-1" role="dialog" aria-labelledby="modal_enter_current_password" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header bg-success">
                  <h5 class="modal-title" id="modal_enter_current_password">User Validation</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-white" aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="frm_current_password">
                    <div class="form-group">
                      <label for="current_password">Current Password</label>
                      <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password" required>
                    </div>
                    <div class="mt-4 text-center">
                      <button type="button" class="btn btn-primary btn-current-password btn-block">Enter</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card card-success card-outline w-100">
              <div class="card-header bg-success">
                <h3 class="card-title">Change Password</h3>
              </div>
              <div class="card-body">
                <form id="frm_change_password" class="frm_change_password">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="edit_profile_name">Current Password</label>
                        <input type="password" class="form-control update_current_password" id="update_current_password" name="update_current_password" placeholder="Enter current password" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="edit_profile_name">New Password</label>
                        <input type="password" class="form-control update_new_password" id="update_new_password" name="update_new_password" placeholder="Enter new password" required>
                        <small id="passres2" class="mt-1 passres2"></small>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="edit_profile_name">Confirm Password</label>
                        <input type="password" class="form-control update_confirm_password" id="update_confirm_password" name="update_confirm_password" placeholder="Re-enter new password" required>
                        <div class="custom-control custom-checkbox float-right">
                          <input type="checkbox" class="custom-control-input show_change_password" id="show_change_password">
                          <label class="custom-control-label text-muted" for="show_change_password">Show password</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group mt-4 text-center">
                       <button type="button" class="btn btn-primary btn-change-password">Change password</button>
                      </div>
                    </div>
                  </div>
                </form>
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