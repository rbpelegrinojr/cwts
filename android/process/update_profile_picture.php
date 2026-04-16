<?php
include '../../include/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$target_dir = "../../profile_images";
	$member_id = $_POST['member_id'];
	$profile_image = $_POST['profile_image'];

	if (!file_exists($target_dir)) {
		mkdir($target_dir, 0777, true);
	}

	$target_dir = $target_dir ."/". rand() . "_". time() . ".jpeg";

	if (file_put_contents($target_dir, base64_decode($profile_image))) {

		$str = $target_dir;
		$url = "http://192.168.1.4/church/".substr($str, 6);

		$query = mysqli_query($con, "UPDATE members_tbl SET profile_image = '$url' WHERE member_id = '$member_id' ");

		if ($query) {
			
			echo "Success";
		}

	}else{
		echo "Error";
	}
}

?>