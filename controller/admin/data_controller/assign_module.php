<?php
$query = mysqli_query($con, "SELECT * FROM teachers_tbl");
while ($row = mysqli_fetch_assoc($query)) {
	$resG = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM grades_tbl WHERE grade_id = '{$row['grade_id']}'"));
	$resS =mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM sections_tbl WHERE section_id = '{$row['section_id']}'"));
	$grade_id = $resG['grade_id'];
	$section_id = $resS['section_id'];

	$teacher_id = $row['teacher_id'];
	$fname = $row['fname'];
	$lname = $row['lname'];
	?>
	<tr>
		<td><?php echo $fname.' '.$lname; ?></td>
		<td><?php echo $resG['grade_name']. ' - '.$resS['section_name']; ?></td>
		<td>
			<a href="#" data-toggle="modal" data-target="#assign_modal<?php echo $teacher_id; ?>"><i class="fa fa-edit"></i></a>
			<div class="modal fade" id="assign_modal<?php echo $teacher_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Assign Module</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <form>
			          <div class="form-group">
			            <label for="recipient-name" class="col-form-label">Recipient:</label>
			            <input type="text" class="form-control" id="recipient-name">
			          </div>
			          <div class="form-group">
			            <label for="message-text" class="col-form-label">Message:</label>
			            <textarea class="form-control" id="message-text"></textarea>
			          </div>
			        </form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary">Send message</button>
			      </div>
			    </div>
			  </div>
			</div>
		</td>
	</tr>
	<?php
}
?>