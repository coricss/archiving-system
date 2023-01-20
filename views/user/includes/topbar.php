
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
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-bell"></i>
        <span class="badge badge-danger navbar-badge count-user-notif"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
        <span class="dropdown-header"><span class="count-user-notifs"></span> Notification(s)</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <div class="notif-row">
            <image width="60px" height="60px" src="../../assets/dist/img/users/default.png" class="img-circle">
              <div class="notif-activity">
                <p class="notif-msg">
                  <b>Rico Estribo Guinanao</b>
                  <small>requested a file</small>
                </p>
                <div style="align-contents: center;">
                  <i class="far fa-clock text-muted" style="font-size: 13px; margin-right: 3px"></i>
                  <small class="notif-time" style="font-size: 12px; color: #043ea7">Just now</small>
                </div>
              </div>
          </div>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
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
    <!-- /.navbar -->