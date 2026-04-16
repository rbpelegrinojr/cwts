<?php include 'header.php'; ?>
<script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head><title>my div</title><style></style>');
        /*optional stylesheet*/ //myWindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        myWindow.document.write('<link href="assets/bootstrap.min.css" rel="stylesheet">');
        myWindow.document.write('<style> .prints{ margin-left: 5%; margin-right: 5%; }</style>')
        myWindow.document.write('</head><body ><center><h3>Event Manager using Biometrics with SMS Notification</h3><br><h6>Attendance</h6></center><br>');
        myWindow.document.write(data);
        myWindow.document.write('<footer style="position: fixed; bottom:20;text-align: center;margin-left:37%;">This is a system generated report</footer>');
        myWindow.document.write('</body></html>');
        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload=function(){ // necessary if the div contain images

            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };
    }
</script>
<!-- <style type="text/css">
	.fots {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  color: white;
  text-align: center;
</style> -->
<form action="reports_view" method="POST">
<div class="main_content_iner overly_inner ">
    <div class="container-fluid p-0 ">

    <div class="row">
        <div class="col-12">
            <div class="page_title_box d-flex align-items-center justify-content-between">
                <div class="page_title_left">
                    <h3 class="f_s_30 f_w_700 text_white">Attendance</h3>
                    <ol class="breadcrumb page_bradcam mb-0">
                    	<li class="breadcrumb-item"><a href="index">Dashboard </a></li>
	                    <li class="breadcrumb-item"><a href="javascript:void(0);">Attendance </a></li>
                    </ol>
                </div>
            <a href="#" class="white_btn3" id="btnPrint" onclick="PrintElem('#myDiv')">Print</a>
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
					<div class="row" style="display: none;">

						<div class="col-md-3">
							<select class="form-control" name="reservation_type_select">
								<option value="All">-All Reservation Type-</option>
							      <?php
							      $qResType = mysqli_query($con, "SELECT * FROM reservation_type_tbl");
							      while ($rResTypes = mysqli_fetch_assoc($qResType)) {
							      	?>
							      	<option value="<?php echo $rResTypes['reservation_type_id']; ?>"><?php echo $rResTypes['reservation_type']; ?></option>
							      	<?php
							      }
							      ?>
							</select>
						</div>

						<div class="col-md-3">
							<select class="form-control" name="month">
								<option value="All">-All Month-</option>
						        <option value="1">January</option>
						        <option value="2">February</option>
						        <option value="3">March</option>
						        <option value="4">April</option>
						        <option value="5">May</option>
						        <option value="6">June</option>
						        <option value="7">July</option>
						        <option value="8">August</option>
						        <option value="9">September</option>
						        <option value="10">October</option>
						        <option value="11">November</option>
						        <option value="12">December</option>
							</select>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="year">
								<option value="All">-All Year-</option>
							      <?php
							      $year_now = date('Y');
							      $add_year = $year_now+20;
							      for ($i=$year_now; $i < $add_year; $i++) { 
							        ?>
							        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							        <?php
							      }
							      ?>
							</select>
						</div>

						<input type="submit" name="btnFilter" class="btn btn-info" value="Filter">&nbsp;
						<a href="" class="btn btn-primary">Refresh</a>
						<?php
						// if (isset($_REQUEST['btnFilter'])) {

						// 	$MONTH = $_REQUEST['month'];
						// 	$YEAR = $_REQUEST['year'];
						// 	$reservation_type = $_REQUEST['reservation_type_select'];

						// 	if ($MONTH == 'All' && $YEAR == 'All' && $reservation_type == 'All') {
								
						// 		$query = mysqli_query($con, "SELECT * FROM reservations_tbl");

						// 	}elseif ($MONTH != 'All' && $reservation_type == 'All' && $YEAR == 'All') {
								
						// 		$query = mysqli_query($con, "SELECT * FROM reservations_tbl WHERE MONTH(reservation_date) = '$MONTH'");

						// 	}elseif ($MONTH == 'All' && $YEAR != 'All' && $reservation_type == 'All') {
								
						// 		$query = mysqli_query($con, "SELECT * FROM reservations_tbl WHERE YEAR(reservation_date) = '$YEAR'");

						// 	}elseif ($MONTH == 'All' && $YEAR == 'All' && $reservation_type != 'All') {
						// 		$query = mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_type = '$reservation_type'");
						// 	}elseif ($MONTH != 'All' && $YEAR != 'All' && $reservation_type != 'All') {
								
						// 		$query = mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_type = '$reservation_type' AND YEAR(reservation_date) = '$YEAR' AND MONTH(reservation_date) = '$MONTH'");

						// 	}

						// } else{
						// 	$query = mysqli_query($con, "SELECT * FROM reservations_tbl");
						// }
						$query = mysqli_query($con, "SELECT * FROM attendance");
						?>
					</div>
					<br>
					<?php
					if ($rows = mysqli_num_rows($query) > 0) {
									
						}else{
							?>
							<div class="alert alert-warning">
								<label>No Data Available.</label>
							</div>
							<?php
						}
					?>
					<div class="prints" id="myDiv">
						<center><h3 style="display: none;" id="title_table"><br>Saint Isidore Parish Online Scheduling Management System <br> <!-- Reports --> <?php if(isset($_REQUEST['btnFilter'])){
							if($_REQUEST['month'] != 'All' && $_REQUEST['year'] == 'All'){
								echo 'of '.date('F', strtotime($_REQUEST['month']));
						}elseif ($_REQUEST['month'] == 'All' && $_REQUEST['year'] != 'All') {
							echo 'of '.$_REQUEST['year'];
						}elseif ($_REQUEST['month'] != 'All' && $_REQUEST['year'] != 'All') {
							echo 'of '.date('F', strtotime($_REQUEST['month'])).' '.$_REQUEST['year'];
						}
					}else{  }?><br></h3></center>
						
					<div class="">
						<label><b>Total: <?php echo mysqli_num_rows($query); ?></b></label>
					</div>
					<br>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<th class="text-center">Student Name</th>
								<th class="text-center">AM-in</th>
								<th class="text-center">AM-out</th>
								<th class="text-center">PM-in</th>
								<th class="text-center">PM-out</th>
								<th class="text-center">Remarks</th>
							</thead>
							<tbody>
								<?php
								$i = 1;
								while ($row = mysqli_fetch_assoc($query)) {
									
									$resMem = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$row['user_id']}'"));

									?>
									<tr class="text-center">
										<td><?php echo $resMem['fname'] . ' ' . $resMem['lname']; ?></td>
										<td><?php echo !empty($row['am_in']) ? date("h:i A", strtotime($row['am_in'])) : ''; ?></td>
										<td><?php echo !empty($row['am_out']) ? date("h:i A", strtotime($row['am_out'])) : ''; ?></td>
										<td><?php echo !empty($row['pm_in']) ? date("h:i A", strtotime($row['pm_in'])) : ''; ?></td>
										<td><?php echo !empty($row['pm_out']) ? date("h:i A", strtotime($row['pm_out'])) : ''; ?></td>
										<td>
										    <?php
										        $fields = [$row['am_in'], $row['am_out'], $row['pm_in'], $row['pm_out']];
										        $emptyCount = 0;

										        foreach ($fields as $field) {
										            if (empty($field)) {
										                $emptyCount++;
										            }
										        }

										        if ($emptyCount === 4) {
										            echo "<b>ABSENT</b>";
										        } elseif ($emptyCount > 0) {
										            echo "<b>LATE</b>";
										        } else {
										            echo "<b>PRESENT</b>"; // Optional
										        }
										    ?>
										</td>
									</tr>
									<?php

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
		<!-- <div class="fots" style="display: none;">
			<h1>This is a system generated report.</h1>
		</div> -->
	</div>
</div>
</form>


<?php include 'footer.php'; ?>