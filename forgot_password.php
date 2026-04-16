<?php include 'include/db.php';
$resSettings = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM settings_tbl"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
    <?php echo $resSettings['system_title']; ?>
  </title>
  <!--     Fonts and icons     -->
  <link href="assets/font.css" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="assets/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <script type="text/javascript" src="assetsUser/jquery-3.4.1.min.js"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
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
                  <h3 class="font-weight-bolder text-info text-gradient">Forgot Password</h3>
                  <p class="mb-0">Enter your Email to send Code</p>
                </div>
                <div class="card-body">
                <form action="forgot_password.php" method="POST">
                  
                  <div class="alert alert-info" id="empty" style="display: none;">
                    <center><label style="color: white;">Fields must not empty</label></center>
                  </div>
                  <div class="alert alert-warning" id="denied" style="display: none;">
                    <center><label style="color: white;">Login Denied. Account is for Verification.</label></center>
                  </div>
                  <?php
                  // if (isset($_REQUEST['btnCheckUname'])) {
                  // 	$email = mysqli_escape_string($con, $_REQUEST['email']);

                  // 	if ($email != '') {
                      
                  //     $res = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users_tbl WHERE email = '$email'"));

                  //     if ($res['email'] == $email) {
                        
                  //       // $query = mysqli_query($con, "INSERT INTO ")
                  //       $rand_code = mt_rand(100000,999999);
                  //       $resCode = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users_tbl WHERE code = '$rand_code'"));
                  //       $sms_content = "Your Forgot Password Code is ".$rand_code;
                  //       $date_sent = date('Y-m-d');
                  //       if ($resCode['code'] != $rand_code) {
                          
                         
                  //           $qCode = mysqli_query($con, "UPDATE users_tbl SET code = '$rand_code' WHERE email = '{$res['email']}'");

                  //           if ($qCode) {
                  //             header('location: verify_code.php?email='.$res['email']);
                  //           }

                  //       }

                  //     }else{
                 

                  // }

                  if (isset($_REQUEST['btnCheckUname'])) {
    $email = mysqli_escape_string($con, $_REQUEST['email']);

    if ($email != '') {

        // Check if user exists
        $res = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users_tbl WHERE email = '$email'"));

        if (!empty($res['email'])) {

            // Generate unique 6-digit code
            $rand_code = mt_rand(100000, 999999);
            $resCode = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users_tbl WHERE code = '$rand_code'"));
            $sms_content = "CWTS System \n\n Your Forgot Password Code is $rand_code";

            if (empty($resCode['code'])) {

                // Update code in DB
                $qCode = mysqli_query($con, "UPDATE users_tbl SET code = '$rand_code' WHERE email = '{$res['email']}'");

                if ($qCode) {

                    // --- SEND SMS SECTION ---
                    $contact = $res['contact_number']; // Make sure this column exists in users_tbl
                    $apiKey = "Baho_ka_buli"; // Your actual API key
                    $message = $sms_content;

                    function sendSMS($apiKey, $number, $message) {
                        $sms_api = "https://lintechsms.thesissystems.link";
                        $data = http_build_query(array(
                            'api_key' => $apiKey,
                            'num' => $number,
                            'msg' => $message
                        ));

                        $opts = array(
                            'http' => array(
                                'method'  => 'POST',
                                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                                'content' => $data,
                                'timeout' => 10
                            )
                        );

                        $context = stream_context_create($opts);
                        $response = @file_get_contents($sms_api, false, $context);
                        return ($response !== FALSE);
                    }

                    // Send the SMS
                    if (!empty($contact)) {
                        if (sendSMS($apiKey, $contact, $message)) {
                            $_SESSION['otp'] = $rand_code;
                            $_SESSION['otp_email'] = $res['email'];
                            $_SESSION['otp_time'] = time();

                            // Redirect after sending
                            header('Location: verify_code.php?email=' . $res['email']);
                            exit;
                        } else {
                            echo '<div class="alert alert-warning"><center><label style="color:white;">Failed to send SMS. Please try again.</label></center></div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning"><center><label style="color:white;">No contact number found for this account.</label></center></div>';
                    }
                }
            }
        } else {
            echo '<div class="alert alert-warning"><center><label style="color:white;">Email does not exist.</label></center></div>';
        }
    } else {
        echo '<div class="alert alert-warning"><center><label style="color:white;">Please fill in empty fields.</label></center></div>';
    }
}
                  ?>
                  <div role="form" method="POST" action="controller/login.php">
                    <label>Enter Email</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="email" placeholder="Email" aria-label="email" aria-describedby="email-addon">
                    </div>
                    <div class="text-center">
                      <input type="submit" class="btn bg-gradient-info w-100 mt-1 mb-0" name="btnCheckUname" value="SEND">
                    </div>
                  </div>
              	</form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-1 text-sm mx-auto">
                   
                    <a href="login_view" class="text-info text-gradient font-weight-bold">Login</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('assets/img/curved-images/church9.png')"></div>
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
            </script> <b>
    <?php echo $resSettings['system_title']; ?></b>
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="assetsUser/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>