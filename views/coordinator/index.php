<?php //header('location: active_announcements'); ?>
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
<div class="main_content_iner overly_inner ">
    <div class="container-fluid p-0 ">

    <div class="row">
        <div class="col-12">
            <div class="page_title_box d-flex align-items-center justify-content-between">
                <div class="page_title_left">
                    <h3 class="f_s_30 f_w_700 text_white">Dashboard</h3>
                    <ol class="breadcrumb page_bradcam mb-0">
                    <!-- <li class="breadcrumb-item"><a href="index">Home </a></li> -->
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


                <div class="row justify-content-center" style="margin-left: 1%; margin-right: 1%;">


                    <div class="col-md-6" style="background-color: #7DB46CFF;">
                        <div class="card mb-3 widget-chart" >
                            <div class="widget-numbers">
                                <?php
                                $row1 = mysqli_num_rows(mysqli_query($con, "SELECT * FROM members_tbl WHERE account_status = '1' AND college_id = '{$resInfo['college_id']}'"));
                                if ($row1 == 0) {
                                    echo "0";
                                }else{
                                    echo $row1;
                                }
                                ?>
                            </div>
                            <div class="widget-subheading">Total Students</div>
                            <div class="widget-description text-info">
                                <!-- <i class="fa fa-ellipsis-h"></i>
                                <span class="ps-1">115.5%</span> -->
                            </div>
                        </div>
                    </div>

                        <div class="col-md-6" style="background-color: #ABD6DFFF">
                            <div class="card mb-3 widget-chart">
                                <div class="widget-numbers">
                                    <?php
                                    $active_date = date('Y-m-d');
                                    $row3 = mysqli_num_rows(mysqli_query($con, "SELECT * FROM announcements_tbl WHERE announcement_status = '1'"));
                                    if ($row3 == 0) {
                                        echo "0";
                                    }else{
                                        echo $row3;
                                    }
                                    ?>
                                </div>
                                <div class="widget-subheading">Announcemnts</div>
                                <div class="widget-description text-info">
                                    <!-- <i class="fa fa-ellipsis-h"></i>
                                    <span class="ps-1">115.5%</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                      $query = mysqli_query($con, "SELECT * FROM announcements_tbl WHERE announcement_status = '1' ORDER BY announcement_id DESC");
                      if (mysqli_num_rows($query) == 0) {
                        echo '<div class="alert alert-warning"><label>No Data Available.</label></div>';
                      }
                    ?>
                    <div class="white_card_body">
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
<?php include 'footer.php'; ?>