<?php include 'header.php';

$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
$det = mysqli_fetch_assoc(mysqli_query($con, "SELECT m.*, c.college_name, c.college_abbreviation, cs.course_name, cs.course_abbreviation
    FROM members_tbl m
    LEFT JOIN colleges c ON m.college_id = c.college_id
    LEFT JOIN courses cs ON m.course_id = cs.course_id
    WHERE m.member_id = '$id'"));

if (!$det) {
    echo '<div class="alert alert-danger" style="margin:30px;">Student not found.</div>';
    include 'footer.php';
    exit;
}
?>

<script type="text/javascript">
function PrintStudentDetails() {
    var printContent = document.getElementById('studentPrintArea').innerHTML;
    var myWindow = window.open('', 'Student Details', 'height=700,width=900,scrollbars=yes');
    myWindow.document.write('<html><head><title>Student Details</title>');
    myWindow.document.write('<link href="assets/bootstrap.min.css" rel="stylesheet">');
    myWindow.document.write('<style>body{font-family: Arial, Helvetica, sans-serif; margin: 20px;} .logo-header{text-align:center; margin-bottom:20px;} .logo-header img{height:80px;} table{width:100%; border-collapse:collapse;} table th, table td{padding:10px; border:1px solid #dee2e6; text-align:left;} .student-photo{text-align:center; margin-bottom:20px;} .student-photo img{max-width:200px; max-height:200px; border:2px solid #ccc; border-radius:8px;}</style>');
    myWindow.document.write('</head><body>');
    myWindow.document.write('<div class="logo-header"><img src="<?php echo htmlspecialchars($resSettings["system_logo"]); ?>" alt="Logo"><h3 style="margin:5px 0 0 0;"><?php echo htmlspecialchars($resSettings["system_title"]); ?></h3><h5 style="margin-top:5px;">Student Information Sheet</h5></div>');
    myWindow.document.write(printContent);
    myWindow.document.write('<footer style="position:fixed; bottom:10px; width:100%; text-align:center; font-size:12px;">This is a system generated report</footer>');
    myWindow.document.write('</body></html>');
    myWindow.document.close();
    myWindow.onload = function(){
        myWindow.focus();
        myWindow.print();
    };
}
</script>

<style>
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
    background: #4aa9ff;
    content: '';
    border-radius: 0;
}
.student-photo img {
    max-width: 200px;
    max-height: 200px;
    border: 3px solid #ccc;
    border-radius: 10px;
    object-fit: cover;
}
</style>

<div class="main_content_iners overly_inners">
    <div class="container-fluid p-0">
        <div class="row mb-2">
            <div class="col-12">
                <div class="page_title_box d-flex align-items-center justify-content-between">
                    <div class="page_title_left">
                        <h3 class="f_s_30 f_w_700 text_white">Student Details</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="members_view">Students</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>
                    <div>
                        <a href="#" class="btn btn-outline-primary" onclick="PrintStudentDetails()"><i class="fa fa-print"></i> Print</a>
                        <a href="members_view" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white_card card_height_100 mb_30">
                    <div class="white_card_body" id="studentPrintArea">

                        <div class="row">
                            <div class="col-md-4 text-center student-photo">
                                <?php if (!empty($det['profile_image'])): ?>
                                    <img src="<?php echo htmlspecialchars($det['profile_image']); ?>" alt="Student Photo" class="img-fluid">
                                <?php else: ?>
                                    <div style="width:200px; height:200px; background:#e9ecef; border:3px solid #ccc; border-radius:10px; display:flex; align-items:center; justify-content:center; margin:0 auto;">
                                        <i class="fa fa-user" style="font-size:80px; color:#adb5bd;"></i>
                                    </div>
                                <?php endif; ?>
                                <h4 class="mt-3"><?php echo htmlspecialchars($det['fname'] . ' ' . $det['mname'] . ' ' . $det['lname']); ?></h4>
                            </div>

                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width:35%; background:#f8f9fa;">First Name</th>
                                        <td><?php echo htmlspecialchars($det['fname']); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">Middle Name</th>
                                        <td><?php echo htmlspecialchars($det['mname']); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">Last Name</th>
                                        <td><?php echo htmlspecialchars($det['lname']); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">Email</th>
                                        <td><?php echo htmlspecialchars($det['email']); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">Contact Number</th>
                                        <td><?php echo htmlspecialchars($det['contact_number']); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">Guardian Name</th>
                                        <td><?php echo htmlspecialchars($det['guardian_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">Guardian Contact Number</th>
                                        <td><?php echo htmlspecialchars($det['guardian_contact_number']); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">College</th>
                                        <td><?php echo htmlspecialchars($det['college_name']); ?> (<?php echo htmlspecialchars($det['college_abbreviation']); ?>)</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">Course</th>
                                        <td><?php echo htmlspecialchars($det['course_name']); ?> (<?php echo htmlspecialchars($det['course_abbreviation']); ?>)</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">Date of Birth</th>
                                        <td><?php echo htmlspecialchars($det['dob']); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">Address</th>
                                        <td><?php echo htmlspecialchars($det['address']); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f8f9fa;">School Year</th>
                                        <td><?php echo htmlspecialchars($det['school_year']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
