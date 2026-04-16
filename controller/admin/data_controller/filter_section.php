<?php
include '../../../include/db.php';
if (isset($_POST['grade_id'])) {
	
	if ($_POST['grade_id'] != '') {
		$qSec = mysqli_query($con, "SELECT * FROM sections_tbl WHERE grade_id = '{$_POST['grade_id']}'");

		while ($resSection = mysqli_fetch_assoc($qSec)) {
			?>
			<option value="<?php echo $resSection['section_id']; ?>"><?php echo $resSection['section_name']; ?></option>
			<?php
		}
	}else{
		echo "Alert";
	}

}
?>