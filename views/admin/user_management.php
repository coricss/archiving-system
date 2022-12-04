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
              <table class="table table-hover table-sm w-100" id="tbl_users">
                <thead class="bg-success">
                  <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                 
                    <tr>
                      <td>1</td>
                      <td>1</td>
                      <td>1</td>
                      <td>1</td>
                      <td>1</td> 
                      <td>1</td> 
                      <td>1</td> 
                      <td>1</td> 
                      <td>1</td> 
                    </tr>
                 
                </tbody>
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
</div>

<?php
  include_once('includes/footer.php');
?>