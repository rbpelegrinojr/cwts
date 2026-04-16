<?php include 'header.php'; ?>
<?php
$r_id = $_REQUEST['r_id'];
$res = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_id = '$r_id'"));
$memRes = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$res['member_id']}'"));
if ($r_id == '') {
	?>
	<script type="text/javascript">
		window.location.href='pendings_view';
	</script>
	<?php
}else{
	
?>
<link rel="stylesheet" type="text/css" href="../../include/DataTables/datatables.min.css">
<script type="text/javascript" src="../../include/DataTables/datatables.min.js"></script>
<!-- <div class="main_content_iner ">
<div class="container-fluid p-0 ">
<div class="row "> -->
	<style type="text/css">
		.main_content .main_content_iners {
		    min-height: 68vh;
		    transition: .5s;
		    position: relative;
		    /*background: #f3f4f3;*/
		    margin: 0;
		    /*z-index: 22;*/
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
		    left: 0;
		}
	</style>
<div class="main_content_iners overly_inners ">
	<div class="container-fluid p-0 ">
		<div class="row">
	        <div class="col-12">
	            <div class="page_title_box d-flex align-items-center justify-content-between">
	                <div class="page_title_left">
	                    <h3 class="f_s_30 f_w_700 text_white">HOLD RESERVATION</h3>
	                    <ol class="breadcrumb page_bradcam mb-0">
	                    	<li class="breadcrumb-item"><a href="index">Dashboard </a></li>
	                    	<li class="breadcrumb-item active">Hold Reservation</li>
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
					<center>
						<div class="form-group col-md-6" style="padding: 0 10px;">
							<h3>Hold Reservation From <?php echo $memRes['fname'].' '.$memRes['lname']; ?></h3>
							<br>
							<form action="../../controller/admin/process/save_data.php" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); padding: 16px;" method="POST">
							  <div class="col-md-12">
							  	<input type="hidden" name="r_id" value="<?php echo $r_id; ?>">
							  	<h5><b>Select Available Date</b></h5>
							  	<input type="date" name="disapprove_new_date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required="">
							  </div>
							  <br>
							  <div class="col-md-12">
							  	<h5><b>Select Available Time</b></h5>
							  	<input type="time" name="disapprove_new_time" class="form-control" required="">
							  </div>
							  <br>
							  <div class="col-md-12">
								<h5><b>Quick Select Reason</b></h5>
								<select class="form-control" id="reasonSelect">
									<option value="">-- Select a Reason --</option>
									<option value="The selected date is unavailable.">The selected date is unavailable.</option>
									<option value="The venue is not available during the chosen time.">The venue is not available during the chosen time.</option>
									<option value="There is a scheduling conflict.">There is a scheduling conflict.</option>
									<option value="Event type does not meet guidelines.">Event type does not meet guidelines.</option>
								</select>
							</div>
							<br>
							  <div class="col-md-12">
							  	<h5><b>Disapprove Reason</b></h5>
							  	<textarea class="form-control" name="disapprove_reason" id="disapprove_reason" required=""></textarea>
							  </div>
							  <br>
							  <div>
							  	<input type="submit" name="btnDeclineRes" class="btn btn-info col-md-4" value="UPDATE">
							  </div>
							</form>
						</div>
					</center>
				</div>
			</div>
		</div>

	    </div>
	</div>
</div>
<script type="text/javascript">
	document.getElementById('reasonSelect').addEventListener('change', function () {
		let selectedReason = this.value;
		document.getElementById('disapprove_reason').value = selectedReason;
	});
</script>

<script type="text/javascript">
	function approveRes(r_id) {
		if (confirm('Approve Reservation?')) {
			window.location.href='../../controller/admin/process/save_data.php?btnApproveRes=1&r_id='+r_id+'&user_id=<?php echo $user_id; ?>';
		}
	}

	function declineRes(r_id) {
		if (confirm('Decline Reservation?')) {
			window.location.href='../../controller/admin/process/save_data.php?btnDeclineRes=1&r_id='+r_id+'&user_id=<?php echo $user_id; ?>';
		}
	}
</script>
<script type="text/javascript">
	$(document).ready( function () {
	    $('#myTable').DataTable({
	    	"ordering": false
	    });
	});
</script>
<?php
}
?>
<?php include 'footer.php'; ?>