<?php include 'header.php'; ?>

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
              $query = mysqli_query($con, "SELECT * FROM schedules_tbl ORDER BY schedule_date DESC");
              if (mysqli_num_rows($query) == 0) {
                echo '<div class="alert alert-warning"><label>No Schedules Available.</label></div>';
              }
            ?>

            <div>
              <label><b>Total: <?php echo mysqli_num_rows($query); ?></b></label>
              <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#add_schedule" style="float: right;">+ Add Schedule</a>
            </div>

            <br>
            <div id="schedule_table" class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Coordinator ID</th>
                    <th>College ID</th>
                    <th>Date</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th>Device ID</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i=1;
                    mysqli_data_seek($query, 0);
                    while ($row = mysqli_fetch_assoc($query)) {
                      echo "<tr>
                        <td>{$i}</td>
                        <td>{$row['coordinator_id']}</td>
                        <td>{$row['college_id']}</td>
                        <td>{$row['schedule_date']}</td>
                        <td>{$row['start_time']}</td>
                        <td>{$row['end_time']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['device_id']}</td>
                      </tr>";
                      $i++;
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
  <form action="../../controller/admin/process/save_schedule.php" method="POST">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" style="color: black;">Add Schedule</h3>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <div class="col-md-4">
              <label>Coordinator ID</label>
              <input type="text" name="coordinator_id" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>College ID</label>
              <input type="text" name="college_id" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label>Schedule Date</label>
              <input type="date" name="schedule_date" class="form-control" required>
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
