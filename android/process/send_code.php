<?php
include '../../include/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$rand_code = mt_rand(100000,999999);

	$email = mysqli_escape_string($con, $_POST['email']);

	$resEmail = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '$email'"));

	if ($resEmail['email'] == $email) {
		
		$query = mysqli_query($con, "UPDATE members_tbl SET code = '$rand_code' WHERE email = '$email'");

		if ($query) {
			$sms_content = "Your forgot password code is ".$rand_code.'.';
			$date_now = date('Y-m-d');
			$q2 = mysqli_query($con, "INSERT INTO sms_tbl (member_id, sms_content, sms_type, date_sent, sms_status, contact_number) VALUES ('{$resEmail['member_id']}', '$sms_content', '4', '$date_now', '1', '{$resEmail['contact_number']}')");

			if ($q2) {
				echo "Code Sent. Please check your messages.";
			}
			
		}

	}else{
		echo "Email Dont Exist";
	}

}
?>