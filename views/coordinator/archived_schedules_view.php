<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="../../include/DataTables/datatables.min.css">
<script type="text/javascript" src="../../include/DataTables/datatables.min.js"></script>

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
        background: #6C4632;
        content: '';
        border-radius: 0;
    }
</style>

<div class="main_content_iners overly_inners">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="page_title_box d-flex align-items-center justify-content-between">
                    <div class="page_title_left">
                        <h3 class="f_s_30 f_w_700 text_white">ARCHIVED SCHEDULES</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Archived Schedules</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white_card card_height_100 mb_30">
                    <div class="white_card_body">
                        <?php
                        $coordinator_id = (int)$resInfo['user_id'];
                        $query = mysqli_query($con, "SELECT s.*, c.college_abbreviation
                            FROM schedules_tbl s
                            LEFT JOIN colleges c ON s.college_id = c.college_id
                            WHERE s.status = 'archived' AND s.coordinator_id = '$coordinator_id'
                            ORDER BY s.schedule_date DESC");

                        if (!$query || mysqli_num_rows($query) == 0) {
                            echo '<div class="alert alert-warning"><label>No Archived Schedules.</label></div>';
                        }
                        ?>
                        <div>
                            <label><b>Total: <?php echo ($query ? mysqli_num_rows($query) : 0); ?></b></label>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <th class="text-center">#</th>
                                    <th class="text-center">College</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Start</th>
                                    <th class="text-center">End</th>
                                    <th class="text-center">Status</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if ($query) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr class="text-center">
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo htmlspecialchars($row['college_abbreviation']); ?></td>
                                            <td><?php echo $row['schedule_date']; ?></td>
                                            <td><?php echo $row['start_time']; ?></td>
                                            <td><?php echo $row['end_time']; ?></td>
                                            <td><span class="badge bg-secondary">Archived</span></td>
                                        </tr>
                                    <?php
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

<script type="text/javascript">
$(document).ready(function () {
    $('#myTable').DataTable({ "ordering": false });
});
</script>

<?php include 'footer.php'; ?>
