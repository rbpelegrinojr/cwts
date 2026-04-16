<?php
include '../../include/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$reservation_id = $_POST['reservation_id'];
	$reservation_type = $_POST['reservation_type'];
	$reservation_date = $_POST['reservation_date'];
	$reservation_time = $_POST['reservation_time'];
	$reservation_description = $_POST['reservation_description'];
	$date_now = date('Y-m-d');

	$resRes = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_id = '$reservation_id'"));

	$resResType = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservation_type_tbl WHERE reservation_type = '$reservation_type'"));

	$resExist = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_type = '{$resResType['reservation_type_id']}' AND reservation_date = '$reservation_date' AND reservation_time = '$reservation_time'"));

	$resEmail = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$resRes['member_id']}'"));

	if ($reservation_type != 'Select Reservation' && $reservation_date != '' && $reservation_time != '') {
		if ($resExist['reservation_date'] != $reservation_date && $resExist['reservation_time'] != $reservation_time) {
		
			if ($reservation_date > $date_now) {
				
				$query = mysqli_query($con, "UPDATE reservations_tbl SET reservation_type = '{$resResType['reservation_type_id']}', reservation_date = '$reservation_date', reservation_time = '$reservation_time', reservation_description = '$reservation_description', reservation_status = '0' WHERE reservation_id = '$reservation_id'");

				if ($query) {
					$resMem = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$resEmail['member_id']}'"));
					$sms_content = "Reservation EDITED from ".$resMem['fname'].' '.$resMem['lname'].'('.$resResType['reservation_type'].' @ '.$reservation_date.'  '.$reservation_time.')';
					$qSms = mysqli_query($con, "INSERT INTO sms_tbl (contact_number, sms_content, date_sent, sms_status) VALUES ('09308242900', '$sms_content', '$date_now', '1')");

					if ($qSms) {
						echo "Thank you! The admin will verify your reservation.";
					}

				}

			}else{
				echo "old date";
			}

		}else{
			echo "no vacant";
		}
	}else{
		echo "empty";
	}

}
?>