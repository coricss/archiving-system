<?php 
  if(!isset($_SESSION)) {
    session_start();
  }

  if ((!isset($_SESSION['user_id'])) || ($_SESSION['user_type'] != 'admin') && ($_SESSION['user_type'] != 'director')) {
    header('location: /digital_archiving_management_system');
  }

  $_SESSION['announcements'] = 'active';

  unset($_SESSION['user_management']);
  unset($_SESSION['profile']);
  unset($_SESSION['file_archive']);
  unset($_SESSION['pending_admin']);
  unset($_SESSION['approved_admin']);
  unset($_SESSION['rejected_admin']);
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
          <h1>Announcements</h1>
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
      <div class="row mb-3">
        <div class="col-md-12 d-flex align-items-center justify-content-center">
          <div class="fb-post" data-href="https://m.facebook.com/story.php?story_fbid=pfbid0P9WYev9B2taEfwcraxS9n7JTooxy2A27JGoeYctGSfv2VVWUV9Xp3HwcpmP5YASfl&amp;id=1701405803265785&amp;mibextid=Nif5oz" data-width="750" data-show-text="true"><blockquote cite="https://www.facebook.com/ieticalamba/posts/8303299653076334" class="fb-xfbml-parse-ignore"><p>Greetings! IETI calamba is now open for Enrollment for S.Y. 2022-2023. Just click the link below https://forms.gle/ggxQs893dyfvqa196</p>Posted by <a href="https://facebook.com/ieticalamba">IETI Calamba</a> on&nbsp;<a href="https://www.facebook.com/ieticalamba/posts/8303299653076334">Thursday, June 16, 2022</a></blockquote></div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-12 d-flex align-items-center justify-content-center">
          <div class="fb-post" data-href="https://fb.watch/iibKCb3Euc/" data-width="750" data-show-text="true"><blockquote cite="https://www.facebook.com/ieticalamba/videos/175837706636820/" class="fb-xfbml-parse-ignore">Posted by <a href="https://facebook.com/ieticalamba">IETI Calamba</a> on&nbsp;<a href="https://www.facebook.com/ieticalamba/videos/175837706636820/">Sunday, April 21, 2019</a></blockquote></div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
  include_once('includes/footer.php');
?>