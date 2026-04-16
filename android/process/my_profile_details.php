<?php
include '../../include/db.php';
if($_SERVER['REQUEST_METHOD'] == 'GET') {

	$email_session = $_GET['email'];

	$query = mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '$email_session'");

	$profile = array();
	// if ($rows = mysqli_num_rows($query) > 0) {

		while($row = mysqli_fetch_array($query)) {

			$index['fname'] = $row['fname'];
			$index['lname'] = $row['lname'];
			$index['contact_number'] = $row['contact_number'];
			$index['username'] = $row['username'];
			$index['email'] = $row['email'];
			$index['password'] = $row['text_p'];
			$index['profile_image'] = $row['profile_image'];
			$index['member_id'] = $row['member_id'];
			array_push($profile, $index);

		}
		
	// }else{
		
	// }

	echo json_encode($profile);

}

?>