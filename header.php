<?php include 'include/db.php';
session_start();
$action_url = "../../controller/admin/process/";

$username = $_SESSION['username'];

$resSession = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE username = '$username'"));
$resGender = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM gender_tbl WHERE gender_id = '{$resSession['gender']}'"));
$resRoles = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM role_tbl WHERE role_id = '{$resSession['role']}'"));
if ($resSession['username'] != $username) {
	$username = null;
	$username = '';
	session_destroy();
}
if (empty($username)) {
	header('location: login_view');
}

if (isset($_REQUEST['btnLogout'])) {
	$username = null;
	$username = '';
	session_destroy();
	header('location: ../gad');
}

?>
<!DOCTYPE html>
<html lang="zxx">
<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title>GAD SYSTEM</title>
<link rel="icon" href="img/logo.png" type="image/png">

<link rel="stylesheet" href="assetsUser/bootstrap.min.css" />

<!-- <link rel="stylesheet" href="assetsUser/themify-icons.css" /> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="assetsUser/nice-select.css" />

<!-- <link rel="stylesheet" href="assetsUser/owl.carousel.css" /> -->

<!-- <link rel="stylesheet" href="assetsUser/gijgo.min.css" /> -->

<link rel="stylesheet" href="assetsUser/all.min.css" />
<link rel="stylesheet" href="assetsUser/tagsinput.css" />

<!-- <link rel="stylesheet" href="assetsUser/date-picker.css" />
<link rel="stylesheet" href="assetsUser/vectormap-2.0.2.css" /> -->
<!-- 
<link rel="stylesheet" href="assetsUser/scrollable.css" /> -->

<!-- <link rel="stylesheet" href="assetsUser/jquery.dataTables.min.css" />
<link rel="stylesheet" href="assetsUser/responsive.dataTables.min.css" />
<link rel="stylesheet" href="assetsUser/buttons.dataTables.min.css" /> -->

<link rel="stylesheet" href="assetsUser/summernote-bs4.css" />

<!-- <link rel="stylesheet" href="assetsUser/morris.css"> -->

<link rel="stylesheet" href="assetsUser/material-icons.css" />

<link rel="stylesheet" href="assetsUser/metisMenu.css">

<!-- Calendar -->
<!-- <link rel="stylesheet" href="assetsUser/core-main.css">
<link rel="stylesheet" href="assetsUser/daygrid-main.css">
<link rel="stylesheet" href="assetsUser/timegrid-main.css">
<link rel="stylesheet" href="assetsUser/list-main.css"> -->

<link rel="stylesheet" href="assetsUser/style.css" />
<!-- <link rel="stylesheet" href="assetsUser/colors/default.css" id="colorSkinCSS"> -->
</head>
<body class="crm_body_bg">


<?php include 'sidebar.php'; ?>

<section class="main_content dashboard_part large_header_bg">
<div class="container-fluid no-gutters">
<div class="row">
<div class="col-lg-12 p-0 ">
<div class="header_iner d-flex justify-content-between align-items-center">
<div class="sidebar_icon d-lg-none">

<i class="ti-menu"></i>
</div>
<h3>NIPSC GAD<label style="font-size: 15px;">(Gender and Development)</label> Management System</h3>
<div class="serach_field-area d-flex align-items-center">
<div class="search_inner">
<form action="#">
<div class="search_field">
<!-- <input type="text" placeholder="Search here..."> -->
</div>
<!-- <button type="submit"> <img src="img/icon/icon_search.svg" alt=""> </button> -->
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

<div class="single_notify d-flex align-items-center">
<div class="notify_thumb">
<a href="#"><img src="img/staf/3.png" alt=""></a>
</div>
<div class="notify_content">
<a href="#"><h5>what a packages</h5></a>
<p>Lorem ipsum dolor sit amet</p>
</div>
</div>

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

<div class="single_notify d-flex align-items-center">
<div class="notify_thumb">
<a href="#"><img src="img/staf/3.png" alt=""></a>
</div>
<div class="notify_content">
<a href="#"><h5>what a packages</h5></a>
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
<img style="height: 100px; width: 100px;" src="<?php if(empty($resSession['profile_image'])){ echo 'profile_images/empty.jpg'; }else{ echo $resSession['profile_image']; } ?>" alt="#">
<div class="profile_info_iner">
<div class="profile_author_name">
<p><?php echo $resRoles['role_name']; ?></p>
<p style="color: white;"><?php echo $resSession['fname'].' '.$resSession['mname'].', '.$resSession['lname']; ?></p>
</div>
<div class="profile_info_details">
<a href="profile_view">My Profile </a>
<a href="#" onclick="logout(1);">Log Out </a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
	function logout(l_id) {
		window.location.href='index?btnLogout='+l_id+'';
	}
</script>