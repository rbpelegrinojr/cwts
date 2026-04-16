<?php
include '../../include/db.php';

	$resUser = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '{$_GET['email_session']}'"));

	$query = mysqli_query($con, "SELECT * FROM reservations_tbl WHERE member_id = '{$resUser['member_id']}' AND reservation_status != '3'");

	$announcement = array();
	// if ($rows = mysqli_num_rows($query) > 0) {

		while($row = mysqli_fetch_array($query)) {

			$resResv = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservation_type_tbl WHERE reservation_type_id = '{$row['reservation_type']}'"));

			$index['reservation_name'] = $resResv['reservation_type'];
			$index['reservation_date'] = $row['reservation_date'];
			$index['reservation_time'] = $row['reservation_time'];
			$index['reservation_id'] = $row['reservation_id'];

			if ($row['reservation_status'] == '0') {
				$index['reservation_status'] = 'Pending';
			}elseif ($row['reservation_status'] == '1') {
				$index['reservation_status'] = 'Approved';
			}elseif ($row['reservation_status'] == '2') {
				$index['reservation_status'] = 'Disapproved';
			}elseif ($row['reservation_status'] == '3') {
				$index['reservation_status'] = 'Cancelled';
			}elseif ($row['reservation_status'] == '4') {
				$index['reservation_status'] = 'Completed';
			}elseif ($row['reservation_status'] == '6') {
				$index['reservation_status'] = 'Pending Edit';
			}

			array_push($announcement, $index);

		}
		
	// }else{
		
	// }

	echo json_encode($announcement);


?>