<?php //header('location: active_announcements'); ?>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="calendar/fullcalendar.css" />
<script src="calendar/jquery.min.js"></script>
<script src="calendar/jquery-ui.min.js"></script>
<script src="calendar/moment.min.js"></script>
<script src="calendar/fullcalendar.min.js"></script>

  <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
        left:'prev, next today',
        center:'title',
        right:'month'
    },
    events:
    <?php
    $query = mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_status = '1'");

    $data = array();

    while ($row = mysqli_fetch_array($query)) {
        // $end_date = date_create($row['event_date_end']);
        // date_add($end_date, date_interval_create_from_date_string("1 day"));
        $resType = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservation_type_tbl WHERE reservation_type_id = '{$row['reservation_type']}'"));
        $resMem = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$row['member_id']}'"));
        $data[] = array(
            'id' => $row['reservation_id'],
            'title' => $resType['reservation_type'].'  '.$row['reservation_date'].' @ '.date('h:ia',strtotime($row['reservation_time'])),
            'start' => $row['reservation_date'],
            //'end' => date_format($end_date, 'Y-m-d'),
            'time' => '',
            'desc' => $resMem['fname'].' '.$resMem['lname']
        );
    }
    echo json_encode($data);
    ?>,
    selectable:true,
    selectHelper:true,
    editable:true,
    eventClick:function (event) {
        alert(event.title+' '+event.time+' | '+event.desc);
        //window.location.href='view.php?event_id='+event.id+'&title='+event.title+'';
    }
   });
  });
   
  </script>
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
                                $row1 = mysqli_num_rows(mysqli_query($con, "SELECT * FROM members_tbl WHERE account_status = '1'"));
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

                    <div class="white_card_body" style="display: none;">
                        <form action="pending_accounts_view" method="POST">
                            <div id="calendar" style="height: 0;"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>