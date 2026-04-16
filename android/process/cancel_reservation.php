<?php
include '../../include/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$date_now = date('Y-m-d');
	$reservation_id = $_POST['reservation_id'];
	$query = mysqli_query($con, "UPDATE reservations_tbl SET reservation_status = '3', date_cancelled = '$date_now' WHERE reservation_id = '$reservation_id' ");

	if ($query) {
		echo "Cancelled";
	}else{
		echo msqli_error($con);
	}

}

?>