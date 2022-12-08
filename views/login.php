<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital Management Archiving System</title>
    <!-- Logo -->
    <link rel="icon" href="assets/dist/img/logo/dams-logo.png" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/dist/css/main.css">
</head>
<body class="login-page">
  <!-- LOGIN CONTENT -->
  <div class="login-box">
    <div class="card card-outline">
      <div class="card-header text-center">
        <img src="assets/dist/img/logo/dams-logo.png" class="img-fluid rounded-top w-50" alt=""/> <br><br>
        <h3><b>Digital Archiving Management System</b></h3>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Log in to start your session</p>
        <form id="frm_login">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="txt_userid" id="txt_userid" placeholder="User ID or Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="txt_userpassword" id="txt_userpassword" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <!-- <div class="row">
            <div class="icheck-primary ml-auto">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Log In</button>
            </div>
          </div>
        </form>
       
        <p class="mb-1 mt-3">
          <a href="forgot-password.html">Forgot password?</a>
        </p>
        <!-- <p class="mb-0">
          <a href="register.html" class="text-center">Register a new membership</a>
        </p> -->
      </div>
    </div>
  </div>

  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="assets/dist/js/adminlte.min.js"></script>
  <script src="assets/dist/js/main.js"></script>
  <script src="controller/LoginController.js"></script>
</body>
</html>