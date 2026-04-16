<?php include 'header.php'; ?>
<script src="../../assets/js/webcam.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/profile_style.css">
<style type="text/css">

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {
        .card-settings{
            margin-top: 12%;
        }
        .alerts{
          position: fixed;
          margin: 0px;
          z-index: 999999;
          display: inline-block;
          top: 30px;
          right: 40%;
          display: none;
        }

    } 
    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
      .card-settings{
            margin-top: 8%;
        }

        .alerts{
          position: fixed;
          margin: 0px;
          z-index: 999999;
          display: inline-block;
          top: 30px;
          right: 40%;
          display: none;
        }

    }
    /* Extra small devices (phones, 600px and down) */
    @media only screen and (max-width: 600px) {
      .card-settings{
            margin-top: 50%;
        }

        .alerts{
          position: fixed;
          margin: 0px;
          z-index: 999999;
          display: inline-block;
          top: 30px;
          right: 20%;
          display: none;
        }
    }
    
</style>
<style type="text/css">

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {
        .cap-img{
         height: 150px; width:180px;
        }
        .results{
            margin-top: 5.4%; margin-left: 5%;
        }
        .my_camera{
            height: 200px; width: 200px; margin-left: 5%;
        }

        .main-cam-div{
            margin-left: 2%;
        }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
      .cap-img{
         height: 150px; width:180px;
        }
        .results{
            margin-top: 5.4%; margin-left: 5%;
        }
        .my_camera{
            height: 200px; width: 200px; margin-left: 5%;
        }

        .main-cam-div{
            margin-left: 2%;
        }
    }


    /* Extra small devices (phones, 600px and down) */
    @media only screen and (max-width: 600px) {
      .cap-img{
         height: 150px; width:200px;
        }
        .results{
            margin-top: 5.4%; margin-left: 5%;
        }
        .my_camera{
            height: 200px; width: 200px; margin-left: 5%;
        }
        .main-cam-div{
            margin-left: 13%;
        }
    }

    /* Small devices (portrait tablets and large phones, 600px and up) */
    @media only screen and (min-width: 600px) {
      .cap-img{
         height: 150px; width:200px;
        }
        .results{
            margin-top: 5.4%; margin-left: 5%;
        }
        .my_camera{
            height: 200px; width: 200px; margin-left: 5%;
        }
        .main-cam-div{
            margin-left: 10%;
        }
    }

    @media only screen and (min-width: 1366px) {
      .cap-img{
         height: 150px; width:180px;
        }
        .results{
            margin-top: 5.4%; margin-left: 5%;
        }
        .my_camera{
            height: 200px; width: 200px; margin-left: 5%;
        }
        .main-cam-div{
            margin-left: 2%;
        }
    }

</style>

<div class="main_content_iner overly_inner ">
  <div class="container-fluid p-0 ">
    <div class="row">
          <div class="col-12">
              <div class="page_title_box d-flex align-items-center justify-content-between">
                  <div class="page_title_left">
                      <h3 class="f_s_30 f_w_700 text_white">My Profile</h3>
                      <ol class="breadcrumb page_bradcam mb-0">
                        <li class="breadcrumb-item"><a href="index">Dashboard </a></li>
                        <li class="breadcrumb-item active">Profile</li>
                      </ol>
                  </div>
              </div>
          </div>
      </div>

<div data-growl="container" class="alert alert-warning alert-dismissable growl-animated animated fadeInDown alerts" role="alert" data-growl-position="top-right" style="" id="unameEx">
    <span data-growl="message">Username Already Exist</span>
  </div>

  <div data-growl="container" class="alert alert-warning alert-dismissable growl-animated animated fadeInDown alerts" role="alert" data-growl-position="top-right" style="" id="numEx">
    <span data-growl="message">Contact Number Already Exist</span>
  </div>

  <div data-growl="container" class="alert alert-danger alert-dismissable growl-animated animated fadeInDown alerts" role="alert" data-growl-position="top-right" style="" id="fillin">
    <!-- <span data-growl="title"> Bootstrap Growl </span> -->
    <span data-growl="message">Fields Cannot be Empty</span>
  </div>

  <div data-growl="container" class="alert alert-success alert-dismissable growl-animated animated fadeInDown alerts" role="alert" data-growl-position="top-right" id="success-save">
    <span data-growl="title"> Profile Edited Successfully. </span>
    <span data-growl="message"> </span>
  </div>
  <form action="controller/users/process/save_data.php" method="POST" enctype="multipart/form-data">
