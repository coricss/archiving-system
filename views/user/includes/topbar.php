
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" data-auto-collapse-size="1024" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>

  </ul>

  <!-- SEARCH FORM -->
  <!-- <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </form> -->

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Clock -->
    <li class="nav-item d-flex align-items-center justify-content-center text-muted">

    </li>
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link user-notif-bell" data-toggle="dropdown" href="#">
        <i class="fas fa-bell"></i>
        <span class="badge badge-danger navbar-badge count-user-notif"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
        <span class="dropdown-header"><span class="count-user-notifs"></span> Notification(s)</span>
        <div id="user-notif">
          
        </div>
      </div>
    </li>
    <li class="nav-item dropdown user-menu">
        <a href="javascipt:void(0);" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="../../assets/dist/img/users/default.png" class="user-image img-circle display-picture elevation-1 border border-success" alt="User Image">
            <span class="d-none d-md-inline profile-username" style="font-size: 20px"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-success">
                <img src="../../assets/dist/img/users/default.png" class="img-circle elevation-1 display-picture" alt="User Image">
                <p class="profile-username"></p>
                <strong class="profile-name"></strong>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                  <a href="profile.php" class="btn btn-block btn-primary mb-2">
                    <i class="nav-icon fas fa-user-edit" aria-hidden="true"></i> 
                    Edit profile
                  </a>
                <form id="signout-form" action="{{ route('logout') }}" method="POST">
                    <button type="submit" class="btn btn-block btn-danger logout"><i class="nav-icon fas fa-sign-out-alt" data-id=<?php echo $_SESSION['id']?> aria-hidden="true"></i> Logout</button>
                </form>
            </li>
        </ul>
    </li>
  </ul>
</nav>
<!-- APPROVE REQUEST MODAL -->
<div class="modal fade" id="approveNotifRequestFileModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Approved File Request</h4>
          <button type="button" class="close btn-close-files" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_approve_notif" enctype=multipart/form-data>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Approved by</b>
                      <p id="file_approve_notif_requested_by"></p>
                      <input type="hidden" name="file_approve_notif_id" id="file_approve_notif_id">
                      <input type="hidden" name="file_approve_notif_file_id" id="file_approve_notif_file_id">
                    </div>
                    <div class="col-md-6">
                      <b>File name</b>
                      <p id="file_approve_notif_file_name"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Date uploaded</b>
                      <p id="file_approve_notif_date_uploaded"></p>
                    </div>
                    <div class="col-md-6">
                      <b>File type</b>
                      <p id="file_approve_notif_file_type"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Date approve</b>
                      <p id="file_approve_notif_date_requested"></p>
                    </div>
                    <div class="col-md-6">
                      <b>Reason</b>
                      <p id="file_approve_notif_reason"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <b>Remarks</b>
                  <p id="file_approve_notif_remarks"></p>
                </div>
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

<!-- REJECT REQUEST MODAL -->
<div class="modal fade" id="rejectNotifRequestFileModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Rejected File Request</h4>
          <button type="button" class="close btn-close-files" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_reject_notif" enctype=multipart/form-data>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Rejected by</b>
                      <p id="file_reject_notif_requested_by"></p>
                      <input type="hidden" name="file_reject_notif_id" id="file_reject_notif_id">
                      <input type="hidden" name="file_reject_notif_file_id" id="file_reject_notif_file_id">
                    </div>
                    <div class="col-md-6">
                      <b>File name</b>
                      <p id="file_reject_notif_file_name"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Date uploaded</b>
                      <p id="file_reject_notif_date_uploaded"></p>
                    </div>
                    <div class="col-md-6">
                      <b>File type</b>
                      <p id="file_reject_notif_file_type"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <b>Date rejected</b>
                      <p id="file_reject_notif_date_requested"></p>
                    </div>
                    <div class="col-md-6">
                      <b>Reason</b>
                      <p id="file_reject_notif_reason"></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <b>Remarks</b>
                  <p id="file_reject_notif_remarks"></p>
                </div>
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
    <!-- /.navbar -->