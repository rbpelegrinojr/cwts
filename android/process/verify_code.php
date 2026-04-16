<?php
include '../../include/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$email = mysqli_escape_string($con, $_POST['email']);
	$code = mysqli_escape_string($con, $_POST['code']);

	$resEmail = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '$email' AND code = '$code'"));

	if ($resEmail['email'] == $email && $resEmail['code'] == $code) {
		
		$query = mysqli_query($con, "UPDATE members_tbl SET code = '' WHERE email = '$email'");

		if ($query) {
			
			echo "Success";

		}

	}else{
		echo "Error";
	}

}
?>