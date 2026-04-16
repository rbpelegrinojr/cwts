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
    $query = mysqli_query($con, "SELECT * FROM events_tbl WHERE gender_scope = '{$resSession['gender']}' AND event_status = '1' OR role_scope = '{$resSession['role']}' AND event_status = '1' OR role_scope = 'All' AND event_status = '1' OR gender_scope = 'All' AND event_status = '1'");

    $data = array();

    while ($row = mysqli_fetch_array($query)) {
        $end_date = date_create($row['event_date_end']);
        date_add($end_date, date_interval_create_from_date_string("1 day"));
        $data[] = array(
            'id' => $row['event_id'],
            'title' => $row['event_title'],
            'start' => $row['event_date_start'],
            'end' => date_format($end_date, 'Y-m-d'),
            'time' => date('h:i a',strtotime($row['event_time'])),
            'desc' => $row['event_description']
        );
    }
    echo json_encode($data);
    ?>,
    selectable:true,
    selectHelper:true,
    editable:true,
    eventClick:function (event) {
        alert(event.title+' @ '+event.time+' | '+event.desc);
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
                    <h3 class="f_s_30 f_w_700 text_white">Events</h3>
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
                <div class="white_card_body">
                    <form action="pending_accounts_view" method="POST">
                        <div id="calendar"></div>
                    </form>
                </div>
            </div>
        </div>


    </div>

    </div>
</div>


<?php include 'footer.php'; ?>