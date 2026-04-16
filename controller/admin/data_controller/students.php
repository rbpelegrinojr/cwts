<?php
$query = mysqli_query($con, "SELECT * FROM students_tbl");

if ($rows = mysqli_num_rows($query) > 0) {
	
}else{
	?>
	<div class="card borderless-card">
        <div class="card-block warning-breadcrumb">
            <center><h5>No Data Available</h5></center>
        </div>
    </div>
	<?php
}
$i = 1;
while ($row = mysqli_fetch_assoc($query)) {
	$student_id = $row['student_id'];
    $fname = $row['fname'];
    $mname = $row['mname'];
    $lname = $row['lname'];
    $sex = $row['sex'];
    $age = $row['age'];
    $address = $row['address'];
    $guardian_name = $row['guardian_name'];
    $contact_number = $row['contact_number'];
    $resG = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM grades_tbl WHERE grade_id = '{$row['grade_id']}' "));
    $resS = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM sections_tbl WHERE section_id = '{$row['section_id']}' "));
?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><a href=""><?php echo $fname.' '.$mname.' '.$lname; ?></a></td>
		<td><?php echo $sex; ?></td>
		<td><?php echo $age; ?></td>
		<td><?php echo $address; ?></td>
		<td><?php echo $resG['grade_name']. ' - '.$resS['section_name']; ?></td>
		<td><?php echo $guardian_name; ?></td>
		<td><?php echo $contact_number; ?></td>
		<input type="hidden" id="student_id<?php echo $student_id; ?>" value="<?php echo $student_id; ?>">
		<td>
			<!-- <a href="#" onclick="window.location.href='adminPage_view.php?activity=edit_student_view&s_id=<?php echo $student_id; ?>'"><i class="ti-pencil-alt"></i></a> -->
			<a href="#" data-toggle="modal" data-target="#edit_student<?php echo $student_id; ?>"><i class="ti-pencil-alt"></i></a>

			<div class="modal fade" id="edit_student<?php echo $student_id; ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <?php
							$resStud = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM students_tbl WHERE student_id = '$student_id'"));
							$resSec = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM sections_tbl WHERE section_id = '{$resStud['section_id']}'"));
							$resGrade = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM grades_tbl WHERE grade_id = '{$resStud['grade_id']}'"));
							$fname = $resStud['fname'];
							$mname = $resStud['mname'];
							$lname = $resStud['lname'];
							$sex = $resStud['sex'];
							$age = $resStud['age'];
							$address = $resStud['address'];
							$guardian_name = $resStud['guardian_name'];
							$contact_number = $resStud['contact_number'];
							$grade_id = $resStud['grade_id'];
							$section_id = $resStud['section_id'];
							$student_id_number = $resStud['student_id_number'];
							$username = $resStud['username'];
							$password = $resStud['password'];
							?>
							<div class="card">
							    <div class="card-block col-sm-12" id="mess_alert<?php echo $student_id; ?>" style="display: none; position: absolute; z-index:-1; z-index:100; align-items: center;">
							        <center><h5 id="mess_text<?php echo $student_id; ?>"></h5></center>
							    </div>
							    <div class="card-header">
							        
							    </div>
							    
							    <div class="card-block">
							        <h4 class="sub-title">Edit <?php echo $fname.' '.$lname; ?> Information</h4>
							        <div>
							            <input type="hidden" id="student_id<?php echo $student_id; ?>" value="<?php echo $resStud['student_id']; ?>">
							            <div class="form-group row">
							                <div class="col">
							                    <label for="entry_id">First Name</label>
							                    <input type="text" id="fname<?php echo $student_id; ?>" class="form-control" required="" value="<?php echo $fname; ?>">
							                </div>
							                <div class="col-sm-4">
							                    <label for="entry_type">Middle Name</label>
							                    <input type="text" id="mname<?php echo $student_id; ?>" class="form-control" required="" value="<?php echo $mname; ?>">
							                </div>
							                <div class="col">
							                    <label for="validationCustomUsername">Last Name</label>
							                    <input type="text" id="lname<?php echo $student_id; ?>" class="form-control" required="" value="<?php echo $lname; ?>">
							                </div>
							            </div>

							            <div class="form-group row">
							                <div class="col">
							                    <label for="entry_id">Sex</label>
							                    <select class="form-control" style="height: 35px;" id="sex<?php echo $student_id; ?>" value="<?php echo $sex; ?>">
							                        <option value="<?php echo $sex; ?>"><?php echo $sex; ?></option>
							                        <option value="Male">Male</option>
							                        <option value="Female">Female</option>
							                    </select>
							                </div>
							                <div class="col">
							                    <label for="entry_id">Age</label>
							                    <input type="text" class="form-control" id="age<?php echo $student_id; ?>" value="<?php echo $age; ?>">
							                </div>
							                <div class="col">
							                    <label for="entry_type">Address</label>
							                    <input type="text" id="address<?php echo $student_id; ?>" required="" class="form-control" value="<?php echo $address; ?>">
							                </div>
							                <div class="col">
							                    <label for="entry_type">Guardian Name</label>
							                    <input type="text" id="guardian_name<?php echo $student_id; ?>" required="" class="form-control" value="<?php echo $guardian_name; ?>">
							                </div>
							            </div>

							            <div class="form-group row">
							                <div class="col">
							                    <label for="entry_type">Contact Number</label>
							                    <input type="text" id="contact_number<?php echo $student_id; ?>" required="" class="form-control" value="<?php echo $contact_number; ?>">
							                </div>
							                <div class="col-sm-4">
							                    <label for="entry_type">Grade</label>
							                    <select class="form-control" id="grade_id<?php echo $student_id; ?>" style="height: 35px;" required="">
							                        <option value="<?php echo $resGrade['grade_id']; ?>"><?php echo $resGrade['grade_name']; ?></option>
							                        <?php
							                        $qG = mysqli_query($con, "SELECT * FROM grades_tbl");
							                        while ($rG = mysqli_fetch_assoc($qG)) {
							                            ?>
							                            <option value="<?php echo $rG['grade_id']; ?>"><?php echo $rG['grade_name']; ?></option>
							                            <?php
							                        }
							                        ?>
							                    </select>
							                </div>
							                <div class="col">
							                    <label for="entry_type">Section</label>
							                    <select class="form-control" id="section_id<?php echo $student_id; ?>" style="height: 35px;" required="">
							                        <option value="<?php echo $section_id; ?>"><?php echo $resSec['section_name']; ?></option>
							                    </select>
							                </div>
							            </div>
							            <div class="form-group row">
							                <div class="col">
							                    <label for="entry_type">Student ID</label>
							                    <input type="text" id="student_id_number<?php echo $student_id; ?>" required="" class="form-control" value="<?php echo $student_id_number; ?>">
							                </div>
							                <div class="col-sm-4">
							                    <label for="entry_type">Username</label>
							                    <input type="text" id="username<?php echo $student_id; ?>" class="form-control" value="<?php echo $username; ?>">
							                </div>
							                <div class="col">
							                    <label for="entry_type">Password</label>
							                    <input type="text" id="password<?php echo $student_id; ?>" class="form-control" value="<?php echo $password; ?>">
							                </div>
							            </div>
							        </div>
							    </div>
							</div>
							<script type="text/javascript">
							    $(document).ready(function () {

							        $('#grade_id<?php echo $student_id; ?>').change(function () {
							            var grade_id = $('#grade_id<?php echo $student_id; ?>').val();

							            if (grade_id != '') {
							                 $.ajax({
							                    url:'../../controller/admin/data_controller/filter_section.php',
							                    method:'POST',
							                    data:{
							                        grade_id:grade_id
							                    },
							                    success:function (filter_section) {
							                        $('#section_id<?php echo $student_id; ?>').html(filter_section);
							                    }
							                });
							             }else{
							                alert('Please select Grade');
							                $('#section_id<?php echo $student_id; ?>').html('<option value="">-Select Grade First-</option>');
							             }
							           
							        });
							        
							        $('#btnEditStudent<?php echo $student_id; ?>').click(function () {
							            var fname = $('#fname<?php echo $student_id; ?>').val();
							            var mname = $('#mname<?php echo $student_id; ?>').val();
							            var lname = $('#lname<?php echo $student_id; ?>').val();
							            var age = $('#age<?php echo $student_id; ?>').val();
							            var address = $('#address<?php echo $student_id; ?>').val();
							            var guardian_name = $('#guardian_name<?php echo $student_id; ?>').val();
							            var contact_number = $('#contact_number<?php echo $student_id; ?>').val();
							            var grade_id = $('#grade_id<?php echo $student_id; ?>').val();
							            var student_id = $('#student_id<?php echo $student_id; ?>').val();
							            var username = $('#username<?php echo $student_id; ?>').val();
							            var password = $('#password<?php echo $student_id; ?>').val();
							            var section_id = $('#section_id<?php echo $student_id; ?>').val();
							            var sex = $('#sex<?php echo $student_id; ?>').val();
							            var student_id_number = $('#student_id_number<?php echo $student_id; ?>').val();

							            if (fname != '' || mname != '' || lname != '' || age != '' || address != '' || guardian_name != '' || contact_number != '' || student_id != '' || username != '' || password != '') {

							                $.ajax({
							                    url: '../../controller/admin/process/update_process.php',
							                    method: 'POST',
							                    data:{
							                        btnEditStudent:1,
							                        fname:fname,
							                        mname:mname,
							                        lname:lname,
							                        address:address,
							                        contact_number:contact_number,
							                        grade_id:grade_id,
							                        section_id:section_id,
							                        username:username,
							                        password:password,
							                        age:age,
							                        guardian_name:guardian_name,
							                        student_id:student_id,
							                        sex:sex,
							                        student_id_number:student_id_number

							                    },
							                    success:function (dataInfo) {
							                        if (dataInfo == 'edited') {
							                            $('#mess_alert<?php echo $student_id; ?>').css("border", "1px solid green");
							                            $('#mess_text<?php echo $student_id; ?>').css("color", "green");
							                            $('#mess_text<?php echo $student_id; ?>').text('Student Edited Successfully.');
							                            $('#mess_alert<?php echo $student_id; ?>').fadeIn('fast').delay(1000).fadeOut('fast', function () {
							                                window.location.href='adminPage_view.php?activity=students_view';
							                            });
							                        }else if (dataInfo == 'Error') {
							                            alert('Something Went Wrong');
							                        }else if (dataInfo == 'stud ex') {
							                            $('#mess_alert<?php echo $student_id; ?>').css("border", "1px solid red");
							                            $('#mess_text<?php echo $student_id; ?>').css("color", "red");
							                            $('#mess_text<?php echo $student_id; ?>').text('Student ID Already Exists');
							                            $('#mess_alert<?php echo $student_id; ?>').fadeIn('fast').delay(1000).fadeOut('fast');
							                        }else if (dataInfo == 'uname ex') {
							                            $('#mess_alert<?php echo $student_id; ?>').css("border", "1px solid red");
							                            $('#mess_text<?php echo $student_id; ?>').css("color", "red");
							                            $('#mess_text<?php echo $student_id; ?>').text('Uername Already Exists');
							                            $('#mess_alert<?php echo $student_id; ?>').fadeIn('fast').delay(1000).fadeOut('fast');
							                        }else if (dataInfo == 'num ex') {
							                            $('#mess_alert<?php echo $student_id; ?>').css("border", "1px solid red");
							                            $('#mess_text<?php echo $student_id; ?>').css("color", "red");
							                            $('#mess_text<?php echo $student_id; ?>').text('Contact Number Already Exists');
							                            $('#mess_alert<?php echo $student_id; ?>').fadeIn('fast').delay(1000).fadeOut('fast');
							                        }
							                    }
							                });

							            }else{
							                $('#mess_alert<?php echo $student_id; ?>').css("border", "1px solid red");
							                $('#mess_text<?php echo $student_id; ?>').css("color", "red");
							                $('#mess_text<?php echo $student_id; ?>').text('Please Fillin Fields.');
							                $('#mess_alert<?php echo $student_id; ?>').fadeIn('fast').delay(1000).fadeOut('fast');
							            }

							        });
							    });
							</script>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn waves-effect waves-light btn-grd-primary" id="btnEditStudent<?php echo $student_id; ?>" style="float: right;">Save Data</button>
                        </div>
                    </div>
                </div>
            </div>

			&nbsp;&nbsp;&nbsp;<a href="#" id="btnDelStud<?php echo $student_id; ?>"><i class="ti-trash"></i></a>
			<script type="text/javascript">
				$(document).ready(function () {

					$('#btnDelStud<?php echo $student_id; ?>').click(function() {
						if (confirm('Are you sure you want to delete Student <?php echo $fname;echo " "; echo $lname; ?>')) {
							var student_id = $('#student_id<?php echo $student_id; ?>').val();
							$.ajax({
								url: '../../controller/admin/process/delete_process.php',
                    			method: 'POST',
								data:{
									btnDelStud:1,
									student_id:student_id
								},
								success:function (dataInfo) {
									if (dataInfo == 'Success') {
										$('#mess_alert').css("border", "1px solid green");
			                            $('#mess_text').css("color", "green");
			                            $('#mess_text').text('Student Deleted Successfully.');
			                            $('#mess_alert').fadeIn('fast').delay(1000).fadeOut('fast', function () {
			                                window.location.href='adminPage_view.php?activity=students_view';
			                            });
									}
								}
							});
						}

					});

				});
			</script>
		</td>
	</tr>
	<?php
}
?>