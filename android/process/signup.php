<?php
include '../../include/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$contact_number = $_POST['contact_number'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	// 

	$salt = "b04161ddebcee9d9e05616c1432a4041";

	$final_pass = $password.$salt;
	$final_pass = sha1($final_pass);

	if ($fname != '' && $lname != '' && $email != '' && $contact_number != '' && $username != '' && $password != '' && $confirm_password != '') {
		
		if ($password == $confirm_password) {

			$resEmail = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '$email'"));

			if ($resEmail['email'] != $email) {
				
				$resContact = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE contact_number = '$contact_number'"));

				if ($resContact['contact_number'] != $contact_number) {
					
					$resUname = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE username = '$username'"));

					if ($resUname['username'] != $username) {
						
						$query = mysqli_query($con, "INSERT INTO members_tbl (fname, lname, email, contact_number, username, password, account_status, text_p) VALUES ('$fname', '$lname', '$email', '$contact_number', '$username', '$final_pass', '1', '$password')");
						if ($query) {
							echo "Registered Successfully";
						}

					}else{
						echo "uname";
					}

				}else{
					echo "contact";
				}

			}else{
				echo "email";
			}
			

		}else{
			echo "not match";
		}

	}else{
		echo "empty";
	}

}
?>