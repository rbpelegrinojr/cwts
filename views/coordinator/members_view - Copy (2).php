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
					<div class="white_card_body">
						<?php
						$query = mysqli_query($con, "
						    SELECT m.member_id, m.fname, m.mname, m.lname, m.email, m.contact_number, 
						           c.college_name, cs.course_name, m.dob, m.address, m.school_year
						    FROM members_tbl m
						    LEFT JOIN colleges c ON m.college_id = c.college_id
						    LEFT JOIN courses cs ON m.course_id = cs.course_id
						    WHERE m.account_status = '1' AND m.college_id = '{$resInfo['college_id']}'
						") or die(mysqli_error($con));

						if (mysqli_num_rows($query) <= 0) {
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

						<!-- 🔹 Search & Filters -->
						<div class="row mb-3">
						    <div class="col-md-3">
						        <label><b>Search by Name:</b></label>
						        <input type="text" id="searchName" class="form-control" placeholder="Enter First, Middle or Last Name">
						    </div>
						    <div class="col-md-3">
						        <label><b>Filter by College:</b></label>
						        <select id="filterCollege" class="form-control">
						            <option value="">All Colleges</option>
						            <?php
									$collegeQuery = mysqli_query($con, "SELECT * FROM colleges ORDER BY college_name ASC");
									while ($col = mysqli_fetch_assoc($collegeQuery)) {
									    echo "<option value='".$col['college_name']."'>".$col['college_name']."</option>";
									}
									?>
						        </select>
						    </div>
						    <div class="col-md-3">
						        <label><b>Filter by Course:</b></label>
						        <select id="filterCourse" class="form-control">
						            <option value="">All Courses</option>
						            <?php
									$courseQuery = mysqli_query($con, "SELECT * FROM courses ORDER BY course_name ASC");
									while ($crs = mysqli_fetch_assoc($courseQuery)) {
									    echo "<option value='".$crs['course_name']."'>".$crs['course_name']."</option>";
									}
									?>
						        </select>
						    </div>
						    <div class="col-md-3">
						        <label><b>Filter by School Year:</b></label>
						        <select id="filterSchoolYear" class="form-control">
						            <option value="">All Years</option>
						            <option value="2024">2024</option>
						            <option value="2025">2025</option>
						        </select>
						    </div>
						</div>

						<!-- 🔹 Table -->
						<div>
							<table class="table table-bordered" id="myTable">
							    <thead>
							        <th class="text-center">#</th>
							        <th class="text-center">First Name</th>
							        <th class="text-center">Middle Name</th>
							        <th class="text-center">Last Name</th>
							        <th class="text-center">Email</th>
							        <th class="text-center">Contact Number</th>
							        <th class="text-center">College</th>
							        <th class="text-center">Course</th>
							        <th class="text-center">Date of Birth</th>
							        <th class="text-center">Address</th>
							        <th class="text-center">School Year</th>
							        <th class="text-center">Attendance</th>
							    </thead>
							    <tbody>
							        <?php
									mysqli_data_seek($query, 0);
									while ($row = mysqli_fetch_assoc($query)) {
									?>
									    <tr>
									        <td class="text-center"><?php echo $row['member_id']; ?></td>
									        <td class="text-center"><?php echo $row['fname']; ?></td>
									        <td class="text-center"><?php echo $row['mname']; ?></td>
									        <td class="text-center"><?php echo $row['lname']; ?></td>
									        <td class="text-center"><?php echo $row['email']; ?></td>
									        <td class="text-center"><?php echo $row['contact_number']; ?></td>
									        <td class="text-center"><?php echo $row['college_name']; ?></td>
									        <td class="text-center"><?php echo $row['course_name']; ?></td>
									        <td class="text-center"><?php echo $row['dob']; ?></td>
									        <td class="text-center"><?php echo $row['address']; ?></td>
									        <td class="text-center"><?php echo $row['school_year']; ?></td>
									        <td class="text-center"><a href="attendance_details_view.php?id=<?php echo $row['member_id']; ?>" class="btn btn-sm btn-success">View</a></td>
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

<!-- 🔹 JavaScript for Filtering & Search -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    function filterTable() {
        var college = $("#filterCollege").val().toLowerCase();
        var course = $("#filterCourse").val().toLowerCase();
        var schoolYear = $("#filterSchoolYear").val().toLowerCase();
        var searchName = $("#searchName").val().toLowerCase();

        $("#myTable tbody tr").filter(function() {
            var rowCollege = $(this).find("td:eq(6)").text().toLowerCase();
            var rowCourse = $(this).find("td:eq(7)").text().toLowerCase();
            var rowSY = $(this).find("td:eq(10)").text().toLowerCase();
            
            var rowFname = $(this).find("td:eq(1)").text().toLowerCase();
            var rowMname = $(this).find("td:eq(2)").text().toLowerCase();
            var rowLname = $(this).find("td:eq(3)").text().toLowerCase();
            var fullName = rowFname + " " + rowMname + " " + rowLname;

            $(this).toggle(
                (college === "" || rowCollege === college) &&
                (course === "" || rowCourse === course) &&
                (schoolYear === "" || rowSY === schoolYear) &&
                (searchName === "" || rowFname.includes(searchName) || rowMname.includes(searchName) || rowLname.includes(searchName) || fullName.includes(searchName))
            );
        });
    }

    $("#filterCollege, #filterCourse, #filterSchoolYear").on("change", function(){
        filterTable();
    });

    $("#searchName").on("keyup", function(){
        filterTable();
    });
});
</script>


<!-- Add Walk-in Member Modal -->
<div class="modal fade" id="add_walkin_member" tabindex="-1" role="dialog" aria-hidden="true">
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
              <div class="col-md-4">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control" required placeholder="Type Here...">
              </div>
              <div class="col-md-4">
                <label>Middle Name</label>
                <input type="text" name="mname" class="form-control" required placeholder="Type Here...">
              </div>
              <div class="col-md-4">
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

            <!-- College and Course Dropdowns -->
            <div class="form-group row">
              <div class="col-md-6">
                <label>College</label>
                <select name="college_id" id="college_id" class="form-control" required>
                  <?php
                  $college_query = mysqli_query($con, "SELECT * FROM colleges WHERE college_id = '{$resInfo['college_id']}'");
                  while ($col = mysqli_fetch_assoc($college_query)) {
                      echo "<option value='{$col['college_id']}'>{$col['college_name']}</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label>Course</label>
                <select name="course_id" id="course_id" class="form-control" required>
                  <option value="">Select Course</option>
                </select>
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
<script>
$(document).ready(function() {
    // Function to load courses based on college_id
    function loadCourses() {
        var college_id = $("#college_id").val();
        if (college_id != "") {
            $.ajax({
                url: "fetch_courses.php",
                method: "POST",
                data: { college_id: college_id },
                success: function(data) {
                    $("#course_id").html(data);
                }
            });
        } else {
            $("#course_id").html('<option value="">Select Course</option>');
        }
    }

    // Trigger when college_id changes
    $("#college_id").change(function() {
        loadCourses();
    });

    // 🔹 Auto-load courses when the page first loads
    loadCourses();
});
</script>


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