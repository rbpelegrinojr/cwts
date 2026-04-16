<?php include 'header.php'; ?>
<?php date_default_timezone_set('Asia/Manila'); ?>

<style>
  #schedule_table {
    max-width: 100%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
  }
</style>

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
  }
</style>

<?php
// ----------------------------------------
// AUTO-ARCHIVE PAST SCHEDULES
// ----------------------------------------
$today = date('Y-m-d');
$now   = date('H:i:s');
$coordinator_id = (int)$resInfo['user_id'];

// Past date => archived (exclude cancelled + archived)
mysqli_query($con, "
  UPDATE schedules_tbl
  SET status = 'archived'
  WHERE coordinator_id = {$coordinator_id}
    AND status NOT IN ('cancelled','archived')
    AND schedule_date < '{$today}'
");

// Today, end_time passed => archived (exclude cancelled + archived)
mysqli_query($con, "
  UPDATE schedules_tbl
  SET status = 'archived'
  WHERE coordinator_id = {$coordinator_id}
    AND status NOT IN ('cancelled','archived')
    AND schedule_date = '{$today}'
    AND end_time < '{$now}'
");

// ----------------------------------------
// FILTER (optional UI filter)
// ----------------------------------------
$status_filter = isset($_GET['status']) ? strtolower(trim($_GET['status'])) : 'all';
$allowed = array('all','active','inactive','archived','cancelled');
if (!in_array($status_filter, $allowed)) $status_filter = 'all';

$where = "coordinator_id = '{$resInfo['user_id']}'";
if ($status_filter != 'all') {
  $where .= " AND status = '" . mysqli_real_escape_string($con, $status_filter) . "'";
}

$query = mysqli_query($con, "SELECT * FROM schedules_tbl WHERE $where ORDER BY schedule_date DESC, start_time DESC");
?>

<div class="main_content_iners overly_inners">
  <div class="container-fluid p-0">
    <div class="row">
      <div class="col-12">
        <h3 class="f_s_30 f_w_700 text_white">SCHEDULE MANAGEMENT</h3>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="white_card mb_30">
          <div class="white_card_body">

            <?php
              if (!$query || mysqli_num_rows($query) == 0) {
                echo '<div class="alert alert-warning"><label>No Schedules Available.</label></div>';
              }
            ?>

            <div class="row align-items-center">
              <div class="col-md-4">
                <label><b>Total: <?php echo ($query ? mysqli_num_rows($query) : 0); ?></b></label>
              </div>

              <div class="col-md-4">
                <!-- STATUS FILTER -->
                <form method="get">
                  <label><b>Filter Status</b></label>
                  <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="all" <?php echo ($status_filter=='all'?'selected':''); ?>>All</option>
                    <option value="active" <?php echo ($status_filter=='active'?'selected':''); ?>>Active</option>
                    <option value="inactive" <?php echo ($status_filter=='inactive'?'selected':''); ?>>Inactive</option>
                    <option value="archived" <?php echo ($status_filter=='archived'?'selected':''); ?>>Archived</option>
                    <option value="cancelled" <?php echo ($status_filter=='cancelled'?'selected':''); ?>>Cancelled</option>
                  </select>
                </form>
              </div>

              <div class="col-md-4 text-right">
                <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#add_schedule">+ Add Schedule</a>
              </div>
            </div>

            <br>

            <div id="schedule_table" class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th>Device ID</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i = 1;
                    if ($query) {
                      mysqli_data_seek($query, 0);
                      while ($row = mysqli_fetch_assoc($query)) {

                        $st = strtolower(trim($row['status']));

                        echo "<tr>
                          <td>{$i}</td>
                          <td>{$row['schedule_date']}</td>
                          <td>{$row['start_time']}</td>
                          <td>{$row['end_time']}</td>
                          <td>{$row['status']}</td>
                          <td>{$row['device_id']}</td>
                          <td>";

                        // Actions rules:
                        // - Cancelled: no update/delete
                        // - Archived: allow delete only (optional)
                        // - Active/Inactive: allow update/delete + cancel
                        if ($st == 'cancelled') {
                          echo "<span class='badge bg-secondary'>Cancelled</span>";
                        } else {
                          // Update allowed if not archived
                          if ($st != 'archived') {
                            echo "<button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#updateScheduleModal{$row['schedule_id']}'>Update</button> ";
                            echo "<a href='../../controller/coordinator/process/save_schedule.php?cancel_id={$row['schedule_id']}'
                                     class='btn btn-secondary btn-sm'
                                     onclick=\"return confirm('Cancel this schedule?');\">Cancel</a> ";
                          } else {
                            echo "<span class='badge bg-info'>Archived</span> ";
                          }

                          echo "<a href='../../controller/coordinator/process/save_schedule.php?delete_id={$row['schedule_id']}'
                                   class='btn btn-danger btn-sm'
                                   onclick=\"return confirm('Are you sure you want to delete this schedule?');\">Delete</a>";
                        }

                        echo "</td></tr>";

                        // Update Modal (only meaningful if not cancelled; still okay to render)
                        echo "
                        <div class='modal fade' id='updateScheduleModal{$row['schedule_id']}' tabindex='-1' role='dialog' aria-hidden='true'>
                          <form action='../../controller/coordinator/process/save_schedule.php' method='POST'>
                            <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
                              <div class='modal-content'>
                                <div class='modal-header'>
                                  <h3 class='modal-title' style='color: black;'>Update Schedule</h3>
                                  <button type='button' class='close' data-dismiss='modal'><span>&times;</span></button>
                                </div>
                                <div class='modal-body'>
                                  <input type='hidden' name='schedule_id' value='{$row['schedule_id']}'>
                                  <div class='form-group row'>
                                    <div class='col-md-4'>
                                      <label>Schedule Date</label>
                                      <input type='date' name='schedule_date' class='form-control' value='{$row['schedule_date']}' required>
                                    </div>
                                    <div class='col-md-4'>
                                      <label>Start Time</label>
                                      <input type='time' name='start_time' class='form-control' value='{$row['start_time']}' required>
                                    </div>
                                    <div class='col-md-4'>
                                      <label>End Time</label>
                                      <input type='time' name='end_time' class='form-control' value='{$row['end_time']}' required>
                                    </div>
                                    <div class='col-md-4'>
                                      <label>Status</label>
                                      <select name='status' class='form-control'>
                                        <option value='active' " . ($row['status'] == 'active' ? 'selected' : '') . ">Active</option>
                                        <option value='inactive' " . ($row['status'] == 'inactive' ? 'selected' : '') . ">Inactive</option>
                                        <option value='archived' " . ($row['status'] == 'archived' ? 'selected' : '') . ">Archived</option>
                                        <option value='cancelled' " . ($row['status'] == 'cancelled' ? 'selected' : '') . ">Cancelled</option>
                                      </select>
                                    </div>
                                    <div class='col-md-4'>
                                      <label>Device ID</label>
                                      <input type='text' name='device_id' class='form-control' value='{$row['device_id']}' required>
                                    </div>
                                  </div>
                                </div>
                                <div class='modal-footer'>
                                  <input type='submit' class='btn btn-primary' value='Update' name='btnUpdateSchedule'>
                                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>";

                        $i++;
                      }
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

<!-- Add Schedule Modal -->
<div class="modal fade" id="add_schedule" tabindex="-1" role="dialog" aria-hidden="true">
  <form action="../../controller/coordinator/process/save_schedule.php" method="POST">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" style="color: black;">Add Schedule</h3>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="coordinator_id" value="<?php echo $resInfo['user_id']; ?>">
          <input type="hidden" name="college_id" value="<?php echo $resInfo['college_id']; ?>">
          <div class="form-group row">
            <div class="col-md-4">
              <label>Schedule Date</label>
              <input type="date" min="<?php echo date('Y-m-d'); ?>" name="schedule_date" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Start Time</label>
              <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>End Time</label>
              <input type="time" name="end_time" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Schedule Type</label>
              <select name="schedule_type" class="form-control" required>
                <option value="morning">Morning Only</option>
                <option value="afternoon">Afternoon Only</option>
                <option value="both">Morning + Afternoon</option>
              </select>
            </div>
            <div class="col-md-4">
              <label>Status</label>
              <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              <small class="text-muted">Archived is automatic when schedule is past date/time.</small>
            </div>
            <div class="col-md-4">
              <label>Device ID</label>
              <input type="text" name="device_id" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="Save" name="btnSaveSchedule">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>