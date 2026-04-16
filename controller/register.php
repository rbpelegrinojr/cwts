<?php
include '../include/db.php';
if (isset($_POST['btnUserReg'])) {
	//echo "string";
	$fname = mysqli_escape_string($con, $_POST['fname']);
	$mname = mysqli_escape_string($con, $_POST['mname']);
	$lname = mysqli_escape_string($con, $_POST['lname']);
	$gender = mysqli_escape_string($con, $_POST['gender']);
	$email = mysqli_escape_string($con, $_POST['email']);
	$contact_number = mysqli_escape_string($con, $_POST['contact_number']);
	$username = mysqli_escape_string($con, $_POST['username']);
	$password = mysqli_escape_string($con, $_POST['password']);
	$role = mysqli_escape_string($con, $_POST['role']);
	$confirm_password = mysqli_escape_string($con, $_POST['confirm_password']);
	$school_id = $_POST['school_id'];
	$department_id = $_POST['department_id'];

	$date_now = date('Y-m-d');

	if ($fname != '' && $mname != '' && $lname != '' && $gender != '' && $email != '' && $contact_number != '' && $username != '' && $password != '' && $role != '' && $confirm_password != '' && $school_id != '' && $department_id != '') {
		
		if ($password == $confirm_password) {
		
			$resEmail = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '$email'"));

			if ($resEmail['email'] != $email) {
				
				$resCont = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE contact_number = '$contact_number'"));

				if ($resCont['contact_number'] != $contact_number) {
					
					$resUname = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE username = '$username'"));

					if ($resUname['username'] != $username) {
						
						$query = mysqli_query($con, "INSERT INTO members_tbl (fname, mname, lname, gender, email, contact_number, username, password, role, date_created, account_status, school_id, department_id) VALUES ('$fname', '$mname', '$lname', '$gender', '$email', '$contact_number', '$username', '$password', '$role', '$date_now', '1', '$school_id', '$department_id')");

						if ($query) {
							echo "success";
							
						}

					}else{
						echo "username exist";
						
					}

				}else{
					echo "contact exist";
					
				}

			}else{
				echo "email exist";
				
			}

		}else{
			echo "password not match";
		}

	}else{
		echo "empty";
	}

}elseif (isset($_POST['btnRegCoord'])) {
	$fname = mysqli_escape_string($con, $_POST['fname']);
	$mname = mysqli_escape_string($con, $_POST['mname']);
	$lname = mysqli_escape_string($con, $_POST['lname']);
	$email = mysqli_escape_string($con, $_POST['email']);
	$contact_number = mysqli_escape_string($con, $_POST['contact_number']);
	$username = mysqli_escape_string($con, $_POST['username']);
	$password = mysqli_escape_string($con, $_POST['password']);
	$confirm_password = mysqli_escape_string($con, $_POST['confirm_password']);
	$school_id = $_POST['school_id'];
	$department_id = $_POST['department_id'];

	$date_now = date('Y-m-d');

	if ($fname != '' && $mname != '' && $lname != '' && $email != '' && $contact_number != '' && $username != '' && $password != '' && $confirm_password != '' && $school_id != '' && $department_id != '') {
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			if ($password == $confirm_password) {
		
				$resEmail = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM coordinators_tbl WHERE email = '$email'"));

				if ($resEmail['email'] != $email) {
					
					$resCont = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM coordinators_tbl WHERE contact_number = '$contact_number'"));

					if ($resCont['contact_number'] != $contact_number) {
						
						$resUname = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM coordinators_tbl WHERE username = '$username'"));

						if ($resUname['username'] != $username) {
							
							$query = mysqli_query($con, "INSERT INTO coordinators_tbl (fname, mname, lname, email, contact_number, username, password, date_created, account_status, school_id, department_id) VALUES ('$fname', '$mname', '$lname', '$email', '$contact_number', '$username', '$password', '$date_now', '1', '$school_id', '$department_id')");

							if ($query) {
								echo "success";
								
							}

						}else{
							echo "username exist";
							
						}

					}else{
						echo "contact exist";
						
					}

				}else{
					echo "email exist";
					
				}

			}else{
				echo "password not match";
			}
		}else{
			echo "not email";
		}

	}else{
		echo "empty";
	}
}
?>