<?php
include '../../include/db.php';
if($_SERVER['REQUEST_METHOD'] == 'GET') {

	$reservation_id = $_GET['reservation_id'];

	$query = mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_id = '$reservation_id'");

	$profile = array();
	// if ($rows = mysqli_num_rows($query) > 0) {

		while($row = mysqli_fetch_array($query)) {

			$resType = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservation_type_tbl WHERE reservation_type_id = '{$row['reservation_type']}'"));
			
			$index['reservation_type'] = $resType['reservation_type'];
			$index['reservation_date_time'] = date('F j (l), Y', strtotime($row['reservation_date'])) .'@'.$row['reservation_time'];

			array_push($profile, $index);

		}
		
	// }else{
		
	// }

	echo json_encode($profile);

}
?>