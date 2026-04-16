<?php
include '../include/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    NIPSC Gender and Development Management System With Sms Notification
  </title>
  <!--     Fonts and icons     -->
  <link href="../assets/font.css" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="../assets/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script type="text/javascript" src="../assetsUser/jquery-3.4.1.min.js"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Change Password</h3>
                  <p class="mb-0">Please Enter your New Password</p>
                </div>
                <div class="card-body">
                  
                  <form action="change_password.php?email=<?php echo $_REQUEST['email']; ?>" method="POST">
                    <?php
                    if (isset($_REQUEST['btnChangePass'])) {
                    	$confirm_password = mysqli_escape_string($con, $_REQUEST['confirm_password']);
                    	$query = mysqli_query($con, "UPDATE coordinators_tbl SET password = '$confirm_password' WHERE email = '{$_REQUEST['email']}'");
                    	if ($query) {

                        $qCode = mysqli_query($con, "UPDATE coordinators_tbl SET code = '' WHERE email = '{$_REQUEST['email']}'");

                        if ($qCode) {
                          ?>
                          <script type="text/javascript">
                            alert('Password Changed');
                            window.location.href='index';
                          </script>
                          <?php
                        }
                    		
                    	}
                    }
                    ?>
                    <!-- <div class="alert alert-warning" id="denied" style="display: none;">
                    <center><label style="color: white;">Login Denied. Account is for Verification.</label></center>
                  </div> -->
                    <div role="form">
                      <label>New Password</label>
                      <div class="mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Username" aria-label="Username" aria-describedby="email-addon">
                      </div>
                      <label>Confirm Password</label>
                      <div class="mb-3">
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                      </div>
                      <div class="text-center">
                        <input type="submit" class="btn bg-gradient-info w-100 mt-1 mb-0" id="btnChangePass" name="btnChangePass" value="CHANGE">
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">

      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> <b>GAD SYSTEM</b>
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script type="text/javascript">

    $(document).ready(function () {
      $('#btnChangePass').attr('disabled', true);
      $('#confirm_password').keyup(function () {
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();

        if (password == confirm_password) {
          $('#password').css({color: "#495057",border: "1px solid #d2d6da"});
          $('#confirm_password').css({color: "#495057",border: "1px solid #d2d6da"});
          $('#btnChangePass').attr('disabled', false);
        }else if(password != confirm_password){
          $('#password').css({color: "red",border: "1px solid red"});
          $('#confirm_password').css({color: "red",border: "1px solid red"});
          $('#btnChangePass').attr('disabled', true);
        }

      });

    });

  </script>
  <!-- Github buttons -->
  <script async defer src="../assetsUser/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>