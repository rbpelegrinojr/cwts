<?php
include '../../include/db.php';


	$query = mysqli_query($con, "SELECT * FROM announcements_tbl ORDER BY announcement_id DESC");

	$announcement = array();
	// if ($rows = mysqli_num_rows($query) > 0) {

		while($row = mysqli_fetch_array($query)) {

			$index['announcement'] = $row['announcement'];
			//$index['announcement_status'] = $row['announcement_status'];
			$index['date_created'] = $row['date_created'];
			$index['subject_announcement'] = $row['subject_announcement'];

			if ($row['announcement_status'] == '1') {
				$index['announcement_status'] = 'Active';
			}elseif ($row['announcement_status'] == '0') {
				$index['announcement_status'] = 'Inactive';
			}

			array_push($announcement, $index);

		}
		
	// }else{
		
	// }

	echo json_encode($announcement);


?>