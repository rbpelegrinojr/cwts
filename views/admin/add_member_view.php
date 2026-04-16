<?php include 'header.php'; ?>
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

		.footer_part{
			background: #6C4632;
		}
		.footer_part .footer_iner.text-center{
			background: #6C4632;
		}
	</style>
<div class="main_content_iners overly_inners ">
	<div class="container-fluid p-0 ">
		<div class="row">
	        <div class="col-12">
	            <div class="page_title_box d-flex align-items-center justify-content-between">
	                <div class="page_title_left">
	                    <h3 class="f_s_30 f_w_700 text_white">ADD WALK IN MEMBER</h3>
	                    <ol class="breadcrumb page_bradcam mb-0">
	                    	<li class="breadcrumb-item"><a href="index">Dashboard </a></li>
	                    	<li class="breadcrumb-item active">Add Walk in Member</li>
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
										<br>
										<h3>ADD MEMBER INFORMATION</h3>
										<form action="../../controller/admin/process/save_data.php" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); padding: 16px;" method="POST">
										  <div class="row">
										  	<div class="col-md-6">
										  		<label>First Name</label>
										  		<input type="text" name="" class="form-control">
										  	</div>
										  	<div class="col-md-6">
										  		<label>Last Name</label>
										  		<input type="text" name="" class="form-control">
										  	</div>
										  </div>
										  <div class="row">
										  	<div class="col-md-6">
										  		<label>Email</label>
										  		<input type="text" name="" class="form-control">
										  	</div>
										  	<div class="col-md-6">
										  		<label>Contact Number</label>
										  		<input type="text" name="" class="form-control">
										  	</div>
										  </div>
										  <br>
										  <div class="row">
										  	<input type="submit" name="btnAddMember" class="btn btn-info col-md-12" value="ADD">
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

	    </div>
	</div>
</div>

<?php include 'footer.php'; ?>