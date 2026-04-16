<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="../../include/DataTables/datatables.min.css">
<script type="text/javascript" src="../../include/DataTables/datatables.min.js"></script>

<style>
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
.white_card_body { padding: 20px; }
.page_title_box h3 { color: #fff; }
.footer_part,
.footer_part .footer_iner.text-center{ background: #4aa9ff; }
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
            /*
              If you want coordinators to ONLY see students from their own college:
              keep the filter below.

              If you want admins to see ALL colleges:
              remove the AND m.college_id = '{$resInfo['college_id']}' condition.
            */
            $restrictCollege = true; // set to false if you want ALL colleges visible

            $whereCollegeSql = "";
            if ($restrictCollege && isset($resInfo['college_id'])) {
                $college_id = mysqli_real_escape_string($con, $resInfo['college_id']);
                $whereCollegeSql = " AND m.college_id = '$college_id' ";
            }

            $query = mysqli_query($con, "
              SELECT
                m.member_id, m.fname, m.mname, m.lname, m.email, m.contact_number,
                c.college_name, cs.course_name, m.dob, m.address, m.school_year,
                m.college_id, m.course_id, m.guardian_contact_number, m.guardian_name
              FROM members_tbl m
              LEFT JOIN colleges c ON m.college_id = c.college_id
              LEFT JOIN courses cs ON m.course_id = cs.course_id
              WHERE m.account_status = '1'
              $whereCollegeSql
              ORDER BY m.member_id DESC
            ") or die(mysqli_error($con));
            ?>

            <div class="">
              <label><b>Total: <?php echo mysqli_num_rows($query); ?></b></label>
              <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#add_walkin_member" style="float:right;">Add Student</a>
            </div>

            <!-- Filters -->
            <div class="row mb-4 mt-3">
              <div class="col-md-3">
                <label><b>Search by Name:</b></label>
                <input type="text" id="searchName" class="form-control" placeholder="Enter First, Middle or Last Name">
              </div>

              <div class="col-md-3">
                <label><b>Filter by College:</b></label>
                <select id="filterCollege" class="form-control">
                  <option value="">All Colleges</option>
                  <?php
                    // If coordinator is restricted, show only their college in filter
                    if ($restrictCollege && isset($resInfo['college_id'])) {
                        $cid = mysqli_real_escape_string($con, $resInfo['college_id']);
                        $colQuery = mysqli_query($con, "SELECT * FROM colleges WHERE college_id = '$cid' ORDER BY college_name ASC");
                    } else {
                        $colQuery = mysqli_query($con, "SELECT * FROM colleges ORDER BY college_name ASC");
                    }

                    while ($col = mysqli_fetch_assoc($colQuery)) {
                        echo "<option value=\"".htmlspecialchars($col['college_name'])."\">".htmlspecialchars($col['college_name'])."</option>";
                    }
                  ?>
                </select>
              </div>

              <div class="col-md-3">
                <label><b>Filter by Course:</b></label>
                <select id="filterCourse" class="form-control">
                  <option value="">All Courses</option>
                  <?php
                    // If restricted, show courses of that college; else show all courses
                    if ($restrictCollege && isset($resInfo['college_id'])) {
                        $cid = mysqli_real_escape_string($con, $resInfo['college_id']);
                        $courseQuery = mysqli_query($con, "
                          SELECT cs.course_name
                          FROM courses cs
                          WHERE cs.college_id = '$cid'
                          ORDER BY cs.course_name ASC
                        ");
                    } else {
                        $courseQuery = mysqli_query($con, "SELECT course_name FROM courses ORDER BY course_name ASC");
                    }

                    while ($crs = mysqli_fetch_assoc($courseQuery)) {
                        echo "<option value=\"".htmlspecialchars($crs['course_name'])."\">".htmlspecialchars($crs['course_name'])."</option>";
                    }
                  ?>
                </select>
              </div>

              <div class="col-md-3">
                <label><b>Filter by School Year:</b></label>
                <select id="filterSchoolYear" class="form-control">
                  <option value="">All Years</option>
                  <?php
                    // Auto-generate from DB instead of hardcoding 2024/2025
                    $syQuery = mysqli_query($con, "
                      SELECT DISTINCT school_year
                      FROM members_tbl
                      WHERE account_status='1'
                      $whereCollegeSql
                      AND school_year IS NOT NULL AND school_year <> ''
                      ORDER BY school_year DESC
                    ");
                    while ($sy = mysqli_fetch_assoc($syQuery)) {
                        echo "<option value=\"".htmlspecialchars($sy['school_year'])."\">".htmlspecialchars($sy['school_year'])."</option>";
                    }
                  ?>
                </select>
              </div>

              <div class="col-md-3 mt-3">
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
                      <td><?php echo htmlspecialchars($row['fname']); ?></td>
                      <td><?php echo htmlspecialchars($row['mname']); ?></td>
                      <td><?php echo htmlspecialchars($row['lname']); ?></td>
                      <td><?php echo htmlspecialchars($row['email']); ?></td>
                      <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                      <td><?php echo htmlspecialchars($row['guardian_name']); ?></td>
                      <td><?php echo htmlspecialchars($row['guardian_contact_number']); ?></td>
                      <td><?php echo htmlspecialchars($row['college_name']); ?></td>
                      <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                      <td><?php echo htmlspecialchars($row['dob']); ?></td>
                      <td><?php echo htmlspecialchars($row['address']); ?></td>
                      <td><?php echo htmlspecialchars($row['school_year']); ?></td>
                      <td class="text-center">
                        <a href="attendance_details_view.php?id=<?php echo (int)$row['member_id']; ?>" class="btn btn-sm btn-success">View</a>
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_<?php echo (int)$row['member_id']; ?>">Edit</a>
                        <a href="../../controller/coordinator/process/save_data.php?delete_id=<?php echo (int)$row['member_id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this student?');"
                           class="btn btn-sm btn-danger">Delete</a>
                      </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="edit_<?php echo (int)$row['member_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                      <form action="../../controller/coordinator/process/save_data.php" method="POST">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title" style="color:black;">Edit Student</h3>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                            <div class="modal-body">
                              <input type="hidden" name="member_id" value="<?php echo (int)$row['member_id']; ?>">

                              <div class="form-group row">
                                <div class="col-md-4">
                                  <label>First Name</label>
                                  <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($row['fname']); ?>" required>
                                </div>
                                <div class="col-md-4">
                                  <label>Middle Name</label>
                                  <input type="text" name="mname" class="form-control" value="<?php echo htmlspecialchars($row['mname']); ?>" required>
                                </div>
                                <div class="col-md-4">
                                  <label>Last Name</label>
                                  <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($row['lname']); ?>" required>
                                </div>
                              </div>

                              <div class="form-group row">
                                <div class="col-md-6">
                                  <label>Email</label>
                                  <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                  <label>Contact Number</label>
                                  <input type="text" name="contact_number" class="form-control" value="<?php echo htmlspecialchars($row['contact_number']); ?>" maxlength="13" required>
                                </div>
                              </div>

                              <div class="form-group row">
                                <div class="col-md-6">
                                  <label>Guardian Name</label>
                                  <input type="text" name="guardian_name" class="form-control" value="<?php echo htmlspecialchars($row['guardian_name']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                  <label>Guardian Contact Number</label>
                                  <input type="text" name="guardian_contact_number" class="form-control" value="<?php echo htmlspecialchars($row['guardian_contact_number']); ?>" maxlength="13" required>
                                </div>
                              </div>

                              <div class="form-group row">
                                <div class="col-md-6">
                                  <label>College</label>
                                  <select name="college_id" class="form-control" required>
                                    <?php
                                      // If restricted, only allow their college in edit
                                      if ($restrictCollege && isset($resInfo['college_id'])) {
                                          $cid = mysqli_real_escape_string($con, $resInfo['college_id']);
                                          $colleges = mysqli_query($con, "SELECT * FROM colleges WHERE college_id='$cid' ORDER BY college_name ASC");
                                      } else {
                                          $colleges = mysqli_query($con, "SELECT * FROM colleges ORDER BY college_name ASC");
                                      }
                                      while ($c = mysqli_fetch_assoc($colleges)) {
                                        $selected = ((int)$row['college_id'] == (int)$c['college_id']) ? 'selected' : '';
                                        echo "<option value='".(int)$c['college_id']."' $selected>".htmlspecialchars($c['college_name'])."</option>";
                                      }
                                    ?>
                                  </select>
                                </div>
                                <div class="col-md-6">
                                  <label>Course</label>
                                  <select name="course_id" class="form-control" required>
                                    <?php
                                      // Keep as-is: loads all courses. (You can upgrade later to load by college via AJAX per edit modal)
                                      $courses = mysqli_query($con, "SELECT * FROM courses ORDER BY course_name ASC");
                                      while ($crs = mysqli_fetch_assoc($courses)) {
                                        $selected = ((int)$row['course_id'] == (int)$crs['course_id']) ? 'selected' : '';
                                        echo "<option value='".(int)$crs['course_id']."' $selected>".htmlspecialchars($crs['course_name'])."</option>";
                                      }
                                    ?>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group row">
                                <div class="col-md-6">
                                  <label>Date of Birth</label>
                                  <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($row['dob']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                  <label>School Year</label>
                                  <input type="text" name="school_year" class="form-control" value="<?php echo htmlspecialchars($row['school_year']); ?>" required>
                                </div>
                              </div>

                              <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" class="form-control" rows="2" required><?php echo htmlspecialchars($row['address']); ?></textarea>
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
            </div><!-- table-responsive -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery (keep one; your header may already include it) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

  // If DataTable is enabled, we’ll filter by hiding rows (works, but DataTables pagination/search won't reflect counts).
  // If you want FULL DataTables filtering, tell me and I will convert to DataTables column-search API.
  function filterTable() {
    var college   = ($("#filterCollege").val() || "").toLowerCase();
    var course    = ($("#filterCourse").val() || "").toLowerCase();
    var schoolYear= ($("#filterSchoolYear").val() || "").toLowerCase();
    var searchName= ($("#searchName").val() || "").toLowerCase();

    $("#myTable tbody tr").each(function() {
      // Column indexes (0-based):
      // 0 member_id
      // 1 fname
      // 2 mname
      // 3 lname
      // 4 email
      // 5 contact
      // 6 guardian name
      // 7 guardian contact
      // 8 college
      // 9 course
      // 10 dob
      // 11 address
      // 12 school_year
      var rowCollege = $(this).find("td:eq(8)").text().toLowerCase();
      var rowCourse  = $(this).find("td:eq(9)").text().toLowerCase();
      var rowSY      = $(this).find("td:eq(12)").text().toLowerCase();

      var rowFname = $(this).find("td:eq(1)").text().toLowerCase();
      var rowMname = $(this).find("td:eq(2)").text().toLowerCase();
      var rowLname = $(this).find("td:eq(3)").text().toLowerCase();
      var fullName = (rowFname + " " + rowMname + " " + rowLname).trim();

      var okCollege = (college === "" || rowCollege.includes(college));
      var okCourse  = (course === "" || rowCourse.includes(course));
      var okSY      = (schoolYear === "" || rowSY.includes(schoolYear));
      var okName    = (searchName === "" || fullName.includes(searchName) || rowFname.includes(searchName) || rowMname.includes(searchName) || rowLname.includes(searchName));

      $(this).toggle(okCollege && okCourse && okSY && okName);
    });
  }

  $("#filterCollege, #filterCourse, #filterSchoolYear").on("change", filterTable);
  $("#searchName").on("keyup", filterTable);

  // DataTable init (optional). If you notice conflicts with manual filtering, disable DataTables.
  $('#myTable').DataTable({
    ordering: false
  });

});
</script>

<!-- Add Walk-in Member Modal -->
<div class="modal fade" id="add_walkin_member" tabindex="-1" role="dialog" aria-hidden="true">
  <form action="../../controller/coordinator/process/save_data.php" method="POST">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div>
          <div class="modal-header">
            <h3 class="modal-title" style="color:black;">Add Student</h3>
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

            <div class="form-group row">
              <div class="col-md-6">
                <label>Guardian Name</label>
                <input type="text" name="guardian_name" required placeholder="Type Here..." class="form-control">
              </div>

              <div class="col-md-6">
                <label>Guardian Contact Number</label>
                <input type="text" name="guardian_contact_number" required placeholder="Type Here..." class="form-control" maxlength="13"
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
                    if ($restrictCollege && isset($resInfo['college_id'])) {
                        $cid = mysqli_real_escape_string($con, $resInfo['college_id']);
                        $college_query = mysqli_query($con, "SELECT * FROM colleges WHERE college_id = '$cid' ORDER BY college_name ASC");
                    } else {
                        $college_query = mysqli_query($con, "SELECT * FROM colleges ORDER BY college_name ASC");
                    }
                    while ($col = mysqli_fetch_assoc($college_query)) {
                      echo "<option value='".(int)$col['college_id']."'>".htmlspecialchars($col['college_name'])."</option>";
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

  $("#college_id").change(function() {
    loadCourses();
  });

  loadCourses();
});
</script>

<script type="text/javascript">
function block_member(m_id) {
  if (confirm('Block Member?')) {
    window.location.href='../../controller/coordinator/process/save_data.php?m_id='+m_id+'&btnBlockMem=1';
  }
}
</script>

<?php include 'footer.php'; ?>
