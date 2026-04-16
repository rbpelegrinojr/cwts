<?php
include '../../../include/db.php';
if (isset($_REQUEST['btnEditProfile'])) {
	$fname = mysqli_escape_string($con, $_REQUEST['fname']);
	$mname = mysqli_escape_string($con, $_REQUEST['mname']);
	$lname = mysqli_escape_string($con, $_REQUEST['lname']);
	
	$gender = mysqli_escape_string($con, $_REQUEST['gender']);
	$role = mysqli_escape_string($con, $_REQUEST['role']);
	$contact_number = mysqli_escape_string($con, $_REQUEST['contact_number']);
	$email = mysqli_escape_string($con, $_REQUEST['email']);
	$username = mysqli_escape_string($con, $_REQUEST['username']);
	$password = mysqli_escape_string($con, $_REQUEST['password']);
	$member_id = mysqli_escape_string($con, $_REQUEST['member_id']);
	$url = "";

	$profile_image = $_FILES['profile_image']['name'];
	$tmpName = $_FILES['profile_image']['tmp_name'];

	move_uploaded_file($tmpName, "../../../profile_images/".$profile_image);

	$resU = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '$member_id'"));

	if (empty($profile_image)) {
		$url = $resU['profile_image'];
	}else{
		$url = "http://localhost/gad/profile_images/".$profile_image;
	}

	$query = mysqli_query($con, "UPDATE members_tbl SET fname = '$fname', mname = '$mname', lname = '$lname', gender = '$gender', role = '$role', contact_number = '$contact_number', email = '$email', username = '$username', password = '$password', member_id = '$member_id', profile_image = '$url' WHERE member_id = '$member_id'");

	if ($query) {

		$log_date = date('Y-m-d');
		$log_time = date('h:i a');

		$queryLog = mysqli_query($con, "INSERT INTO logs_tbl (member_id, action, log_date, log_time) VALUES ('$member_id', 'Updated Profile', '$log_date', '$log_time')");

		if ($queryLog) {
			?>
			<script type="text/javascript">
				alert('Profile Updated');
				window.location.href='../../../profile_view';
			</script>
			<?php
		}
		
	}

}
?>