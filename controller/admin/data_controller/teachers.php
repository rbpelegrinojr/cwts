<?php
$query = mysqli_query($con, "SELECT * FROM teachers_tbl WHERE pending_status != '1'");

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
	$teacher_id = $row['teacher_id'];
    $fname = $row['fname'];
    $mname = $row['mname'];
    $lname = $row['lname'];
    $grade_id = $row['grade_id'];
    $address = $row['address'];
    $contact_number = $row['contact_number'];
    $resG = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM grades_tbl WHERE grade_id = '$grade_id' "));
    $resS = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM sections_tbl WHERE section_id = '{$row['section_id']}' "));
?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php echo $fname; ?></td>
		<td><?php echo $mname; ?></td>
		<td><?php echo $lname; ?></td>
		<td><?php echo $resG['grade_name']. ' - '.$resS['section_name']; ?></td>
		<td><?php echo $address; ?></td>
		<td><?php echo $contact_number; ?></td>
		<input type="hidden" id="teacher_id<?php echo $teacher_id; ?>" value="<?php echo $teacher_id; ?>">
		<td>
			<!-- <a href="#" onclick="window.location.href='adminPage_view.php?activity=edit_teacher_view&t_id=<?php echo $teacher_id; ?>'"><i class="ti-pencil-alt"></i></a> -->
			<a href="#" data-toggle="modal" data-target="#edit_teacher<?php echo $teacher_id; ?>"><i class="ti-pencil-alt"></i></a>
			<div class="modal fade" id="edit_teacher<?php echo $teacher_id; ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    	<div class="card-block col-sm-12" id="mess_alert<?php echo $teacher_id; ?>" style="display: none; position: absolute; z-index:-1; z-index:100; align-items: center;">
					        <center><h5 id="mess_text<?php echo $teacher_id; ?>"></h5></center>
					    </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            
                            <?php
								$resTeach = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM teachers_tbl WHERE teacher_id = '$teacher_id'"));
								$resSect = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM sections_tbl WHERE section_id = '{$resTeach['section_id']}'"));
								$resGrade = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM grades_tbl WHERE grade_id = '{$resTeach['grade_id']}'"));
								$teacher_id = $resTeach['teacher_id'];

								$fname = $resTeach['fname'];
								$mname = $resTeach['mname'];
								$lname = $resTeach['lname'];
								$address = $resTeach['address'];
								$contact_number = $resTeach['contact_number'];
								$grade_id = $resTeach['grade_id'];
								$section_id = $resTeach['section_id'];
								$username = $resTeach['username'];
								$password = $resTeach['password'];
								?>
								<div class="card">
								    
								    <div class="card-block">
								    	<h4 class="sub-title">Edit Teacher <?php echo $fname.' '.$lname; ?></h4>
								        <div>
								            <div class="form-group row">
								                <div class="col">
								                    <input type="hidden" id="teacher_id<?php echo $teacher_id; ?>" value="<?php echo $teacher_id; ?>">
								                    <label for="entry_id">First Name</label>
								                    <input type="text" id="fname<?php echo $teacher_id; ?>" class="form-control" required="" value="<?php echo $fname; ?>">
								                </div>
								                <div class="col-sm-4">
								                    <label for="entry_type">Middle Name</label>
								                    <input type="text" id="mname<?php echo $teacher_id; ?>" class="form-control" required="" value="<?php echo $mname; ?>">
								                </div>
								                <div class="col">
								                    <label for="validationCustomUsername">Last Name</label>
								                    <input type="text" id="lname<?php echo $teacher_id; ?>" class="form-control" required="" value="<?php echo $lname; ?>">
								                </div>
								            </div>

								            <div class="form-group row">
								                <div class="col">
								                    <label for="entry_type">Address</label>
								                    <input type="text" id="address<?php echo $teacher_id; ?>" required="" class="form-control" value="<?php echo $address; ?>">
								                </div>
								                <div class="col-sm-4">
								                    <label for="entry_type">Contact Number</label>
								                    <input type="text" id="contact_number<?php echo $teacher_id; ?>" required="" class="form-control" value="<?php echo $contact_number; ?>">
								                </div>
								                <div class="col">
								                    <label for="entry_type">Grade</label>
								                    <select class="form-control" id="grade_id<?php echo $teacher_id; ?>" style="height: 35px;" required="">
								                        <option value="<?php echo $grade_id; ?>"><?php echo $resGrade['grade_name']; ?></option>
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
								            </div>

								            <div class="form-group row">
								                <div class="col">
								                    <label for="entry_type">Section</label>
								                    <select class="form-control" id="section_id<?php echo $teacher_id; ?>" style="height: 35px;" required="">
								                        <option value="<?php echo $section_id; ?>"><?php echo $resSect['section_name']; ?></option>
								                    </select>
								                </div>
								                <div class="col-sm-4">
								                    <label for="entry_id">Teacher Username</label>
								                    <input type="text" class="form-control" id="username<?php echo $teacher_id; ?>" required="" value="<?php echo $username; ?>">
								                </div>
								                <div class="col">
								                    <label for="entry_id">Teacher Password</label>
								                    <input type="text" class="form-control" id="password<?php echo $teacher_id; ?>" required="" value="<?php echo $password; ?>">
								                </div>
								            </div>
								            <!-- <button class="btn waves-effect waves-light btn-grd-primary" id="btnEditTeacher" style="float: right;">Save Data</button> -->
								        </div>
								    </div>
								</div>
								<script type="text/javascript">
								    $(document).ready(function () {
								        
								        $('#grade_id<?php echo $teacher_id; ?>').change(function () {
								            var grade_id = $('#grade_id<?php echo $teacher_id; ?>').val();

								            if (grade_id != '') {
								                 $.ajax({
								                    url:'../../controller/admin/data_controller/filter_section.php',
								                    method:'POST',
								                    data:{
								                        grade_id:grade_id
								                    },
								                    success:function (filter_section) {
								                        $('#section_id<?php echo $teacher_id; ?>').html(filter_section);
								                    }
								                });
								             }
								           
								        });

								        $('#btnEditTeacher<?php echo $teacher_id; ?>').click(function () {
								            var fname = $('#fname<?php echo $teacher_id; ?>').val();
								            var mname = $('#mname<?php echo $teacher_id; ?>').val();
								            var lname = $('#lname<?php echo $teacher_id; ?>').val();
								            var address = $('#address<?php echo $teacher_id; ?>').val();
								            var contact_number = $('#contact_number<?php echo $teacher_id; ?>').val();
								            var grade_id = $('#grade_id<?php echo $teacher_id; ?>').val();
								            var username = $('#username<?php echo $teacher_id; ?>').val();
								            var password = $('#password<?php echo $teacher_id; ?>').val();
								            var section_id = $('#section_id<?php echo $teacher_id; ?>').val();
								            var teacher_id =$('#teacher_id<?php echo $teacher_id; ?>').val();

								            if (fname != '' || mname != '' || lname != '' || address != '' || contact_number != '' || grade_id != '' || username != '' || password != '' || section_id != '') {

								                $.ajax({
								                    url: '../../controller/admin/process/update_process.php',
								                    method: 'POST',
								                    data:{
								                        btnEditTeacher:1,
								                        fname:fname,
								                        mname:mname,
								                        lname:lname,
								                        address:address,
								                        contact_number:contact_number,
								                        grade_id:grade_id,
								                        section_id:section_id,
								                        username:username,
								                        password:password,
								                        teacher_id:teacher_id
								                    },
								                    success:function (dataInfo) {
								                        if (dataInfo == 'edited') {
								                            $('#mess_alert<?php echo $teacher_id; ?>').css("border", "1px solid green");
								                            $('#mess_text<?php echo $teacher_id; ?>').css("color", "green");
								                            $('#mess_text<?php echo $teacher_id; ?>').text('Teacher Edited Successfully.');
								                            $('#mess_alert<?php echo $teacher_id; ?>').fadeIn('fast').delay(1000).fadeOut('fast', function () {
								                                window.location.href='adminPage_view.php?activity=teachers_view';
								                            });
								                        }else if (dataInfo == 'Error') {
								                            alert('Something Went Wrong');
								                        }else if (dataInfo == 'uname Ex') {
								                            $('#mess_alert<?php echo $teacher_id; ?>').css("border", "1px solid red");
								                            $('#mess_text<?php echo $teacher_id; ?>').css("color", "red");
								                            $('#mess_text<?php echo $teacher_id; ?>').text('Username Already Exists');
								                            $('#mess_alert<?php echo $teacher_id; ?>').fadeIn('fast').delay(1000).fadeOut('fast');
								                        }else if (dataInfo == 'num Ex') {
								                            $('#mess_alert<?php echo $teacher_id; ?>').css("border", "1px solid red");
								                            $('#mess_text<?php echo $teacher_id; ?>').css("color", "red");
								                            $('#mess_text<?php echo $teacher_id; ?>').text('Contact Number Already Exists');
								                            $('#mess_alert<?php echo $teacher_id; ?>').fadeIn('fast').delay(1000).fadeOut('fast');
								                        }
								                    }
								                });

								            }else{
								                $('#mess_alert<?php echo $teacher_id; ?>').css("border", "1px solid red");
								                $('#mess_text<?php echo $teacher_id; ?>').css("color", "red");
								                $('#mess_text<?php echo $teacher_id; ?>').text('Please Fillin Fields.');
								                $('#mess_alert<?php echo $teacher_id; ?>').fadeIn('fast').delay(1000).fadeOut('fast');
								            }

								        });
								    });
								</script>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn waves-effect waves-light btn-grd-primary" id="btnEditTeacher<?php echo $teacher_id; ?>" style="float: right;">Save Data</button>
                        </div>
                    </div>
                </div>
            </div>

			&nbsp;&nbsp;&nbsp;<a href="#" id="btnDelTeach<?php echo $teacher_id; ?>"><i class="ti-trash"></i></a>
			<script type="text/javascript">
				$(document).ready(function () {

					$('#btnDelTeach<?php echo $teacher_id; ?>').click(function() {
						if (confirm('Are you sure you want to delete Teacher <?php echo $fname;echo " "; echo $lname; ?>')) {
							var teacher_id = $('#teacher_id<?php echo $teacher_id; ?>').val();
							$.ajax({
								url: '../../controller/admin/process/delete_user.php',
                    			method: 'POST',
								data:{
									btnDelTeach:1,
									teacher_id:teacher_id
								},
								success:function (dataInfo) {
									if (dataInfo == 'Success') {
										$('#mess_alert').css("border", "1px solid green");
			                            $('#mess_text').css("color", "green");
			                            $('#mess_text').text('Teacher Deleted Successfully.');
			                            $('#mess_alert').fadeIn('fast').delay(1000).fadeOut('fast', function () {
			                                window.location.href='adminPage_view.php?activity=teachers_view';
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

<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
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
</div> -->