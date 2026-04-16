<?php
include '../include/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta id="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Gender and Development Management System With Sms Notification 
  </title>
  <!--     Fonts and icons     -->
  <link href="../assets/font.css" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="../assets/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
  <!-- Navbar -->
  <!-- <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent mt-4">
    <div class="container">
      <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" href="pages/dashboards/default.html">
        Gender and Development Management System
      </a>
      
    </div>
  </nav> -->
  <!-- End Navbar -->
  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Welcome to</h1>
            <p class="text-lead text-white">NIPSC Gender and Development Management System</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <!-- <div class="row mt-lg-n10 mt-md-n11 mt-n10"> -->
      <div class="row mt-lg-n11 mt-md-n11 mt-n10"> 
        <div class="col-xl-6 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Register</h5>
            </div>
            <div class="card-body">
              <div role="form text-left" action="controller/register.php" method="POST">
                <div class="row">
                  <div class="col-md-4">
                    <label>First Name</label>
                    <input type="text" class="form-control" id="fname" placeholder="First Name" aria-label="First Name" >
                  </div>
                  <div class="col-md-4">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" id="mname" placeholder="Middle Name" aria-label="Middle Name" >
                  </div>
                  <div class="col-md-4">
                    <label>Last Name</label>
                    <input type="text" class="form-control" id="lname" placeholder="Last Name" aria-label="Last Name" >
                  </div>
                </div>

                <div class="row">

                  <div class="col-md-6">
                    <label>School</label>
                    <select class="form-control" id="school_id" required="" style="font-size: 13px;">
                      <option value="">-Select School-</option>
                      <?php
                      $qSchool = mysqli_query($con, "SELECT * FROM schools_tbl ORDER BY school_name ASC");
                      while ($rSchool = mysqli_fetch_assoc($qSchool)) {
                        ?>
                        <option value="<?php echo $rSchool['school_id']; ?>" title="<?php echo $rSchool['school_name']; ?>"><?php echo $rSchool['school_abbreviation']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label>Department</label>
                    <select class="form-control" id="department_id" required="" style="font-size: 13px;">
                      <option value="">-Select Department-</option>
                    </select>
                  </div>

                  
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" aria-label="Last Name" >
                  </div>
                  <div class="col-md-6">
                    <label>Contact Number</label>
                    <input type="text" class="form-control" id="contact_number" placeholder="Contact Number" aria-label="Last Name" >
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <label>Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Username" aria-label="Last Name" >
                  </div>
                  <div class="col-md-4">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" aria-label="Last Name" >
                  </div>
                  <div class="col-md-4">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" placeholder="Password" aria-label="Last Name" >
                  </div>
                </div>

                <div class="text-center">
                  <input type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2" id="btnRegCoord" value="Register">
                </div>
                <p class="text-sm mt-3 mb-0">Already have an account? <a href="index" class="text-dark font-weight-bolder">Sign in</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> NIPSC Gender and Development Management System With Sms Notification
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
  <script type="text/javascript" src="../assetsUser/jquery-3.4.1.min.js"></script>
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
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      var emailInput;

      $("#email").on("change", function() {
        emailInput = $(this).val();

        if (validateEmail(emailInput)) {
          $(this).css({
            color: "#495057",
            border: "1px solid #d2d6da"
          });
        } else {
          $(this).css({
            color: "red",
            border: "1px solid red"
          });

          // alert("not a valid email address");
        }
      });

      $('#btnRegCoord').click(function () {
        var fname = $('#fname').val();
        var mname = $('#mname').val();
        var lname = $('#lname').val();
        var email = $('#email').val();
        var contact_number = $('#contact_number').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        var school_id = $('#school_id').val();
        var department_id = $('#department_id').val();

        $.ajax({
          url:'../controller/register.php',
          method:'POST',
          data:{
            btnRegCoord:1,
            fname:fname,
            mname:mname,
            lname:lname,
            email:email,
            contact_number:contact_number,
            username:username,
            password:password,
            school_id:school_id,
            department_id:department_id,
            confirm_password:confirm_password
          },
          success:function (dataEcho) {
            if (dataEcho == 'success') {
              alert('Wait for your account Verification. Thank you.');
              window.location.href='index';
            }else if (dataEcho == 'username exist') {
              alert('Username Already Exists');
            }else if (dataEcho == 'contact exist') {
              alert('Contact Number Already Exists');
            }else if (dataEcho == 'email exist') {
              alert('Email Already Exists');
            }else if (dataEcho == 'password not match') {
              alert('Password not match');
            }else if (dataEcho == 'empty') {
              alert('Please fill in empty fields.');
            }else if (dataEcho == 'not email') {
              alert('Please Enter Valid Email');
            }
          }
        });

      });


      function validateEmail(email) {
        var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        return $.trim(email).match(pattern) ? true : false;
      }
     

    });
  </script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#school_id').change(function () {
        var school_id = $('#school_id').val();
        $.ajax({
          url:'departments.php',
          method:'POST',
          data:{
            school_id:school_id
          },
          success:function (viewDep) {
            $('#department_id').html(viewDep);
          }
        });
      });
    })
  </script>
</body>

</html>