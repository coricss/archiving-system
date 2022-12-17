<?php 

  include_once('../../database/connection.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  $_SESSION['profile'] = 'active';

  unset($_SESSION['dashboard']);
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
                <img class="profile-user-img img-fluid img-circle display-picture" id="profile-user-img" style="width: 200px" src="../../assets/dist/img/users/default.png" alt="User profile picture">
              </div>
              <p class="text-muted text-center m-0 mt-2 profile-username" id="profile-username">
              </p>
              <h3 class="profile-name text-center" id="profile-name">
              </h3>
              <br>
              <div class="px-4">
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <i class="fas fa-user"></i>
                    <b>User ID: </b> <a class="float-right profile-userid fa-sm" id="profile-userid">
                    </a>
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-envelope"></i>
                    <b>Email: </b> <a class="float-right profile-email fa-sm" id="profile-email">
                    </a>
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-phone"></i>
                    <b>Phone: </b> <a class="float-right profile-phone fa-sm" id="profile-phone">
                    </a>
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-map-marker-alt fa-sm"></i>
                    <b>Address: </b> <a class="float-right profile-address" id="profile-address">
                    </a>
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-calendar-alt fa-sm"></i>
                    <b>Date added: </b> <a class="float-right profile-date-added" id="profile-date-added">
                    </a>
                  </li>
                </ul>
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
                      <div class="mt-4 text-center">
                       <button type="submit" class="btn btn-primary ">Update details</button>
                       <button type="reset" class="btn btn-outline-secondary mr-2">Reset</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card card-success card-outline w-100">
              <div class="card-header bg-success">
                <h3 class="card-title">Change Password</h3>
              </div>
              <div class="card-body">
                <form id="frm_edit_profile">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="edit_profile_name">Current Password</label>
                        <input type="password" class="form-control" id="edit_profile_name" name="edit_profile_name" placeholder="Enter name">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="edit_profile_name">New Password</label>
                        <input type="password" class="form-control" id="edit_profile_name" name="edit_profile_name" placeholder="Enter name">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="edit_profile_name">Confirm Password</label>
                        <input type="password" class="form-control" id="edit_profile_name" name="edit_profile_name" placeholder="Enter name">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mt-4 text-center">
                       <button type="submit" class="btn btn-primary ">Change password</button>
                       <button type="reset" class="btn btn-outline-secondary mr-2">Clear</button>
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