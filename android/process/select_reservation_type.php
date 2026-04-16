<?php
include '../../include/db.php';
$query = mysqli_query($con, "SELECT * FROM reservation_type_tbl");
$return_arr['reservation_type'] = array();
while ($row = mysqli_fetch_array($query)) {
	array_push($return_arr['reservation_type'], array(
		'reservation_name'=>$row['reservation_type']
	));
}
echo json_encode($return_arr);
?>