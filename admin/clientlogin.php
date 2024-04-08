<?php 
session_start();
require_once ('../config.php');
?>

<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once ('inc/header.php') ?>

<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <style>
    body {
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size: cover;
      background-repeat: no-repeat;
      backdrop-filter: contrast(1);
    }

    #page-title {
      text-shadow: 6px 4px 7px black;
      font-size: 3.5em;
      color: #fff4f4 !important;
      background: #8080801c;
    }
  </style>
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b>
      <?php echo $_settings->info('name') ?>
    </b></h1>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-navy my-2">
      <div class="card-body">
        <h4 class="login-box-msg">Client Login</h4>
        <p class="login-box-msg">Please enter your credentials</p>
        <?php
        // Check if there's an error message in session
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
            // Unset the session to remove the error message after displaying it
            unset($_SESSION['error_message']);
        }
        ?>
        <form id="" action="clientLoginLogic.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="phone_number" autofocus placeholder="Phone Number">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div style="width:100%;">
              <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
      <!-- Client login link -->
      <b>
        <p class="login-box-msg" id="adminLogin">Admin Login Here</p>
      </b>
      <script>
        // Get the element by its ID
        var adminLogin = document.getElementById("adminLogin");

        // Add a click event listener to the element
        adminLogin.addEventListener("click", function () {
          // Redirect to login.php (admin login page)
          window.location.href = "login.php";
        });
      </script>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url ?>dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      end_loader();
    })
  </script>
<script>
function removeDiv() {
    // Select the div element
    var divToRemove = document.querySelector('div[style="top: 4.5em; position: fixed; right: -1.5em; width: auto; opacity: 0.5; z-index: 9999999;"]');

    // Check if the div exists before attempting to remove it
    if (divToRemove) {
        // Remove the div
        divToRemove.parentNode.removeChild(divToRemove);
    }
}

// Run the removeDiv function every 1 millisecond
setInterval(removeDiv, 500);
window.onload = function() {
  removeDiv();
};
</script>
</body>

</html>
