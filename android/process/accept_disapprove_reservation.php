<?php
include '../../include/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$reservation_id = $_POST['reservation_id'];
	$reservation_date = $_POST['reservation_date'];
	$reservation_time = $_POST['reservation_time'];
	$date_now = date('Y-m-d');

	$query = mysqli_query($con, "UPDATE reservations_tbl SET reservation_date = '$reservation_date', reservation_time = '$reservation_time', date_cancelled = '', disapproved_date = '', disapprove_new_date = '', disapprove_new_time = '', disapprove_reason = '', reservation_status = '0' WHERE reservation_id = '$reservation_id'");

	if ($query) {
		echo "Thank you! The admin will send you an SMS if the reservation is appoved.";
	}

}
?>