<?php include 'header.php'; ?>
<script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head><title>Attendance Report</title>');
        myWindow.document.write('<link href="assets/bootstrap.min.css" rel="stylesheet">');
        myWindow.document.write('<style>.prints{margin-left:5%;margin-right:5%;} .logo-header{text-align:center; margin-bottom:15px;} .logo-header img{height:80px;}</style>');
        myWindow.document.write('</head><body>');
        myWindow.document.write('<div class="logo-header"><img src="<?php echo htmlspecialchars($resSettings["system_logo"]); ?>" alt="Logo"><h3 style="margin:5px 0 0 0;"><?php echo htmlspecialchars($resSettings["system_title"]); ?></h3><h6 style="margin-top:5px;">Attendance Report</h6></div>');
        myWindow.document.write(data);
        myWindow.document.write('<footer style="position: fixed; bottom:20;text-align: center;margin-left:37%;">This is a system generated report</footer>');
        myWindow.document.write('</body></html>');
        myWindow.document.close();

        myWindow.onload = function(){
            myWindow.focus();
            myWindow.print();
            myWindow.close();
        };
    }
</script>

<form action="attendance_view" method="POST">
<div class="main_content_iner overly_inner">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="page_title_box d-flex align-items-center justify-content-between">
                    <div class="page_title_left">
                        <h3 class="f_s_30 f_w_700 text_white">Attendance Reports</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Attendance Reports</a></li>
                        </ol>
                    </div>
                    <a href="#" class="white_btn3" id="btnPrint" onclick="PrintElem('#myDiv')">Print</a>
                </div>
            </div>
        </div>

        <div class="row">
        <div class="col-lg-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_body">
                    <div class="row">
                        <!-- Month filter -->
                        <div class="col-md-3">
                            <select class="form-control" name="month">
                                <option value="All">-All Month-</option>
                                <?php 
                                for ($i=1; $i<=12; $i++) {
                                    $monthName = date("F", mktime(0, 0, 0, $i, 1));
                                    echo "<option value='$i'>$monthName</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Year filter -->
                        <div class="col-md-3">
                            <select class="form-control" name="year">
                                <option value="All">-All Year-</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <?php
                                // $year_now = date('Y');
                                // $add_year = $year_now + 20;
                                // for ($i=$year_now; $i < $add_year; $i++) { 
                                //     echo "<option value='$i'>$i</option>";
                                // }
                                ?>
                            </select>
                        </div>

                        <!-- Week filter -->
                        <div class="col-md-3">
                            <select class="form-control" name="week">
                                <option value="All">-All Week-</option>
                                <?php
                                for ($i=1; $i<=52; $i++) {
                                    echo "<option value='$i'>Week $i</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Status filter -->
                        <div class="col-md-3">
                            <select class="form-control" name="status">
                                <option value="All">-All Status-</option>
                                <option value="Present">Present</option>
                                <option value="Late">Late</option>
                                <option value="Absent">Absent</option>
                            </select>
                        </div>
                    </div>

                    <br>
                    <input type="submit" name="btnFilter" class="btn btn-info" value="Filter">&nbsp;
                    <a href="attendance_view" class="btn btn-primary">Refresh</a>
                    <br><br>

                    <?php
                    // Build filter conditions
                    $where = [];
                    if (isset($_POST['btnFilter'])) {
                        $month  = $_POST['month'];
                        $year   = $_POST['year'];
                        $week   = $_POST['week'];

                        if ($month != "All") {
                            $where[] = "MONTH(timestamp) = '$month'";
                        }
                        if ($year != "All") {
                            $where[] = "YEAR(timestamp) = '$year'";
                        }
                        if ($week != "All") {
                            $where[] = "WEEK(timestamp, 1) = '$week'";
                        }
                    }

                    $sql = "SELECT * FROM attendance";
                    if (!empty($where)) {
                        $sql .= " WHERE " . implode(" AND ", $where);
                    }
                    $query = mysqli_query($con, $sql);

                    $filtered_rows = [];
                    if ($query && mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            $fields = [$row['am_in'], $row['am_out'], $row['pm_in'], $row['pm_out']];
                            $emptyCount = 0;
                            foreach ($fields as $field) {
                                if (empty($field)) $emptyCount++;
                            }

                            if ($emptyCount === 4) {
                                $remarks = "Absent";
                            } elseif ($emptyCount > 0) {
                                $remarks = "Late";
                            } else {
                                $remarks = "Present";
                            }

                            if (!isset($_POST['status']) || $_POST['status'] == "All" || $_POST['status'] == $remarks) {
                                $row['remarks'] = $remarks;
                                $filtered_rows[] = $row;
                            }
                        }
                    }
                    ?>

                    <?php if (empty($filtered_rows)) { ?>
                        <div class="alert alert-warning">
                            <label>No Data Available.</label>
                        </div>
                    <?php } ?>

                    <div class="prints" id="myDiv">
                        <div>
                            <label><b>Total: <?php echo count($filtered_rows); ?></b></label>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th class="text-center">Student Name</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">AM-in</th>
                                    <th class="text-center">AM-out</th>
                                    <th class="text-center">PM-in</th>
                                    <th class="text-center">PM-out</th>
                                    <th class="text-center">Remarks</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($filtered_rows as $row) {
                                        $resMem = mysqli_fetch_assoc(
                                            mysqli_query($con, "SELECT fname, lname FROM members_tbl WHERE member_id = '{$row['user_id']}'")
                                        );
                                    ?>
                                        <tr class="text-center">
                                            <td><?php echo $resMem['fname'] . ' ' . $resMem['lname']; ?></td>
                                            <td><?php echo !empty($row['timestamp']) ? date("Y-m-d", strtotime($row['timestamp'])) : ''; ?></td>
                                            <td>
                                                <?php echo !empty($row['am_in']) ? date("h:i A", strtotime($row['am_in'])) : '--'; ?>
                                            </td>
                                            <td>
                                                <?php echo !empty($row['am_out']) ? date("h:i A", strtotime($row['am_out'])) : '--'; ?>
                                            </td>
                                            <td>
                                                <?php echo !empty($row['pm_in']) ? date("h:i A", strtotime($row['pm_in'])) : '--'; ?>
                                            </td>
                                            <td>
                                                <?php echo !empty($row['pm_out']) ? date("h:i A", strtotime($row['pm_out'])) : '--'; ?>
                                            </td>
                                            <td><b><?php echo $row['remarks']; ?></b></td>

                                        </tr>
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
</div>
</form>

<?php include 'footer.php'; ?>
