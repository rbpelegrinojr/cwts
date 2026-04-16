<?php
require_once('../PHPMailer/PHPMailerAutoload.php');
include '../include/db.php';

if (isset($_POST['btnSend'])) {

	$teacher_email = $_POST['teacher_email'];
	//$patient_code = $_POST['patient_code'];

	if ($teacher_email != '') {

		$resAdmin = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl"));

		$resStud = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM teachers_tbl WHERE email = '$teacher_email'"));

		//$code = sprintf("%06d", mt_rand(1, 999999));

		//$query = mysqli_query($con, "UPDATE patients_tbl SET patient_code = '$code' WHERE patient_id = '{$resPatient['patient_id']}' ");

		if ($resStud['email'] == $teacher_email) {
			
			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = '465';
			$mail->isHTML();
			$mail->Username = $resAdmin['admin_email'];
			$mail->Password = $resAdmin['email_password'];
			$mail->SetFrom('peslmms@gmail.com');
			$mail->Subject = 'Forgot Password';
			$mail->Body = 'Good day '.$resStud['fname'].' '.$resStud['lname'].', Your username is: <b><u>'.$resStud['username'].'</u></b> and the password is: <b><u>'.$resStud['password'].'</u></b>';
			$mail->AddAddress($teacher_email);


			if ($mail->Send()) {
				echo "Success";
			}

		}else{
			echo "error";
		}

	}else{
		
		echo "Empty";

	}

}


?>