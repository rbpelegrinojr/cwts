<?php
include '../../include/db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$salt = "b04161ddebcee9d9e05616c1432a4041";

	$final_pass = $password.$salt;
	$final_pass = sha1($final_pass);

	if ($email != '' && $password != '') {
		$res = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '$email' AND password = '$final_pass'"));
		
		if ($res['email'] == $email && $res['password'] == $final_pass) {
			
			if ($res['account_status'] == '1') {
				$response['message'] = "exists";
			}elseif ($res['account_status'] == '0') {
				$response['message'] = "blocked";
			}

		}else{
			$response['message'] = "failed";
		}

	}else{
		$response['message'] = "empty";
	}

	echo json_encode($response);

}
?>