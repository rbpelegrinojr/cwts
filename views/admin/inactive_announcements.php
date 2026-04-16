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
  </style>
<div class="main_content_iners overly_inners ">
  <div class="container-fluid p-0 ">
    <div class="row">
          <div class="col-12">
              <div class="page_title_box d-flex align-items-center justify-content-between">
                  <div class="page_title_left">
                      <h3 class="f_s_30 f_w_700 text_white">INACTIVE ANNOUNCEMENTS</h3>
                      <ol class="breadcrumb page_bradcam mb-0">
                        <li class="breadcrumb-item"><a href="index">Dashboard </a></li>
                        <li class="breadcrumb-item active">Inactive Announcements</li>
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
          <div >
          <br>
          <?php
            
            $query = mysqli_query($con, "SELECT * FROM announcements_tbl WHERE announcement_status = '0'");
            if ($rows = mysqli_num_rows($query) > 0) {
                
              }else{
                ?>
                <div class="alert alert-warning">
                  <label>No Data Available.</label>
                </div>
                <?php
              }
            ?>
          <div class="">
            <label><b>Total: <?php echo mysqli_num_rows($query); ?></b></label>
          </div>
          <br>
          
          <div >
            <table class="table table-bordered" id="myTable">
              <thead>
                <th class="text-center">#</th>
                <th class="text-center">Announcement</th>
                <th class="text-center">Announcement Created</th>
                <th class="text-center">Action</th>
              </thead>
              <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                  ?>
                  <tr>
                    <td class="text-center"><?php echo $i++; ?></td>
                    <td class="text-center"><?php echo $row['announcement']; ?></td>
                    <td class="text-center"><?php echo $row['date_created']; ?></td>
                    <td class="text-center">
                      N/A
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
  </div>
</div>
<script type="text/javascript">
  function inactive(a_id) {
    if (confirm('Set Announcement as Inactive?')) {
      window.location.href='../../controller/admin/process/save_data.php?btnAnnouncementInactive=1&a_id='+a_id+'';
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

<?php include 'footer.php'; ?>