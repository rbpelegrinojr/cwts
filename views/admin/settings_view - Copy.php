<?php include 'header.php'; ?>
<!-- <script type="text/javascript" src="assets/jquery-3.4.1.min"></script> -->

	<style type="text/css">
		.main_content .main_content_iners {
		    min-height: 68vh;
		    transition: .5s;
		    position: relative;
		    /*background: #f3f4f3;*/
		    margin: 0;
		    /*z-index: 22;*/
		    border-radius: 0;
		    padding: 30px;
		}

		.main_content .main_content_iners.overly_inners::before {
		    position: absolute;
		    left: 0;
		    top: 0;
		    right: 0;
		    height: 160px;
		    z-index: -1;
		    background: #4aa9ff;
		    content: '';
		    border-radius: 0;
		    left: 0;
		}
	</style>

<div class="main_content_iners overly_inners ">
    <div class="container-fluid p-0 ">

    <div class="row">
        <div class="col-12">
            <div class="page_title_box d-flex align-items-center justify-content-between">
                <div class="page_title_left">
                    <h3 class="f_s_30 f_w_700 text_white">Settings</h3>
                    <ol class="breadcrumb page_bradcam mb-0">
                    	<li class="breadcrumb-item"><a href="index">Dashboard </a></li>
	                    <li class="breadcrumb-item"><a href="javascript:void(0);">System Settings </a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
    	
		<div class="col-lg-12">
			<div class="white_card card_height_100 mb_30">
				<div class="white_card_header">
					<div class="box_header m-0">
						<!-- <div class="main-title">
							
						</div> -->
					</div>
				</div>
				<div class="white_card_body">
					<br>
					<div class="row">
						<div class="table-responsive col-md-6" style="display: none;">
							<div class="row">
								<div class="col-md-6">
									<label><b>Events</b></label>
								</div>
								<div class="col-md-6">
									<a href="#" class="btn btn-info btn-sm" style="float: right;" data-toggle="modal" data-target="#add_reservation_type">Add</a>
								</div>
							</div>
							<br>
							<table class="table table-bordered">
								<thead>
									<th>#</th>
									<th>Event Type</th>
									<th>Description</th>
								</thead>
								<tbody>
									<?php
									$query = mysqli_query($con, "SELECT * FROM reservation_type_tbl");
									$i = 1;
									while ($row = mysqli_fetch_assoc($query)) {
										?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['reservation_type']; ?></td>
											<td><a href="#" data-toggle="modal" data-target="#edit_reservation_modal<?php echo $row['reservation_type_id']; ?>"><span class="fa fa-edit"></span></a>
												<div class="modal fade" id="edit_reservation_modal<?php echo $row['reservation_type_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
												  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
												    <div class="modal-content">
												    <form action="../../controller/admin/process/save_data.php" method="POST">
												      <div class="modal-header">
												        <h5 class="modal-title" id="exampleModalLongTitle">Edit Reservation</h5>
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
												          <span aria-hidden="true">&times;</span>
												        </button>
												      </div>
												      <div class="modal-body">
												      	
													        <div class="row">
													        	<div class="col-md-12">
													        		<label>Reservation Type</label>
													        		<input type="hidden" name="reservation_type_id" value="<?php echo $row['reservation_type_id']; ?>">
													        		<input type="text" name="reservation_type" class="form-control" required="" value="<?php echo $row['reservation_type']; ?>">
													        	</div>
													        </div>
													    
													  </div>
												      <div class="modal-footer">
												        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												        <input type="submit" name="btnEditReservation" value="Save" class="btn btn-primary">
												      </div>
												      </form>
												    </div>
												  </div>
												</div>
											 | <a href="#" onclick="deleteResType(<?php echo $row['reservation_type_id']; ?>);"><span class="fa fa-trash"></span></a></td>
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
		</div>

		</div>

		<!-- New Section -->
		<div class="row">

    <!-- Colleges Table -->
    <div class="table-responsive col-md-4">
        <div class="row">
            <div class="col-md-6">
                <label><b>Colleges</b></label>
            </div>
            <div class="col-md-6">
                <a href="#" class="btn btn-info btn-sm" style="float: right;" data-toggle="modal" data-target="#add_college_modal">Add</a>
            </div>
        </div>
        <br>
        <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>College Name</th>
                <th>Abbreviation</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $college_query = mysqli_query($con, "SELECT * FROM colleges");
                $i = 1;
                while ($row = mysqli_fetch_assoc($college_query)) {
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['college_name']; ?></td>
                        <td><?php echo $row['college_abbreviation']; ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit_college_modal<?php echo $row['college_id']; ?>"><span class="fa fa-edit"></span></a>
                             | 
                            <a href="#" onclick="deleteCollege(<?php echo $row['college_id']; ?>);"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>

                    <!-- Edit College Modal -->
                    <div class="modal fade" id="edit_college_modal<?php echo $row['college_id']; ?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                          <form action="../../controller/admin/process/save_data.php" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit College</h5>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="college_id" value="<?php echo $row['college_id']; ?>">
                                <label>College Name</label>
                                <input type="text" name="college_name" class="form-control" value="<?php echo $row['college_name']; ?>" required>
                                <label>Abbreviation</label>
                                <input type="text" name="college_abbreviation" class="form-control" value="<?php echo $row['college_abbreviation']; ?>" required>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <input type="submit" name="btnEditCollege" value="Save" class="btn btn-primary">
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Courses Table -->
    <div class="table-responsive col-md-4">
        <div class="row">
            <div class="col-md-6">
                <label><b>Courses</b></label>
            </div>
            <div class="col-md-6">
                <a href="#" class="btn btn-info btn-sm" style="float: right;" data-toggle="modal" data-target="#add_course_modal">Add</a>
            </div>
        </div>
        <br>
        <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>Course Name</th>
                <th>Abbreviation</th>
                <th>College</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $course_query = mysqli_query($con, "SELECT c.*, col.college_name 
                                                    FROM courses c 
                                                    JOIN colleges col ON c.college_id = col.college_id");
                $i = 1;
                while ($row = mysqli_fetch_assoc($course_query)) {
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['course_name']; ?></td>
                        <td><?php echo $row['course_abbreviation']; ?></td>
                        <td><?php echo $row['college_name']; ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit_course_modal<?php echo $row['course_id']; ?>"><span class="fa fa-edit"></span></a>
                             | 
                            <a href="#" onclick="deleteCourse(<?php echo $row['course_id']; ?>);"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>

                    <!-- Edit Course Modal -->
                    <div class="modal fade" id="edit_course_modal<?php echo $row['course_id']; ?>" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                          <form action="../../controller/admin/process/save_data.php" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Course</h5>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="course_id" value="<?php echo $row['course_id']; ?>">
                                <label>Course Name</label>
                                <input type="text" name="course_name" class="form-control" value="<?php echo $row['course_name']; ?>" required>
                                <label>Abbreviation</label>
                                <input type="text" name="course_abbreviation" class="form-control" value="<?php echo $row['course_abbreviation']; ?>" required>
                                <label>College</label>
                                <select name="college_id" class="form-control" required>
                                    <?php
                                    $col_query = mysqli_query($con, "SELECT * FROM colleges");
                                    while ($col = mysqli_fetch_assoc($col_query)) {
                                        $selected = ($col['college_id'] == $row['college_id']) ? 'selected' : '';
                                        echo "<option value='{$col['college_id']}' {$selected}>{$col['college_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <input type="submit" name="btnEditCourse" value="Save" class="btn btn-primary">
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <div class="table-responsive col-md-4">
							<div class="row">
								<div class="col-md-6">
									<label><b>System Settings</b></label>
								</div>
								<!-- <div class="col-md-6">
									<a href="#" class="btn btn-info btn-sm" style="float: right;" data-toggle="modal" data-target="#add_role_modal">Add</a>
								</div> -->
							</div>
							<br>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Type</th>
										<th>Value</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>System Title</th>
										<td><?php echo $resSettings['system_title']; ?></td>
										<td>
											<a href="#" data-toggle="modal" data-target="#setting_title<?php echo $resSettings['setting_id']; ?>"><span class="fa fa-edit"></span></a>
											<div class="modal fade" id="setting_title<?php echo $resSettings['setting_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
											    <div class="modal-content">
											    <form action="../../controller/admin/process/save_data.php" method="POST">
											      <div class="modal-header">
											        <h5 class="modal-title" id="exampleModalLongTitle">Update System Title</h5>
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span>
											        </button>
											      </div>
											      <div class="modal-body">
											      	
												        <div class="row">
												        	<div class="col-md-12">
												        		<label>System Title</label>
												        		<input type="text" name="system_title" class="form-control" required="" value="<?php echo $resSettings['system_title']; ?>">
												        	</div>
												        </div>
												    
												  </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											        <input type="submit" name="btnUpdateSysTitle" value="Save" class="btn btn-primary">
											      </div>
											      </form>
											    </div>
											  </div>
											</div>
										</td>
									</tr>
									<tr>
										<th>System Logo</th>
										<td class="text-center"><img src="<?php echo $resSettings['system_logo']; ?>" style="height: 50px; width: 50px;"></td>
										<td>
											<a href="#" data-toggle="modal" data-target="#setting_logo<?php echo $resSettings['setting_id']; ?>"><span class="fa fa-edit"></span></a>
											<div class="modal fade" id="setting_logo<?php echo $resSettings['setting_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
											    <div class="modal-content">
											    <form action="../../controller/admin/process/save_data.php" method="POST" enctype="multipart/form-data">
											      <div class="modal-header">
											        <h5 class="modal-title" id="exampleModalLongTitle">Update System Logo</h5>
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span>
											        </button>
											      </div>
											      <div class="modal-body">
											      	
												        <div class="row">
												        	<div class="col-md-12">
												        		<label>System Logo</label>
												        		<input type="file" name="system_logo" class="form-control" required="">
												        	</div>
												        </div>
												    
												  </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											        <input type="submit" name="btnUpdateLogo" value="Save" class="btn btn-primary">
											      </div>
											      </form>
											    </div>
											  </div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>


</div>

<!-- Add College Modal -->
<div class="modal fade" id="add_college_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <form action="../../controller/admin/process/save_data.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">New College</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <label>College Name</label>
          <input type="text" name="college_name" class="form-control" required>
          <label>Abbreviation</label>
          <input type="text" name="college_abbreviation" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" name="btnAddCollege" value="Save" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="add_course_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <form action="../../controller/admin/process/save_data.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">New Course</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <label>Course Name</label>
          <input type="text" name="course_name" class="form-control" required>
          <label>Abbreviation</label>
          <input type="text" name="course_abbreviation" class="form-control" required>
          <label>College</label>
          <select name="college_id" class="form-control" required>
            <option value="">Select College</option>
            <?php
            $col_query = mysqli_query($con, "SELECT * FROM colleges");
            while ($col = mysqli_fetch_assoc($col_query)) {
                echo "<option value='{$col['college_id']}'>{$col['college_name']}</option>";
            }
            ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" name="btnAddCourse" value="Save" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function deleteCollege(c_id) {
    if (confirm('Delete College?')) {
        window.location.href='../../controller/admin/process/delete_data.php?c_id='+c_id+'&btnDelCollege=1';
    }
}
function deleteCourse(c_id) {
    if (confirm('Delete Course?')) {
        window.location.href='../../controller/admin/process/delete_data.php?c_id='+c_id+'&btnDelCourse=1';
    }
}
</script>

		

	</div>
</div>

<div class="modal fade" id="add_reservation_type" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
    <form action="../../controller/admin/process/save_data.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Reservation Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	
	        <div class="row">
	        	<div class="col-md-12">
	        		<label>Reservation Type</label>
	        		<input type="text" name="reservation_type" class="form-control" required="" placeholder="Type Here...">
	        	</div>
	        </div>
	    
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="btnAddReservation" value="Save" class="btn btn-primary">
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="add_role_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
    <form action="<?php echo $action_url; ?>save_data.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	
	        <div class="row">
	        	<div class="col-md-12">
	        		<label>Role Name</label>
	        		<input type="text" name="role_name" class="form-control" required="">
	        	</div>
	        </div>
	    
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="btnAddRole" value="Save" class="btn btn-primary">
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="add_school_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
    <form action="<?php echo $action_url; ?>save_data.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New School</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	
        <div class="row">
        	<div class="col-md-12">
        		<label>School Name</label>
        		<input type="text" name="school_name" class="form-control" required="">
        	</div>
        	<div class="col-md-12">
        		<label>School Abbreviation</label>
        		<input type="text" name="school_abbreviation" class="form-control" required="">
        	</div>
        </div>
	    
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="btnAddSchool" value="Save" class="btn btn-primary">
      </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
	function deleteResType(r_id) {
		if (confirm('Delete Record?')) {
			window.location.href='../../controller/admin/process/delete_data.php?r_id='+r_id+'&btnDelResType=1';
		}
	}

	function deleteRole(r_id) {
		if (confirm('Delete Record?')) {
			window.location.href='../../controller/admin/process/delete_data.php?r_id='+r_id+'&btnDelRole=1';
		}
	}

	function deleteSchool(s_id) {
		if (confirm('Delete Record?')) {
			window.location.href='../../controller/admin/process/delete_data.php?s_id='+s_id+'&btnDelSchool=1';
		}
	}
</script>
<?php include 'footer.php'; ?>