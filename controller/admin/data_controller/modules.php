<?php
$query = mysqli_query($con, "SELECT * FROM modules_tbl GROUP BY grade_id, module_week ORDER BY date_uploaded DESC ");
while ($row = mysqli_fetch_assoc($query)) {
	$rG = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM grades_tbl WHERE grade_id = '{$row['grade_id']}'"));
	$resWeek = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM weeks_tbl WHERE week_id = '{$row['module_week']}'"));
	$module_id = $row['module_id'];
	$module_week = $row['module_week'];
	$grade_name = $rG['grade_name'];
	$grade_id = $row['grade_id'];
	$module_subject = $row['module_subject'];
	$date_uploaded = $row['date_uploaded'];
	?>
	<tr>
		<td><?php echo $resWeek['week_name']; ?></td>
		<td><?php echo $grade_name; ?></td>
		<td>
			<a href="#" data-toggle="modal" data-target="#subject_modal<?php echo $module_id; ?>"><!-- <i class="fa fa-eye"></i> -->View</a>
			<!-- Modal Subjects -->
			<div class="modal fade" id="subject_modal<?php echo $module_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<?php //$resMod = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM modules_tbl WHERE module_id = '$module_id' ")); ?>
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Subject Module <?php echo $grade_name; ?></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">

			        <div class="card">
					    <div class="card-block col-sm-12" id="mess_alert" style="display: none; position: absolute; z-index:-1; z-index:100; align-items: center;">
					        <center><h5 id="mess_text"></h5></center>
					    </div>
					    <div class="card-block table-border-style">
					        <div class="table-responsive">
					            <table class="table table-hover">
					                <thead>
					                    <tr>
					                        <th scope="col">Week #</th>
					                        <th></th>
					                        <th></th>
					                        <th></th>
					                        <th></th>
					                        <th scope="col">Subject Name</th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <?php
					                    $qMods = mysqli_query($con, "SELECT * FROM modules_tbl WHERE module_week = '$module_week' GROUP BY module_subject ");
					                    while ($rMods = mysqli_fetch_assoc($qMods)) {
					                    	$resSub = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM subjects_tbl WHERE subject_id = '{$rMods['module_subject']}' "));
					                    	?>
					                    	<tr>
					                    		<td><?php echo $resWeek['week_name']; ?></td>
					                    		<td></td>
						                        <td></td>
						                        <td></td>
						                        <td></td>
					                    		<td><?php echo $resSub['subject_name']; ?></td>
					                    	</tr>
					                    	<?php
					                    }

					                    ?>
					                </tbody>
					            </table>
					        </div>
					    </div>
					</div>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- End Modal Subjects -->
		</td>
		<td>
			<?php
			$resExMod = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM teacher_modules_tbl WHERE module_id = '$module_id' "));
			if (empty($resExMod['module_id'])) {
				?>
				<a href="" data-toggle="modal" data-target="#assign_modal<?php echo $module_id; ?>"><i class="fa fa-sign-in"></i></a>
				<?php
			}else{
				echo "Assigned";
			}
			?>
			<!-- Start Modal Assign -->
			<div class="modal fade" id="assign_modal<?php echo $module_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<?php //$resMod = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM modules_tbl WHERE module_id = '$module_id' ")); ?>
			  <div class="modal-dialog" role="document">
			    <form class="modal-content" action="../../controller/admin/process/assign_module.php" method="">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Module will assigned to <?php echo $grade_name; ?> Teachers</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">

			        <div class="card">
					    <div class="card-block col-sm-12" id="mess_alert" style="display: none; position: absolute; z-index:-1; z-index:100; align-items: center;">
					        <center><h5 id="mess_text"></h5></center>
					    </div>
					    <div class="card-block table-border-style">
					        <div class="table-responsive">

					            <table class="table table-hover">
					                <thead>
					                    <tr>
					                        <th scope="col">Week #</th>
					                        <th></th>
					                        <th></th>
					                        <th></th>
					                        <th></th>
					                        <th scope="col">Subjects</th>
					                    </tr>
					                </thead>
					                <tbody>
			                    <?php
			                    $qMods = mysqli_query($con, "SELECT * FROM modules_tbl WHERE module_week = '$module_week' AND grade_id = '$grade_id' GROUP BY module_subject ");
			                    while ($rMods = mysqli_fetch_assoc($qMods)) {
			                    	$rWeek = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM weeks_tbl WHERE week_id = '{$rMods['module_week']}' "));
			                    	$resSub = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM subjects_tbl WHERE subject_id = '{$rMods['module_subject']}' "));
			                    	$mod_id = $rMods['module_id'];
			                    	$g_id = $rMods['grade_id'];
			                    	$sub_id = $rMods['module_subject'];
			                    	?>
			                    	<tr>
			                    		<td><?php echo $rWeek['week_name']; ?></td>
			                    		<td></td>
			                    		<td></td>
			                    		<td></td>
			                    		<td></td>
			                    		<td><?php echo $resSub['subject_name']; ?></td>
			                    	</tr>
			                    	<input type="hidden" name="module_id[]" value="<?php echo $mod_id; ?>">
			                    	<input type="hidden" name="grade_id" value="<?php echo $g_id; ?>">
			                    	<input type="hidden" name="week_id" value="<?php echo $rWeek['week_id']; ?>">
			                    	<input type="hidden" name="subject_id[]" value="<?php echo $sub_id; ?>"><br>
			                    	<?php
			                    }

			                    ?>
			                </tbody>
			            </table>

					    </div>
					    <hr>
					    <label>Deadline</label>
					<input type="date" name="date_deadline" required="" min="<?php echo date('Y-m-d'); ?>" class="form-control col-sm-5">
					</div>
					
				</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <input type="submit" name="btnAssign" class="btn btn-primary" value="Assign">
			      </div>
			    </form>
			  </div>
			</div>
			<!-- End Modal Assign -->
		</td>
		<!-- <td><a href=""><i class="ti-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;<a href=""><i class="ti-trash"></i></a></td> -->
	</tr>
	<?php
}
?>

