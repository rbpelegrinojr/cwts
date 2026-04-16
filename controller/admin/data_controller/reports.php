<?php
include '../../../include/db.php';


if (isset($_POST['btnFilter'])) {
	
	$month = $_POST['month'];
	$year = $_POST['year'];

	if ($month != '' && $year != '') {
		
		$query = mysqli_query($con, "SELECT * FROM reports_tbl WHERE MONTH(report_date) = '$month' AND YEAR(report_date) = '$year' ");
		
		if ($rows = mysqli_num_rows($query) > 0) {
			# code...
		}else{
			?>
			<center><div class="alert alert-warning"><h5>No Data Available</h5></div></center>
			<?php
		}

	}elseif ($month != '' && $year == '') {
		$query = mysqli_query($con, "SELECT * FROM reports_tbl WHERE MONTH(report_date) = '$month' ");
		if ($rows = mysqli_num_rows($query) > 0) {
			# code...
		}else{
			?>
			<center><div class="alert alert-warning"><h5>No Data Available</h5></div></center>
			<?php
		}
	}elseif ($month == '' && $year != '') {
		$query = mysqli_query($con, "SELECT * FROM reports_tbl WHERE YEAR(report_date) = '$year' ");
		if ($rows = mysqli_num_rows($query) > 0) {
			# code...
		}else{
			?>
			<center><div class="alert alert-warning"><h5>No Data Available</h5></div></center>
			<?php
		}
	}elseif ($month == '' && $year == '') {
		$query = mysqli_query($con, "SELECT * FROM reports_tbl ");
		if ($rows = mysqli_num_rows($query) > 0) {
			# code...
		}else{
			?>
			<center><div class="alert alert-warning"><h5>No Data Available</h5></div></center>
			<?php
		}
	}

}else{
	$query = mysqli_query($con, "SELECT * FROM reports_tbl ");
	if ($rows = mysqli_num_rows($query) > 0) {
		# code...
	}else{
		?>
		<center><div class="alert alert-warning"><h5>No Data Available</h5></div></center>
		<?php
	}
}

$i = 1;
while ($row = mysqli_fetch_assoc($query)) {
	$resStud = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM students_tbl WHERE student_id = '{$row['student_id']}'"));
	$resTeach = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM teachers_tbl WHERE teacher_id = '{$row['teacher_id']}' "));
	?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php echo $resTeach['fname'].' '.$resTeach['lname']; ?></td>
		<td><?php echo $resStud['fname'].' '.$resStud['lname']; ?></td>
		<td><?php echo $row['report_context']; ?></td>
		<td><?php echo $row['report_date']; ?></td>
	</tr>
	<?php
}
?>