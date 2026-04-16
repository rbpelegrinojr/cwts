<?php include 'header.php'; ?>
<!-- <script type="text/javascript" src="assets/jquery-3.4.1.min"></script> -->

<style type="text/css">
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

    <!-- =========================================================
         SETTINGS TABLES
    ========================================================= -->
    <div class="row">

      <!-- Colleges Table -->
      <div class="table-responsive col-md-3">
        <div class="row">
          <div class="col-md-6">
            <label><b>Colleges</b></label>
          </div>
          <div class="col-md-6">
            <a href="#" class="btn btn-info btn-sm" style="float:right;" data-toggle="modal" data-target="#add_college_modal">Add</a>
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
              $college_query = mysqli_query($con, "SELECT * FROM colleges ORDER BY college_name ASC");
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
                  <a href="#" onclick="deleteCollege(<?php echo (int)$row['college_id']; ?>);"><span class="fa fa-trash"></span></a>
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
                        <input type="hidden" name="college_id" value="<?php echo (int)$row['college_id']; ?>">
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
      <div class="table-responsive col-md-3">
        <div class="row">
          <div class="col-md-6">
            <label><b>Courses</b></label>
          </div>
          <div class="col-md-6">
            <a href="#" class="btn btn-info btn-sm" style="float:right;" data-toggle="modal" data-target="#add_course_modal">Add</a>
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
              $course_query = mysqli_query($con, "
                SELECT c.*, col.college_name
                FROM courses c
                JOIN colleges col ON c.college_id = col.college_id
                ORDER BY c.course_name ASC
              ");
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
                  <a href="#" onclick="deleteCourse(<?php echo (int)$row['course_id']; ?>);"><span class="fa fa-trash"></span></a>
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
                        <input type="hidden" name="course_id" value="<?php echo (int)$row['course_id']; ?>">
                        <label>Course Name</label>
                        <input type="text" name="course_name" class="form-control" value="<?php echo $row['course_name']; ?>" required>
                        <label>Abbreviation</label>
                        <input type="text" name="course_abbreviation" class="form-control" value="<?php echo $row['course_abbreviation']; ?>" required>
                        <label>College</label>
                        <select name="college_id" class="form-control" required>
                          <?php
                            $col_query = mysqli_query($con, "SELECT * FROM colleges ORDER BY college_name ASC");
                            while ($col = mysqli_fetch_assoc($col_query)) {
                              $selected = ($col['college_id'] == $row['college_id']) ? 'selected' : '';
                              echo "<option value='".(int)$col['college_id']."' {$selected}>{$col['college_name']}</option>";
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

      <!-- System Settings -->
      <div class="table-responsive col-md-3">
        <div class="row">
          <div class="col-md-12">
            <label><b>System Settings</b></label>
          </div>
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
                <div class="modal fade" id="setting_title<?php echo $resSettings['setting_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                      <form action="../../controller/admin/process/save_data.php" method="POST">
                        <div class="modal-header">
                          <h5 class="modal-title">Update System Title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12">
                              <label>System Title</label>
                              <input type="text" name="system_title" class="form-control" required value="<?php echo $resSettings['system_title']; ?>">
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
              <td class="text-center"><img src="<?php echo $resSettings['system_logo']; ?>" style="height:50px;width:50px;"></td>
              <td>
                <a href="#" data-toggle="modal" data-target="#setting_logo<?php echo $resSettings['setting_id']; ?>"><span class="fa fa-edit"></span></a>
                <div class="modal fade" id="setting_logo<?php echo $resSettings['setting_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                      <form action="../../controller/admin/process/save_data.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                          <h5 class="modal-title">Update System Logo</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12">
                              <label>System Logo</label>
                              <input type="file" name="system_logo" class="form-control" required>
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

      <div class="table-responsive col-md-3">
        <div class="row">
          <div class="col-md-6">
            <label><b>School Years</b></label>
          </div>
          <div class="col-md-6">
            <a href="#" class="btn btn-info btn-sm" style="float:right;" data-toggle="modal" data-target="#add_school_year_modal">Add</a>
          </div>
        </div>
        <br>

        <table class="table table-bordered">
          <thead>
            <th>#</th>
            <th>School Year</th>
            <th>Status</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php
              $sy_q = mysqli_query($con, "SELECT * FROM school_years ORDER BY school_year DESC");
              $i = 1;
              while ($sy = mysqli_fetch_assoc($sy_q)) {
                $isActive = ((int)$sy['is_active'] === 1);
            ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $sy['school_year']; ?></td>
                <td>
                  <?php if ($isActive) { ?>
                    <span class="badge badge-success">Active</span>
                  <?php } else { ?>
                    <span class="badge badge-secondary">Inactive</span>
                  <?php } ?>
                </td>
                <td>
                  <a href="#" data-toggle="modal" data-target="#edit_school_year_modal<?php echo (int)$sy['school_year_id']; ?>"><span class="fa fa-edit"></span></a>
                  |
                  <?php if (!$isActive) { ?>
                    <form action="../../controller/admin/process/save_data.php" method="POST" style="display:inline;">
                      <input type="hidden" name="school_year_id" value="<?php echo (int)$sy['school_year_id']; ?>">
                      <button type="submit" name="btnSetActiveSchoolYear" class="btn btn-link p-0" title="Set Active" style="text-decoration:none;">
                        <span class="fa fa-check"></span>
                      </button>
                    </form>
                    |
                  <?php } ?>
                  <a href="#" onclick="deleteSchoolYear(<?php echo (int)$sy['school_year_id']; ?>);"><span class="fa fa-trash"></span></a>
                </td>
              </tr>

              <!-- Edit School Year Modal -->
              <div class="modal fade" id="edit_school_year_modal<?php echo (int)$sy['school_year_id']; ?>" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                  <div class="modal-content">
                    <form action="../../controller/admin/process/save_data.php" method="POST">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit School Year</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="school_year_id" value="<?php echo (int)$sy['school_year_id']; ?>">
                        <label>School Year</label>
                        <input type="text" name="school_year" class="form-control" required value="<?php echo $sy['school_year']; ?>" placeholder="e.g. 2025-2026">
                        <small class="text-muted">Format recommendation: YYYY-YYYY</small>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" name="btnEditSchoolYear" value="Save" class="btn btn-primary">
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            <?php } ?>
            <?php if (mysqli_num_rows($sy_q) == 0) { ?>
              <tr>
                <td colspan="4" class="text-center">No school years yet.</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

    </div><!-- /.row -->

  </div>
</div>

<!-- =========================================================
     MODALS: ADD COLLEGE / ADD COURSE / ADD SCHOOL YEAR
========================================================= -->

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
              $col_query = mysqli_query($con, "SELECT * FROM colleges ORDER BY college_name ASC");
              while ($col = mysqli_fetch_assoc($col_query)) {
                echo "<option value='".(int)$col['college_id']."'>{$col['college_name']}</option>";
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

<!-- Add School Year Modal -->
<div class="modal fade" id="add_school_year_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <form action="../../controller/admin/process/save_data.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">New School Year</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <label>School Year</label>
          <input type="text" name="school_year" class="form-control" required placeholder="e.g. 2025-2026">
          <div class="mt-2">
            <label style="margin:0;">
              <input type="checkbox" name="make_active" value="1">
              Set as active
            </label>
          </div>
          <small class="text-muted">Tip: Use YYYY-YYYY format.</small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" name="btnAddSchoolYear" value="Save" class="btn btn-primary">
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
function deleteSchoolYear(sy_id) {
  if (confirm('Delete School Year?')) {
    window.location.href='../../controller/admin/process/delete_data.php?sy_id='+sy_id+'&btnDelSchoolYear=1';
  }
}
</script>

<?php include 'footer.php'; ?>
