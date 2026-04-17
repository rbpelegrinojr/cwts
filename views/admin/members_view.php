<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="../../include/DataTables/datatables.min.css">
<script type="text/javascript" src="../../include/DataTables/datatables.min.js"></script>

<style>
/* ===== Layout & Design ===== */
.main_content .main_content_iners {
    min-height: 68vh;
    transition: .5s;
    position: relative;
    margin: 0;
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
}

.white_card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
}

.white_card_body {
    padding: 20px;
}

.page_title_box h3 {
    color: #fff;
}

.footer_part{
    background: #4aa9ff;
}
.footer_part .footer_iner.text-center{
    background: #4aa9ff;
}
</style>

<div class="main_content_iners overly_inners">
    <div class="container-fluid p-0">
        <!-- Page Title -->
        <div class="row mb-2">
            <div class="col-12">
                <div class="page_title_box d-flex align-items-center justify-content-between">
                    <div class="page_title_left">
                        <h3 class="f_s_30 f_w_700 text_white">Students</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Students</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Table Card -->
        <div class="row">
            <div class="col-lg-12">
                <div class="white_card card_height_100 mb_30">
                    <div class="white_card_body">
                        <?php
                        $query = mysqli_query($con, "
                            SELECT m.member_id, m.fname, m.mname, m.lname, m.email, m.contact_number, 
                                   c.college_name, cs.course_name, m.dob, m.address, m.school_year, m.guardian_contact_number, 
                                   m.guardian_name
                            FROM members_tbl m
                            LEFT JOIN colleges c ON m.college_id = c.college_id
                            LEFT JOIN courses cs ON m.course_id = cs.course_id
                            WHERE m.account_status = '1'
                        ") or die(mysqli_error($con));

                        if (mysqli_num_rows($query) <= 0) {
                            echo '<div class="alert alert-warning">No Data Available.</div>';
                        }
                        ?>

                        <div class="d-flex justify-content-between mb-3">
                            <label><b>Total: <?php echo mysqli_num_rows($query); ?></b></label>
                            <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#add_walkin_member" style="display: none;">Add Student</a>
                        </div>

                        <!-- Filters -->
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
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    
                                    <a href="members_view" class="btn btn-primary">Refresh</a>
                                </div>
                            </div>
                        </div>

                        <!-- Student Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle" id="myTable">
                                <thead class="table-dark text-center">
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Guardian Name</th>
                                    <th>Guardian Contact Number</th>
                                    <th>College</th>
                                    <th>Course</th>
                                    <th>Date of Birth</th>
                                    <th>Address</th>
                                    <th>School Year</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    mysqli_data_seek($query, 0);
                                    while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr class="text-center">
                                            <td><?php echo $row['member_id']; ?></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php echo $row['mname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['contact_number']; ?></td>
                                            <td><?php echo $row['guardian_name']; ?></td>
                                            <td><?php echo $row['guardian_contact_number']; ?></td>
                                            <td><?php echo $row['college_name']; ?></td>
                                            <td><?php echo $row['course_name']; ?></td>
                                            <td><?php echo $row['dob']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['school_year']; ?></td>
                                            <td><a href="student_details_view.php?id=<?php echo $row['member_id']; ?>" class="btn btn-sm btn-info">More Details</a>
                                            <a href="attendance_details_view.php?id=<?php echo $row['member_id']; ?>" class="btn btn-sm btn-success">View Attendance</a>
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_<?php echo $row['member_id']; ?>">Edit</a>
                                            <a href="../../controller/coordinator/process/save_data.php?delete_id=<?php echo $row['member_id']; ?>" 
                                               onclick="return confirm('Are you sure you want to delete this student?');" 
                                               class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>

                                        <!-- 🔹 Edit Modal -->
                                    <div class="modal fade" id="edit_<?php echo $row['member_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                      <form action="../../controller/coordinator/process/save_data.php" method="POST">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h3 class="modal-title" style="color: black;">Edit Student</h3>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>

                                            <div class="modal-body">
                                              <input type="hidden" name="member_id" value="<?php echo $row['member_id']; ?>">

                                              <div class="form-group row">
                                                <div class="col-md-4">
                                                  <label>First Name</label>
                                                  <input type="text" name="fname" class="form-control" value="<?php echo $row['fname']; ?>" required>
                                                </div>
                                                <div class="col-md-4">
                                                  <label>Middle Name</label>
                                                  <input type="text" name="mname" class="form-control" value="<?php echo $row['mname']; ?>" required>
                                                </div>
                                                <div class="col-md-4">
                                                  <label>Last Name</label>
                                                  <input type="text" name="lname" class="form-control" value="<?php echo $row['lname']; ?>" required>
                                                </div>
                                              </div>

                                              <div class="form-group row">
                                                <div class="col-md-6">
                                                  <label>Email</label>
                                                  <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                  <label>Contact Number</label>
                                                  <input type="text" name="contact_number" class="form-control" value="<?php echo $row['contact_number']; ?>" maxlength="13" required>
                                                </div>
                                              </div>
                                              <div class="form-group row">
                                                  <div class="col-md-6">
                                                    <label>Guardian Name</label>
                                                    <input type="text" name="guardian_name" class="form-control" value="<?php echo $row['guardian_name']; ?>" maxlength="13" required>
                                                  </div>

                                                  <div class="col-md-6">
                                                    <label>Guardian Contact Number</label>
                                                    <input type="text" name="guardian_contact_number" class="form-control" value="<?php echo $row['guardian_contact_number']; ?>" maxlength="13" required>
                                                  </div>
                                                </div>

                                              <div class="form-group row">
                                                <div class="col-md-6">
                                                  <label>College</label>
                                                  <select name="college_id" class="form-control" required>
                                                    <?php
                                                    $colleges = mysqli_query($con, "SELECT * FROM colleges");
                                                    while ($c = mysqli_fetch_assoc($colleges)) {
                                                        $selected = ($row['college_id'] == $c['college_id']) ? 'selected' : '';
                                                        echo "<option value='{$c['college_id']}' $selected>{$c['college_name']}</option>";
                                                    }
                                                    ?>
                                                  </select>
                                                </div>
                                                <div class="col-md-6">
                                                  <label>Course</label>
                                                  <select name="course_id" class="form-control" required>
                                                    <?php
                                                    $courses = mysqli_query($con, "SELECT * FROM courses");
                                                    while ($crs = mysqli_fetch_assoc($courses)) {
                                                        $selected = ($row['course_id'] == $crs['course_id']) ? 'selected' : '';
                                                        echo "<option value='{$crs['course_id']}' $selected>{$crs['course_name']}</option>";
                                                    }
                                                    ?>
                                                  </select>
                                                </div>
                                              </div>

                                              <div class="form-group row">
                                                <div class="col-md-6">
                                                  <label>Date of Birth</label>
                                                  <input type="date" name="dob" class="form-control" value="<?php echo $row['dob']; ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                  <label>School Year</label>
                                                  <input type="text" name="school_year" class="form-control" value="<?php echo $row['school_year']; ?>" required>
                                                </div>
                                              </div>

                                              <div class="form-group">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control" rows="2" required><?php echo $row['address']; ?></textarea>
                                              </div>
                                            </div>

                                            <div class="modal-footer">
                                              <input type="submit" class="btn btn-primary" value="Update" name="btnEditMember">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>
                                        </div>
                                      </form>
                                    </div>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JS: Search & Filter -->
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

    $("#filterCollege, #filterCourse, #filterSchoolYear").on("change", filterTable);
    $("#searchName").on("keyup", filterTable);

    $('#myTable').DataTable({"ordering": false});
});
</script>

<?php include 'footer.php'; ?>
