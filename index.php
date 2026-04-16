<?php
include 'include/db.php';
error_reporting(0);
session_start();
$action_url = "../../controller/admin/process/";

$username = $_SESSION['username'];

$resSession = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE username = '$username'"));

if ($resSession['username'] != $username) {
    $username = null;
    $username = '';
    session_destroy();
}

if (isset($_REQUEST['btnLogout'])) {
    $username = null;
    $username = '';
    session_destroy();

    
}
if (empty($username)) {
    //header('location: login_view');
    include 'login_view.php';
}else{
    include 'home_view.php';
}
?>
