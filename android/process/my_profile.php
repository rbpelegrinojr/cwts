<?php
include '../../include/db.php';
if($_SERVER['REQUEST_METHOD'] == 'GET') {

	$email_session = $_GET['email_session'];

	$query = mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '$email_session'");

	$profile = array();
	// if ($rows = mysqli_num_rows($query) > 0) {

		while($row = mysqli_fetch_array($query)) {

			$index['profile_name'] = $row['fname']." ".$row['lname'];
			$index['profile_image'] = $row['profile_image'];

			array_push($profile, $index);

		}
		
	// }else{
		
	// }

	echo json_encode($profile);

}

?>