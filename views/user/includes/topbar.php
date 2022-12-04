<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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
        <span class="badge badge-danger navbar-badge">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>
    <li class="nav-item dropdown user-menu">
        <a href="javascipt:void(0);" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="../../assets/dist/img/avatar.png" class="user-image img-circle elevation-1 border border-success" alt="User Image">
            <span class="d-none d-md-inline">John Doe</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-success">
                <img src="../../assets/dist/img/avatar.png" class="img-circle elevation-1" alt="User Image">
                <p>johndoe@13</p>
                <strong>John Doe</strong>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                    <button type="button" class="btn btn-block btn-primary mb-2">
                      <i class="nav-icon fas fa-lock" aria-hidden="true"></i> 
                      Change password
                    </button>
                <form id="signout-form" action="{{ route('logout') }}" method="POST">
                    <button type="submit" class="btn btn-block btn-danger"><i class="nav-icon fas fa-sign-out-alt" aria-hidden="true"></i> Logout</button>
                </form>
            </li>
        </ul>
    </li>
  </ul>
</nav>
    <!-- /.navbar -->