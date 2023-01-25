<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-success elevation-4">
  <!-- Brand Logo -->
  <a href="/digital_archiving_management_system/views/admin" class="brand-link d-flex align-items-center">
    <img src="../../assets/dist/img/logo/dams-logo.png" alt="DAMS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <div>
      <h6 class="brand-text font-weight-light mb-0">Digital Archiving System</h6>
      <!-- <h6 class="brand-text font-weight-light mt-0">Management System</h6> -->
    </div>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../../assets/dist/img/users/default.png" class="img-circle elevation-1 display-picture" alt="User Image" style="width: 35px; height: 35px">
      </div>
      <div class="info">
        <a href="../user/profile.php" class="d-block">
          <span class="profile-name <?php echo isset($_SESSION['profile']) ? 'text-success font-weight-bold' : ''?>"></span>
        </a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-3">
      <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="../user/announcements.php" class="nav-link <?php echo isset($_SESSION['announcements']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Announcements</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../user/archives.php" class="nav-link <?php echo isset($_SESSION['archives']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-archive"></i>
            <p>My Archives</p>
          </a>
        </li>
        <li class="nav-item <?php echo isset($_SESSION['pending']) || isset($_SESSION['approved']) || isset($_SESSION['rejected']) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?php echo isset($_SESSION['pending']) || isset($_SESSION['approved']) || isset($_SESSION['rejected']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-question-circle"></i>
            <p>Requests
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="../user/pending_requests.php" class="nav-link <?php echo isset($_SESSION['pending']) ? 'active' : '' ?>">
                    <i class="fas fa-file-alt nav-icon"></i>
                      <p>Pending Requests</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="../user/approved_requests.php" class="nav-link <?php echo isset($_SESSION['approved']) ? 'active' : '' ?>">
                      <i class="fas fa-thumbs-up nav-icon"></i>
                      <p>Approved Requests</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="../user/rejected_requests.php" class="nav-link <?php echo isset($_SESSION['rejected']) ? 'active' : '' ?>">
                      <i class="fas fa-thumbs-down fa-flip-horizontal nav-icon" style=""></i>
                      <p>Rejected Requests</p>
                  </a>
              </li>
          </ul>
        </li>
        <!-- <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              announcements
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Page</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Page</p>
              </a>
            </li>
          </ul>
        </li> -->
        <!-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Simple Link
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li> -->
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<div id="sidebar-overlay" class="sidebar-overlay"></div>