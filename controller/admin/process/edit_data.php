<?php
include '../../../include/db.php';
if (isset($_REQUEST['btnArchiveEvent'])) {
	
	$query = mysqli_query($con, "UPDATE events_tbl SET archive_status = '0' WHERE event_id = '{$_REQUEST['e_id']}'");

	header('location: '.$_REQUEST['global_url']);

}
?>