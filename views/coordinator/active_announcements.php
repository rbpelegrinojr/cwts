<?php include 'header.php'; ?>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<style>
  #calendar {
    max-width: 100%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    min-height: 600px; /* ensure visible */
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
        <h3 class="f_s_30 f_w_700 text_white">ACTIVE ANNOUNCEMENTS/Events</h3>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="white_card mb_30">
          <div class="white_card_body">

            <?php
              $query = mysqli_query($con, "SELECT * FROM announcements_tbl WHERE announcement_status = '1' ORDER BY announcement_id DESC");
              if (mysqli_num_rows($query) == 0) {
                echo '<div class="alert alert-warning"><label>No Data Available.</label></div>';
              }
            ?>

            <div>
              <label><b>Total: <?php echo mysqli_num_rows($query); ?></b></label>
              <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#add_announcement" style="float: right;">Add Announcement</a>
            </div>

            <br>
            <div id="calendar"></div>

            <script>
              document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                  initialView: 'dayGridMonth',
                  headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                  },
                  events: [
                    <?php
                      mysqli_data_seek($query, 0);
                      while ($row = mysqli_fetch_assoc($query)) {
                        $title = addslashes($row['subject_announcement']);
                        $desc = addslashes($row['announcement']);
                        // format date to ISO
                        $date = date('Y-m-d', strtotime($row['date_created']));
                        echo "{
                          title: '$title',
                          start: '$date',
                          extendedProps: {
                            description: '$desc',
                            id: '{$row['announcement_id']}'
                          }
                        },";
                      }
                    ?>
                  ],
                  eventClick: function(info) {
                    var eventObj = info.event;
                    var modalHtml = `
                      <div class="modal fade" id="view_announcement_modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title">${eventObj.title}</h3>
                              <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                              <label style='font-size: 20px;'>${eventObj.extendedProps.description}</label>
                            </div>
                            <div class="modal-footer">
                              <a href="#" onclick="inactive(${eventObj.extendedProps.id})" class="btn btn-danger">Archive</a>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>`;
                    document.body.insertAdjacentHTML('beforeend', modalHtml);
                    $('#view_announcement_modal').modal('show');
                    $('#view_announcement_modal').on('hidden.bs.modal', function() {
                      this.remove();
                    });
                  }
                });

                calendar.render();
              });
            </script>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Add Announcement Modal -->
<div class="modal fade" id="add_announcement" tabindex="-1" role="dialog" aria-hidden="true">
  <form action="../../controller/admin/process/save_data.php">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" style="color: black;">Add Announcement</h3>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <div class="col-md-12">
              <label>Subject</label>
              <input type="text" name="subject_announcement" class="form-control" required placeholder="Type Here...">
            </div>
            <div class="col-md-12">
              <label>Event Date</label>
              <input type="date" name="date_created" min="<?php echo date('Y-m-d'); ?>" class="form-control" required placeholder="Type Here...">
            </div>
            <div class="col-md-12">
              <label>Announcement</label>
              <textarea class="form-control" placeholder="Type Here..." name="announcement"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="Save" name="btnSaveAnnouncement">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  function inactive(a_id) {
    if (confirm('Set Announcement as Inactive?')) {
      window.location.href='../../controller/admin/process/save_data.php?btnAnnouncementInactive=1&a_id='+a_id;
    }
  }
</script>

<?php include 'footer.php'; ?>
