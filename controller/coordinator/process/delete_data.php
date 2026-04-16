<?php
include '../../../include/db.php';
if (isset($_REQUEST['btnDelEvent'])) {
	$query = mysqli_query($con, "DELETE FROM events_tbl WHERE event_id = '{$_REQUEST['e_id']}'");
	if ($query) {
		?>
		<script type="text/javascript">
			window.location.href='../../../views/admin/events_view';
		</script>
		<?php
	}
}elseif (isset($_REQUEST['btnDenyUser'])) {
	$resU = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$_REQUEST['m_id']}'"));

	$member_name = $resU['fname'].' '.$resU['lname'];

	$date_sent = date('Y-m-d');

	$sms_content = "Good day ".$resU['fname']." ".$resU['lname']." Your account has been denied.";

	$qSms = mysqli_query($con, "INSERT INTO sms_tbl (member_id, sms_content, contact_number, date_sent, sms_status, member_name) VALUES ('{$resU['member_id']}', '$sms_content', '{$resU['contact_number']}', '$date_sent', '1', '$member_name')");

	if ($qSms) {

		$query = mysqli_query($con, "DELETE FROM members_tbl WHERE member_id = '{$resU['member_id']}'");

		if ($query) {
			?>
			<script type="text/javascript">
				window.location.href='../../../views/coordinator/pending_accounts_view';
			</script>
			<?php
		}
		
	}


}
?>