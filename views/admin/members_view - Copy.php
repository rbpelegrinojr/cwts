<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="../../include/DataTables/datatables.min.css">
<script type="text/javascript" src="../../include/DataTables/datatables.min.js"></script>
<!-- <div class="main_content_iner ">
<div class="container-fluid p-0 ">
<div class="row "> -->
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

		.footer_part{
			background: #4aa9ff;
		}
		.footer_part .footer_iner.text-center{
			background: #4aa9ff;
		}
	</style>
<div class="main_content_iners overly_inners ">
	<div class="container-fluid p-0 ">
		<div class="row">
	        <div class="col-12">
	            <div class="page_title_box d-flex align-items-center justify-content-between">
	                <div class="page_title_left">
	                    <h3 class="f_s_30 f_w_700 text_white">Students</h3>
	                    <ol class="breadcrumb page_bradcam mb-0">
	                    	<li class="breadcrumb-item"><a href="index">Dashboard </a></li>
	                    	<li class="breadcrumb-item active">Students</li>
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
					
					<div >
					<br>
					<?php
						// 0 = Mobile User // 1 = Walk in Member
						$query = mysqli_query($con, "SELECT * FROM members_tbl WHERE account_status = '1'");
						if ($rows = mysqli_num_rows($query) > 0) {
								
							}else{
								?>
								<div class="alert alert-warning">
									<label>No Data Available.</label>
								</div>
								<?php
							}
						?>
					<div class="">
						<label><b>Total: <?php echo mysqli_num_rows($query); ?></b></label>
						<a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#add_walkin_member" style="float: right;">Add Student</a>
					</div>
					<br>
					
					<div >
						<table class="table table-bordered" id="myTable">
						    <thead>
						        <th class="text-center">#</th>
						        <th class="text-center">First Name</th>
						        <th class="text-center">Last Name</th>
						        <th class="text-center">Email</th>
						        <th class="text-center">Contact Number</th>
						        <th class="text-center">College</th>
						        <th class="text-center">Course</th>
						        <th class="text-center">Date of Birth</th>
						        <th class="text-center">Address</th>
						        <th class="text-center">School Year</th>
						        <th class="text-center">Action</th>
						    </thead>
						    <tbody>
						        <?php
						        $i = 1;
						        while ($row = mysqli_fetch_assoc($query)) {
						            $rF = mysqli_query($con, "SELECT * FROM fingerprints WHERE id = '{$row['member_id']}'");
						            $rFrows = mysqli_num_rows($rF);
						            ?>
						            <tr>
						                <td class="text-center"><?php echo $row['member_id']; ?></td>
						                <td class="text-center"><?php echo $row['fname']; ?></td>
						                <td class="text-center"><?php echo $row['lname']; ?></td>
						                <td class="text-center"><?php echo $row['email']; ?></td>
						                <td class="text-center"><?php echo $row['contact_number']; ?></td>
						                <td class="text-center"><?php echo $row['college']; ?></td>
						                <td class="text-center"><?php echo $row['course']; ?></td>
						                <td class="text-center"><?php echo $row['dob']; ?></td>
						                <td class="text-center"><?php echo $row['address']; ?></td>
						                <td class="text-center"><?php echo $row['school_year']; ?></td>
						                <td class="text-center">
						                    <a href="enroll_view.php?member_id=<?php echo $row['member_id']; ?>">Update</a>
						                </td>
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
	</div>
</div>
<div class="modal fade" id="add_walkin_member" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form action="../../controller/admin/process/save_data.php" method="POST">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div>
          <div class="modal-header">
            <h3 class="modal-title" style="color: black;">Add Student</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="form-group row">
              <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control" required placeholder="Type Here...">
              </div>
              <div class="col-md-6">
                <label>Last Name</label>
                <input type="text" name="lname" class="form-control" required placeholder="Type Here...">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <label>Email</label>
                <input type="text" name="email" class="form-control" required placeholder="Type Here...">
              </div>
              <div class="col-md-6">
                <label>Contact Number</label>
                <input type="text" name="contact_number" required placeholder="Type Here..." class="form-control" maxlength="13" 
                  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" 
                  value="+63">
              </div>
            </div>

            <!-- New Fields -->
            <div class="form-group row">
              <div class="col-md-6">
                <label>College</label>
                <input type="text" name="college" class="form-control" required placeholder="Type Here...">
              </div>
              <div class="col-md-6">
                <label>Course</label>
                <input type="text" name="course" class="form-control" required placeholder="Type Here...">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label>School Year</label>
                <input type="text" name="school_year" class="form-control" required placeholder="e.g. 2024-2025">
              </div>
            </div>

            <div class="form-group">
              <label>Address</label>
              <textarea name="address" class="form-control" rows="2" required placeholder="Type Here..."></textarea>
            </div>
          </div>

          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Save" name="btnAddWalkinMember">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
	function block_member(m_id) {
		if (confirm('Block Member?')) {
			window.location.href='../../controller/admin/process/save_data.php?m_id='+m_id+'&btnBlockMem=1';
		}
	}
	$(document).ready( function () {
	    $('#myTable').DataTable({
	    	"ordering": false
	    });
	});
</script>

<?php include 'footer.php'; ?>