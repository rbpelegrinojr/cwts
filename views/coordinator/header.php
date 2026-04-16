<?php include '../../include/db.php';
session_start();
$action_url = "../../controller/admin/process/";

include '../../include/auto_update_schedules.php';

$username = $_SESSION['username'];
$user_id = $_SESSION['uid'];

$resSession = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users_tbl WHERE username = '$username'"));

if ($resSession['username'] != $username) {
	$username = null;
	$username = '';
	session_destroy();
}
if (empty($username)) {
	header('location: ../../coordinator');
}

if (isset($_REQUEST['btnLogout'])) {
	$username = null;
	$username = '';
	session_destroy();
	header('location: ../../coordinator');
}
$resInfo = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users_tbl WHERE user_id = '$user_id'"));
$resSettings = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM settings_tbl"));
?>
<!DOCTYPE html>
<html lang="zxx">
<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title><?php echo $resSettings['system_title']; ?></title>
<link rel="icon" href="img/logo.png" type="image/png">

<link rel="stylesheet" href="assets/bootstrap.min.css" />

<!-- <link rel="stylesheet" href="assets/themify-icons.css" /> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- <link rel="stylesheet" href="assets/nice-select.css" />

<link rel="stylesheet" href="assets/owl.carousel.css" />

<link rel="stylesheet" href="assets/gijgo.min.css" /> -->

<link rel="stylesheet" href="assets/all.min.css" />
<link rel="stylesheet" href="assets/tagsinput.css" />

<!-- <link rel="stylesheet" href="assets/date-picker.css" />
<link rel="stylesheet" href="assets/vectormap-2.0.2.css" /> -->

<link rel="stylesheet" href="assets/scrollable.css" />

<!-- <link rel="stylesheet" href="assets/jquery.dataTables.min.css" />
<link rel="stylesheet" href="assets/responsive.dataTables.min.css" />
<link rel="stylesheet" href="assets/buttons.dataTables.min.css" /> -->

<link rel="stylesheet" href="assets/summernote-bs4.css" />

<link rel="stylesheet" href="assets/morris.css">

<link rel="stylesheet" href="assets/material-icons.css" />

<link rel="stylesheet" href="assets/metisMenu.css">

<!-- <link rel="stylesheet" href="assets/core-main.css">
<link rel="stylesheet" href="assets/daygrid-main.css">
<link rel="stylesheet" href="assets/timegrid-main.css">
<link rel="stylesheet" href="assets/list-main.css"> -->

<link rel="stylesheet" href="assets/style.css" />
<link rel="stylesheet" href="assets/colors/default.css" id="colorSkinCSS">
<!-- <script src="assets/jquery-3.4.1.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<style type="text/css">
	.main_content .main_content_iner.overly_inner::before{
		background: #4aa9ff;
	}
	.footer_part{
			background: #4aa9ff;
		}
		.footer_part .footer_iner.text-center{
			background: #4aa9ff;
		}
</style>

</head>
<body class="crm_body_bg">

<?php include '../../controller/coordinator/page_controller/sidebar.php'; ?>

<section class="main_content dashboard_part large_header_bg">

<div class="container-fluid no-gutters">
<div class="row">
<div class="col-lg-12 p-0 ">
<!-- <div class="header_iner d-flex justify-content-between align-items-center" style="background: #ffdf00;"> -->
<div class="header_iner d-flex justify-content-between align-items-center" >
<div class="sidebar_icon d-lg-none">
<i class="ti-menu"></i>
</div>
<!-- <h3>Catholic<label style="font-size: 15px;">Evant</label> Management System</h3> -->
<h3><?php echo $resSettings['system_title']; ?></h3>
<div class="serach_field-area d-flex align-items-center">
<div class="search_inner">
<form action="#">
<div class="search_field">
<!-- <input type="text" placeholder="Search here..."> -->
</div>
<button type="submit"> <img src="img/icon/icon_search.svg" alt=""> </button>
</form>
</div>
<span class="f_s_14 f_w_400 ml_25 white_text text_white">Apps</span>
</div>
<div class="header_right d-flex justify-content-between align-items-center">
<div class="header_notification_warp d-flex align-items-center">
<li>
<!-- <a class="bell_notification_clicker nav-link-notify" href="#"> <img src="img/icon/bell.svg" alt=""></a> -->

<div class="Menu_NOtification_Wrap">
<div class="notification_Header">
<h4>Notifications</h4>
</div>
<div class="Notification_body">

<div class="single_notify d-flex align-items-center">
<div class="notify_thumb">
<a href="#"><img src="img/staf/2.png" alt=""></a>
</div>
<div class="notify_content">
<a href="#"><h5>Cool Marketing </h5></a>
<p>Lorem ipsum dolor sit amet</p>
</div>
</div>

<div class="single_notify d-flex align-items-center">
<div class="notify_thumb">
<a href="#"><img src="img/staf/4.png" alt=""></a>
</div>
<div class="notify_content">
<a href="#"><h5>Awesome packages</h5></a>
<p>Lorem ipsum dolor sit amet</p>
</div>
</div>


</div>
<div class="nofity_footer">
<div class="submit_button text-center pt_20">
<a href="#" class="btn_1">See More</a>
</div>
</div>
</div>

</li>
<li>
<!-- <a class="CHATBOX_open nav-link-notify" href="#"> <img src="img/icon/msg.svg" alt=""> </a> -->
</li>
</div>
<div class="profile_info">
<img style="height: 100px; width: 100px;" src="../../profile_images/empty.jpg" alt="#">
<div class="profile_info_iner">
<div class="profile_author_name">
<p>Coordinators </p>
<label style="color: white;"><?php echo $resSession['fname']." ".$resSession['lname']; ?></label>
</div>
<div class="profile_info_details">
<a href="open2.php?btnOpenApp=1">Attendance </a>
<a href="open.php?btnOpenApp=1">Register </a>
<!-- 
<a href="logs_view"><span class="fa fa-book"></span>Logs</a>
<a href="settings_view"><span class="fa fa-cog"></span> Settings</a> -->
<!-- <a href="profile_view"><span class="fa fa-user"></span> My Profile </a> -->
<!-- <a href="settings_view"><span class="fa fa-cog"></span> Settings</a> -->
<a href="index.php?btnLogout=1">Log Out </a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

