<?php
include '../include/db.php';
if (isset($_POST['school_id'])) {
	$school_id = $_POST['school_id'];

	if ($school_id != '') {
		$qDep = mysqli_query($con, "SELECT * FROM departments_tbl WHERE school_id = '$school_id' ORDER BY department_name ASC");

		while ($rDep = mysqli_fetch_assoc($qDep)) {
			?>
			<option value="<?php echo $rDep['department_id']; ?>" title="<?php echo $rDep['department_name']; ?>"><?php echo $rDep['department_abbreviation']; ?></option>
			<?php
		}
	}else{
		?>
		<option value="">-Select Department-</option>
		<?php
	}

}
?>