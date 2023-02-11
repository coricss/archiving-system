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
          <a href="" data-toggle="modal" data-target="#forgotPassword">Forgot password?</a>
        </p>
        <!-- <p class="mb-0">
          <a href="register.html" class="text-center">Register a new membership</a>
        </p> -->
      </div>
    </div>
  </div>

  <!-- FORGOT PASSWORD MODAL -->
  <div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="modalNewPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title" id="modalNewPasswordLabel">Forgot Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_forgot_password" class="frm_forgot_password">
          <div class="modal-body">
          
              <div class="form-group">
                <label for="registered_email">Email</label>
                <input type="email" class="form-control pr-password registered_email" id="registered_email" name="registered_email" placeholder="Enter your registered email" required>
              </div>

          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-primary btn-block btn_forgot_password" id="btn_forgot_password">Send code</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- VERIFY CODE MODAL -->
  <div class="modal fade" id="verifyCode" tabindex="-1" role="dialog" aria-labelledby="modalNewPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title" id="modalNewPasswordLabel">Code Verification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frm_verify_code" class="frm_verify_code">
          <div class="modal-body">
          
              <div class="form-group">
                <label for="recovery_code">Enter code</label>
                <input type="text" class="form-control pr-password recovery_code" id="recovery_code" name="recovery_code" placeholder="Enter code from your email" required>
              </div>

          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-primary btn-block btn_submit_code" id="btn_submit_code">Submit</button>
          </div>
        </form>
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