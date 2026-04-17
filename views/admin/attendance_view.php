<?php include 'header.php'; ?>

<script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var myWindow = window.open('', 'Attendance Report', 'height=600,width=900,scrollbars=yes');
        myWindow.document.write('<html><head><title>Attendance Report</title>');
        myWindow.document.write('<link href="assets/bootstrap.min.css" rel="stylesheet">');
        myWindow.document.write('<style>body{font-family: Arial, Helvetica, sans-serif;} .prints{margin: 20px;} table{width:100%; border-collapse: collapse;} table th, table td{padding:8px; border:1px solid #e2e2e2;} .logo-header{text-align:center; margin-bottom:15px;} .logo-header img{height:80px;}</style>');
        myWindow.document.write('</head><body>');
        myWindow.document.write('<div class="logo-header"><img src="<?php echo htmlspecialchars($resSettings["system_logo"]); ?>" alt="Logo"><h3 style="margin:5px 0 0 0;"><?php echo htmlspecialchars($resSettings["system_title"]); ?></h3><h6 style="margin-top:5px;">Attendance Report</h6></div>');
        myWindow.document.write(data);
        myWindow.document.write('<footer style="position: fixed; bottom:10px; width:100%; text-align: center;">This is a system generated report</footer>');
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
        <div class="row mb-2">
            <div class="col-12">
                <div class="page_title_box d-flex align-items-center justify-content-between">
                    <div class="page_title_left">
                        <h3 class="f_s_30 f_w_700 text_white">Attendance</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Attendance</a></li>
                        </ol>
                    </div>
                    <a href="#" class="white_btn3 btn btn-outline-primary" id="btnPrint" onclick="PrintElem('#myDiv')">Print</a>
                </div>
            </div>
        </div>

        <div class="row">
        <div class="col-lg-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_body">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" name="from_date" 
                                   value="<?= isset($_POST['from_date']) ? $_POST['from_date'] : '' ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" name="to_date" 
                                   value="<?= isset($_POST['to_date']) ? $_POST['to_date'] : '' ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="All">-All Status-</option>
                                <option value="Present" <?= (isset($_POST['status']) && $_POST['status'] == 'Present') ? 'selected' : '' ?>>Present</option>
                                <option value="Late" <?= (isset($_POST['status']) && $_POST['status'] == 'Late') ? 'selected' : '' ?>>Late</option>
                                <option value="Absent" <?= (isset($_POST['status']) && $_POST['status'] == 'Absent') ? 'selected' : '' ?>>Absent</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <input type="submit" name="btnFilter" class="btn btn-info" value="Filter">
                                <a href="attendance_view" class="btn btn-primary">Refresh</a>
                            </div>
                        </div>
                    </div>

                    <?php
                    $where = [];
                    if (isset($_POST['btnFilter'])) {
                        $from_date = $_POST['from_date'];
                        $to_date = $_POST['to_date'];
                        $status = $_POST['status'];

                        // Date range filter
                        if (!empty($from_date) && !empty($to_date)) {
                            $where[] = "DATE(timestamp) BETWEEN '$from_date' AND '$to_date'";
                        } elseif (!empty($from_date)) {
                            $where[] = "DATE(timestamp) >= '$from_date'";
                        } elseif (!empty($to_date)) {
                            $where[] = "DATE(timestamp) <= '$to_date'";
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
                        <div class="alert alert-warning mt-3">
                            <label>No Data Available.</label>
                        </div>
                    <?php } ?>

                    <div class="prints" id="myDiv">
                        <?php if(isset($_POST['btnFilter']) && (!empty($_POST['from_date']) || !empty($_POST['to_date']))): ?>
                            <div class="alert alert-info">
                                <strong>Date Range:</strong> 
                                <?= !empty($_POST['from_date']) ? date('F d, Y', strtotime($_POST['from_date'])) : 'Start' ?> 
                                to 
                                <?= !empty($_POST['to_date']) ? date('F d, Y', strtotime($_POST['to_date'])) : 'End' ?>
                            </div>
                        <?php endif; ?>
                        
                        <div>
                            <label><b>Total: <?php echo count($filtered_rows); ?></b></label>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-dark">
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
                                            <td><?php echo !empty($row['timestamp']) ? date("F d, Y", strtotime($row['timestamp'])) : ''; ?></td>
                                            <td><?php echo !empty($row['am_in']) ? date("h:i A", strtotime($row['am_in'])) : '--'; ?></td>
                                            <td><?php echo !empty($row['am_out']) ? date("h:i A", strtotime($row['am_out'])) : '--'; ?></td>
                                            <td><?php echo !empty($row['pm_in']) ? date("h:i A", strtotime($row['pm_in'])) : '--'; ?></td>
                                            <td><?php echo !empty($row['pm_out']) ? date("h:i A", strtotime($row['pm_out'])) : '--'; ?></td>
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