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
    min-height: 600px;
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
// AUTO-ARCHIVE PAST ANNOUNCEMENTS
// ----------------------------------------
// If date_created is before today -> archive (announcement_status = 0)
//
// Because date_created is stored as 'YYYY-MM-DD' text, comparing as strings works.
$today = date('Y-m-d');

// Archive everything past date (STRICT: before today only)
mysqli_query($con, "
  UPDATE announcements_tbl
  SET announcement_status = '0'
  WHERE announcement_status = '1'
    AND date_created <> ''
    AND date_created < '$today'
");

// ----------------------------------------
// FILTER VALUE
// ----------------------------------------
$college_filter = isset($_GET['college']) ? (int)$_GET['college'] : 0; // 0 = ALL

// Colleges list (for dropdown + modal)
$colleges = array();
$qColleges = mysqli_query($con, "SELECT college_id, college_abbreviation, college_name FROM colleges ORDER BY college_abbreviation ASC");
if ($qColleges) {
  while ($c = mysqli_fetch_assoc($qColleges)) {
    $colleges[] = $c;
  }
}

// Build query for announcements
$where = "a.announcement_status = '1'";

// Optional: If you ONLY want to show today onwards, keep this (recommended)
$where .= " AND a.date_created >= '$today'";

if ($college_filter > 0) {
  // show only announcements for this college OR ALL announcements
  $where .= " AND (a.college_id = $college_filter OR a.college_id = 0)";
}

$query = mysqli_query($con, "
  SELECT a.*,
         IFNULL(c.college_abbreviation, 'ALL') AS college_abbr
  FROM announcements_tbl a
  LEFT JOIN colleges c ON c.college_id = a.college_id
  WHERE $where
  ORDER BY a.announcement_id DESC
");
?>

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
              if (!$query || mysqli_num_rows($query) == 0) {
                echo '<div class="alert alert-warning"><label>No Data Available.</label></div>';
              }
            ?>

            <div class="row align-items-center">
              <div class="col-md-6">
                <label><b>Total: <?php echo ($query ? mysqli_num_rows($query) : 0); ?></b></label>
              </div>

              <div class="col-md-6 text-right">
                <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#add_announcement">Add Announcement</a>
              </div>
            </div>

            <hr>

            <!-- FILTER -->
            <form method="get" style="max-width: 320px;">
              <label><b>Filter Announcements</b></label>
              <select name="college" class="form-control" onchange="this.form.submit()">
                <option value="0" <?php echo ($college_filter==0?'selected':''); ?>>ALL</option>
                <?php foreach ($colleges as $c): ?>
                  <option value="<?php echo (int)$c['college_id']; ?>" <?php echo ($college_filter==(int)$c['college_id']?'selected':''); ?>>
                    <?php echo htmlspecialchars($c['college_abbreviation']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <small class="text-muted">Note: When filtering a college, it shows that college + ALL announcements.</small>
            </form>

            <br>

            <div id="calendar"></div>

            <?php
              // Build events array
              $events = array();
              if ($query) {
                mysqli_data_seek($query, 0);
                while ($row = mysqli_fetch_assoc($query)) {
                  $events[] = array(
                    'title' => '['.$row['college_abbr'].'] '.$row['subject_announcement'],
                    'start' => date('Y-m-d', strtotime($row['date_created'])),
                    'extendedProps' => array(
                      'description' => $row['announcement'],
                      'id'          => $row['announcement_id'],
                      'college'     => $row['college_abbr']
                    )
                  );
                }
              }
            ?>

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
      events: <?php echo json_encode($events); ?>,
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
                  <div style="font-size:14px; margin-bottom:8px;">
                    <b>For:</b> ${eventObj.extendedProps.college}
                  </div>
                  <label style='font-size: 18px; white-space: pre-line;'>${eventObj.extendedProps.description}</label>
                </div>
                <div class="modal-footer">
                  <a href="#" onclick="cancelEvent(${eventObj.extendedProps.id})" class="btn btn-warning">Cancel Event</a>
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

  function inactive(a_id) {
    if (confirm('Set Announcement as Inactive?')) {
      window.location.href='../../controller/admin/process/save_data.php?btnAnnouncementInactive=1&a_id='+a_id;
    }
  }

  function cancelEvent(a_id) {
    if (confirm('Are you sure you want to cancel this event/announcement?')) {
      window.location.href='../../controller/admin/process/save_data.php?btnCancelAnnouncement=1&a_id='+a_id;
    }
  }
</script>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Announcement Modal -->
<div class="modal fade" id="add_announcement" tabindex="-1" role="dialog" aria-hidden="true">
  <form action="../../controller/admin/process/save_data.php" id="announcementForm" method="post">
    <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
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

            <div class="col-md-12 mt-2">
              <label>Event Date</label>
              <input type="date" name="date_created" min="<?php echo date('Y-m-d'); ?>" class="form-control" required>
            </div>

            <div class="col-md-12 mt-2">
              <label>Announcement For</label>
              <select name="college_id" class="form-control" required>
                <option value="0">ALL</option>
                <?php foreach ($colleges as $c): ?>
                  <option value="<?php echo (int)$c['college_id']; ?>">
                    <?php echo htmlspecialchars($c['college_abbreviation']); ?> - <?php echo htmlspecialchars($c['college_name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-12 mt-3">
              <label>What</label>
              <input type="text" id="what_input" class="form-control" placeholder="e.g. General Assembly">
            </div>

            <div class="col-md-12 mt-2">
              <label>Where</label>
              <input type="text" id="where_input" class="form-control" placeholder="e.g. School Gym">
            </div>

            <div class="col-md-12 mt-2">
              <label>When</label>
              <input type="text" id="when_input" class="form-control" placeholder="e.g. Dec 15, 2025 – 2:00 PM">
            </div>

            <div class="col-md-12 mt-3">
              <label>Additional Details (optional)</label>
              <textarea id="details_input" class="form-control" placeholder="Other info..."></textarea>
            </div>

            <div class="col-md-12 mt-3" style="display:none;">
              <textarea class="form-control" name="announcement" id="announcement_field"></textarea>
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('announcementForm');
    if (!form) return;

    form.addEventListener('submit', function () {
      var what  = document.getElementById('what_input').value.trim();
      var where = document.getElementById('where_input').value.trim();
      var when  = document.getElementById('when_input').value.trim();
      var details = document.getElementById('details_input').value.trim();

      var lines = [];
      if (what)  lines.push('What: '  + what);
      if (where) lines.push('Where: ' + where);
      if (when)  lines.push('When: '  + when);
      if (details) {
        lines.push('');
        lines.push(details);
      }

      document.getElementById('announcement_field').value = lines.join('\n');
    });
  });
</script>

<?php include 'footer.php'; ?>