<div class="main-content card-settings">
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a >
                    <img src="<?php if(empty($resSession['profile_image'])){ echo 'profile_images/empty.jpg'; }else{ echo $resSession['profile_image']; } ?>" style="height: 190px; width: 190px;" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
              <div class="d-flex justify-content-between">
                
              </div>
            </div>
            <div class="card-body pt-0 pt-md-4">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                  </div>
                </div>
              </div>
              <div class="text-center">
                <h3>
                  <?php echo $resSession['fname'].' '.$resSession['lname']; ?><span class="font-weight-light"></span>
                </h3>
                <div class="h5 font-weight-300">
                  <i class="ni location_pin mr-2"></i><?php echo $resRoles['role_name']; ?>
                </div>
                <div>
                  <i class="ni education_hat mr-2"></i><?php echo $resSession['contact_number']; ?>
                </div>
                <hr class="my-4">
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">My account</h3>
                </div>
                <div class="col-4 text-right">
                  <a href="#!" class="btn btn-sm btn-info">Profile</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div>
                <h6 class="heading-small text-muted mb-4">User information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">First Name</label>
                        <input type="text" name="fname" class="form-control form-control-alternative" placeholder="First Name" value="<?php echo $resSession['fname']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Middle Name</label>
                        <input type="text" name="mname" class="form-control form-control-alternative" placeholder="Middle Name" value="<?php echo $resSession['mname']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Last Name</label>
                        <input type="text" name="lname" class="form-control form-control-alternative" value="<?php echo $resSession['lname']; ?>">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-last-name">Gender</label>
                        <select class="form-control" name="gender" required="">
                          <option value="<?php echo $resGender['gender_id']; ?>"><?php echo $resGender['gender_name']; ?></option>
                          <?php
                          $qGend = mysqli_query($con, "SELECT * FROM gender_tbl WHERE gender_id != '{$resSession['gender']}'");
                          while ($rGend = mysqli_fetch_assoc($qGend)) {
                            ?>
                            <option value="<?php echo $rGend['gender_id']; ?>"><?php echo $rGend['gender_name']; ?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-last-name">Role</label>
                        <select class="form-control" name="role" required="">
                          <option value="<?php echo $resRoles['role_name']; ?>"><?php echo $resRoles['role_name']; ?></option>
                          <?php
                          $qRole = mysqli_query($con, "SELECT * FROM role_tbl WHERE role_name != '{$resSession['role']}'");
                          while ($rRole = mysqli_fetch_assoc($qRole)) {
                            ?>
                            <option value="<?php echo $rRole['role_id']; ?>"><?php echo $rRole['role_name']; ?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-first-name">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control form-control-alternative" placeholder="First name" value="<?php echo $resSession['contact_number']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-first-name">Email</label>
                        <input type="email" name="email" class="form-control form-control-alternative" placeholder="First name" value="<?php echo $resSession['email']; ?>">
                      </div>
                    </div>
                    
                  </div>

                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-first-name">Username</label>
                        <input type="text" name="username" class="form-control form-control-alternative" placeholder="First name" value="<?php echo $resSession['username']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-last-name">Password</label>
                        <input type="password" name="password" class="form-control form-control-alternative" placeholder="Last name" value="<?php echo $resSession['password']; ?>">
                      </div>
                    </div>
                    <input type="hidden" name="member_id" value="<?php echo $resSession['member_id'] ?>">
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-last-name">Profile Picture</label>
                        <input type="file" name="profile_image" class="form-control form-control-alternative" placeholder="Last name">
                      </div>
                    </div>
                  </div>

                </div>
                <hr class="my-4">
                <!-- Description -->
                <div class="pl-lg-4">
                  <div class="form-group focused">
                    <input type="submit" name="btnEditProfile" value="Save" class="btn btn-primary" style="float: right;">
                    
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

  <div class="modal fade" id="cameraModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Capture</h5>
                <!-- <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button> -->
            </div>
            <div class="modal-body">
                <center>
                    <div class="form-row main-cam-div">
                        <input type="hidden" name="image" id="image" class="image-tag">
                        <div id="results" class="results" style=""></div>
                        <div id="my_camera" class="my_camera" style=""></div>
                        <br/>
                        
                    </div>
                    <br>
                    <input type=button class="btn btn-warning btn-sm" value="Take Snapshot" id="take_snapshot" onClick="take_snapshot()">
                </center>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="check">Ok</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">

  function generate(m_id) {
    if (confirm('Are you sure you want to generate QR Code?')) {
      window.location.href='../../qrcodes/qrcode.php?m_id='+m_id+'';
    }
  }

    Webcam.set({
        width: 200,
        height: 200,
        image_format: 'jpeg',
        jpeg_quality: 800
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'" class="cap-img">';
        } );
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {

      $('#grade_id').change(function () {
            var grade_id = $('#grade_id').val();

            if (grade_id != '') {
                 $.ajax({
                    url:'../../controller/admin/data_controller/filter_section.php',
                    method:'POST',
                    data:{
                        grade_id:grade_id
                    },
                    success:function (filter_section) {
                        $('#section_id').html(filter_section);
                    }
                });
             }else{
                alert('Please select Grade');
                $('#section_id').html('<option value="">-Select Grade First-</option>');
             }
           
        });

        $('#btnEdit').click(function () {

            var fname = $('#fname').val();
      var mname = $('#mname').val();
      var lname = $('#lname').val();
      var guardian_name = $('#guardian_name').val();
      var age = $('#age').val();
      var sex = $('#sex').val();
      var username = $('#username').val();
      var password = $('#password').val();
      var contact_number = $('#contact_number').val();
      var address = $('#address').val();
      var student_id = $('#student_id').val();
      var image = $('#image').val();

            $.ajax({
                url:'../../controller/student/process/update_process.php',
                method:'POST',
                data:{
                    btnEdit:1,
                    fname:fname,
          mname:mname,
          lname:lname,
          guardian_name:guardian_name,
          age:age,
          sex:sex,
          username:username,
          password:password,
          contact_number:contact_number,
          address:address,
          student_id:student_id,
          image:image
                },
                success:function (msg) {
                    if (msg == 'updated') {
                        $('#success-save').fadeIn('fast').delay(500).fadeOut('fast', function () {
                          window.location.href='profile_view.php';
                        });
                    }else if (msg == 'fillin fields') {
                        $('#fillin').fadeIn('fast').delay(500).fadeOut('fast', function () {});
                    }else if (msg == 'uname ex') {
                        $('#unameEx').fadeIn('fast').delay(500).fadeOut('fast', function () {});
                    }else if (msg == 'num ex') {
                        $('#numEx').fadeIn('fast').delay(500).fadeOut('fast', function () {});
                    }
                }
            });

        });
    });
</script>
<?php include 'footer.php'; ?>