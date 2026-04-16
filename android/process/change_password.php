<?php
include '../../include/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$email = mysqli_escape_string($con, $_POST['email']);
	$password = mysqli_escape_string($con, $_POST['password']);
	$confirm_password = mysqli_escape_string($con, $_POST['confirm_password']);

	if ($password == $confirm_password) {
		
		$query = mysqli_query($con, "UPDATE members_tbl SET password = '$password' WHERE email = '$email'");

		if ($query) {
			echo "Success";
		}

	}else{
		echo "Error";
	}

}
?>