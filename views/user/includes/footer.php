  <div class="wrapper">
  <!-- MODAL NEW PASSWORD -->
  <div class="modal fade" id="modalNewPassword" tabindex="-1" role="dialog" aria-labelledby="modalNewPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title" id="modalNewPasswordLabel">Set You New Password</h5>
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button> -->
        </div>
        <form id="frm_new_password" class="frm_new_password">
          <div class="modal-body">
          
              <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control pr-password new_password" id="new_password" name="new_password" maxlength="8" placeholder="Enter new password" required>
              </div>
              <div class="form-group">
                <label for="confirm_new_password">Confirm New Password</label>
                <input type="password" class="form-control confirm_new_password" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm new password" required>
                <small id="passres" class="mt-1 passres"></small>
              </div>
              
              <!-- show password -->
              <div class="form-group mt-1">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input show_password" id="show_password">
                  <label class="custom-control-label text-muted" for="show_password">Show password</label>
                </div>
              </div>
          
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-primary btn-block btn_new_password" id="btn_new_password">Save password</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer class="main-footer">
      <strong class="footer-font ml-3 text-success">IETI &copy; <?php echo date('Y') ?> </strong>
      <div class="float-right d-none d-sm-inline-block">
        <strong class="footer-font mr-3">
          <span class="date" id="date"></span>
          <span class="mx-1">-</span>
          <span class="clock" id="clock"></span>
        </strong>
      </div>
  </footer>

  <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark p-3" style="overflow-y: scroll; height: 0px !important">
      <div class="control-sidebar-bg-image"></div>
        <!-- Control sidebar content goes here -->
        <h5 class="text-center">Customize Theme</h5>
        <hr class="mb-2 bg-white">
        <div class="p-2">
          <!-- Content of the sidebar goes here -->
          <!-- Choose image background -->
          <div class="row">
            <div class="col-12">
              <input type="radio" name="bg-theme" id="image1" value="1" class="bg-theme">
              <label for="image1" class="ml-2" id="label1">
                <img src="../../assets/dist/img/bg/default-bg.png" alt="bg1" class="img-fluid bg-theme-img active" style="width: 200px; height: 90px;">
                <small class="float-right mr-2">Default</small>
              </label>

            </div>
            <div class="col-12">
              <input type="radio" name="bg-theme" id="image2" value="2" class="bg-theme">
              <label for="image2" class="ml-2" id="label2">
                <img src="../../assets/dist/img/bg/city.jpg" alt="bg2" class="img-fluid bg-theme-img" style="width: 200px; height: 90px;">
                <small class="float-right mr-2">Night City</small>
              </label>
            </div>
            <div class="col-12">
              <input type="radio" name="bg-theme" id="image3" value="3" class="bg-theme">
              <label for="image3" class="ml-2" id="label3">
                <img src="../../assets/dist/img/bg/sunrise.jpg" alt="bg3" class="img-fluid bg-theme-img" style="width: 200px; height: 90px;">
                <small class="float-right mr-2">Moon Forest</small>
              </label>
            </div>
            <div class="col-12">
              <input type="radio" name="bg-theme" id="image4" value="4" class="bg-theme">
              <label for="image4" class="ml-2" id="label4">
                <img src="../../assets/dist/img/bg/leaves.jpg" alt="bg4" class="img-fluid bg-theme-img" style="width: 200px; height: 90px;">
                <small class="float-right mr-2">Leaves</small>
              </label>
            </div>
            <div class="col-12">
              <input type="radio" name="bg-theme" id="image5" value="5" class="bg-theme">
              <label for="image5" class="ml-2" id="label5">
                <img src="../../assets/dist/img/bg/dark-cloud.jpg" alt="bg5" class="img-fluid bg-theme-img" style="width: 200px; height: 90px;">
                <small class="float-right mr-2">Dark Cloud</small>
              </label>
            </div>
          </div>
        </div>
      </aside>
  <!-- /.control-sidebar -->
  </div>
  <script src="../../assets/plugins/jquery/jquery.min.js"></script>
  <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="../../assets/plugins/DataTables/datatables.min.js"></script>
  <script src="../../assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="../../assets/plugins/summernote/dist/summernote-bs4.js"></script>
  <script src="../../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="../../assets/dist/js/jquery.validate.js"></script>
  <script src="../../assets/dist/js/adminlte.min.js"></script>
  <script src="../../assets/dist/js/main.js"></script>
  <script src="../../controller/LoginController.js"></script>
  <script src="../../controller/PasswordController.js"></script>
  <script src="../../controller/ProfileController.js"></script>
  <script src="../../controller/ArchiveController.js"></script>
  <script src="../../controller/RequestController.js"></script>
  <script src="../../controller/NotificationController.js"></script>
  <script src="../../assets/plugins/validate-password-requirements/js/jquery.passwordRequirements.js"></script>

  <?php
    include_once('../../database/connection.php');

    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];

    $sql = "SELECT * FROM user_accounts WHERE user_id = '$userid' OR username = '$user_name'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
  
    if(password_verify('IETI_'.$userid, $row['password'])){
      echo "<script>
              $(document).ready(function(){
                $('#modalNewPassword').modal({
                  show: true,
                  backdrop: 'static',
                  keyboard: false
                });
              });
            </script>";
    }
  ?>
</body>
</html>