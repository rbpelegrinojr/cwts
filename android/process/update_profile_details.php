<?php
include '../../include/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$fname = mysqli_escape_string($con, $_POST['fname']);
	$lname = mysqli_escape_string($con,$_POST['lname']);
	$email= mysqli_escape_string($con,$_POST['email']);
	$contact_number= mysqli_escape_string($con, $_POST['contact_number']);
	$username = mysqli_escape_string($con,$_POST['username']);
	$password = mysqli_escape_string($con,$_POST['password']);
	$confirm_password = mysqli_escape_string($con, $_POST['confirm_password']);
	$member_id = $_POST['member_id'];

	$salt = "b04161ddebcee9d9e05616c1432a4041";

	$final_pass = $password.$salt;
	$final_pass = sha1($final_pass);

	if ($fname != "" && $lname != "" && $email != "" && $contact_number != "" && $username != "" && $password != "" && $confirm_password != "") {
		if ($confirm_password == $password) {
		
			$resEmail = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE email != '$email' "));

			if ($resEmail['email'] != $email) {
				
				$resUname = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE username != '$username' "));

				if ($resUname['username'] != $username) {
					
					$resContact = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE contact_number != '$contact_number' "));

					if ($resContact['contact_number'] != $contact_number) {
						
						$query = mysqli_query($con, "UPDATE members_tbl SET fname = '$fname', lname = '$lname', contact_number = '$contact_number', email = '$email', username = '$username', password = '$final_pass' WHERE member_id = '$member_id' ");

						if ($query) {
							echo "Success";
						}else{
							echo mysqli_error($con);
						}

					}else{
						echo "Contact Number Already Exists";
					}

				}else{
					echo "Username Already Exists";
				}

			}else{
				echo "Email Already Exists.";
			}

		}else{
			echo "Password Don't Match.";
		}
	}else{
		echo "Fields must not be empty";
	}

}
?>