<?php
include '../../../include/db.php';
if (isset($_POST['grade_id'])) {
	$grade_id = $_POST['grade_id'];
	$query = mysqli_query($con, "SELECT * FROM teachers_tbl WHERE grade_id = '$grade_id' ");

	while ($row = mysqli_fetch_assoc($query)) {
		$teacher_id = $row['teacher_id'];
        $fname = $row['fname'];
        $mname = $row['mname'];
        $lname = $row['lname'];
        $grade_id = $row['grade_id'];
        $address = $row['address'];
        $contact_number = $row['contact_number'];
        $resG = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM grades_tbl WHERE grade_id = '$grade_id' "));
        $resTeachSection = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM teacher_sections_tbl WHERE teacher_id = '$teacher_id' "));
        $resS = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM sections_tbl WHERE section_id = '{$resTeachSection['section_id']}' "));
		?>
		<tr>
            <td><?php echo $teacher_id; ?></td>
            <td><?php echo $fname; ?></td>
            <td><?php echo $mname; ?></td>
            <td><?php echo $lname; ?></td>
            <td><strong><?php echo $resG['grade_name'].' - '; ?></strong>
                <?php
                
                $resTSect = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM teacher_sections_tbl WHERE teacher_id = '$teacher_id' "));
                if (empty($resTSect['teacher_id'])) {
                    ?>
                     <a href="#" data-toggle="modal" data-target="#section_select_modal<?php echo $teacher_id; ?>"><i class="fa fa-plus"></i></a>
                     <div class="modal fade" id="section_select_modal<?php echo $teacher_id; ?>">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <form action="adminPage_view.php?activity=teachers_view" method="POST">
                                <?php require_once '../../controller/admin/page_settings.php'; ?>
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="col-lg-12 mt-0">
                                            <div class="card">
                                                <div class="card-body">
                                                    <?php $resT = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM teachers_tbl WHERE teacher_id = '$teacher_id' ")); ?>
                                                    <h4 class="header-title">Select Section for Teacher <?php echo $resT['fname']." ".$resT['lname']; ?></h4>
                                                    <div class="form-group">
                                                        <input type="hidden" name="section_teacher_id" value="<?php echo $resT['teacher_id']; ?>">
                                                        <select class="form-control" required="" name="section_id">
                                                            <option value="">-Select Section-</option>
                                                            <?php
                                                            $qTSect = mysqli_query($con, "SELECT * FROM sections_tbl WHERE grade_id = '{$resT['grade_id']}' ");
                                                            while ($rTSect = mysqli_fetch_assoc($qTSect)) {
                                                                ?>
                                                                <option value="<?php echo $rTSect['section_id'] ?>"><?php echo $rTSect['section_name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" name="addTeacherSectionBtn" class="btn btn-primary" value="Select">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ************************************************ -->
                    <?php
                }else{
                    echo $resS['section_name'];
                }
                ?>
            </td>
            <td>
                <?php
                $resTeachSubject = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM teacher_subjects_tbl WHERE teacher_id = '$teacher_id' "));
                if (empty($resTeachSubject['teacher_id'])) {
                    ?>
                    <a href="#" class="text-secondary" data-toggle="modal" data-target="#subject_select_modal<?php echo $teacher_id; ?>"><i class="fa fa-plus"></i> Subjects</a>

                    <div class="modal fade" id="subject_select_modal<?php echo $teacher_id; ?>">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <form action="adminPage_view.php?activity=teachers_view" method="POST">
                                <?php require_once '../../controller/admin/page_settings.php'; ?>
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="col-lg-12 mt-0">
                                            <div class="card">
                                                <div class="card-body">
                                                    <?php $resT = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM teachers_tbl WHERE teacher_id = '$teacher_id' ")); ?>
                                                    <h4 class="header-title">Select Subject for Teacher <?php echo $resT['fname']." ".$resT['lname']; ?></h4>
                                                    <div class="single-table">
                                                        <div class="table-responsive">
                                                            <input type="hidden" name="teacher_subject_id[]" value="<?php echo $resT['teacher_id']; ?>">
                                                            <table class="table text-center">
                                                                <thead class="text-uppercase bg-info">
                                                                    <tr class="text-white">
                                                                        <th scope="col">Select</th>
                                                                        <th scope="col">Subject Name</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $qSec = mysqli_query($con, "SELECT * FROM subjects_tbl");
                                                                    if ($rowsQSec = mysqli_num_rows($qSec) > 0) {
                                                                        # code...
                                                                    }else{
                                                                        ?>
                                                                        <div class="alert alert-warning">No Data Available.</div>
                                                                        <?php
                                                                    }

                                                                    while ($rSub = mysqli_fetch_assoc($qSec)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><input type="checkbox" name="subject_id[]" value="<?php echo $rSub['subject_id']; ?>"></td>
                                                                            <td><?php echo $rSub['subject_name']; ?></td>
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" name="addTeacherSubjectBtn" class="btn btn-primary" value="Select">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <a href="#"><i class="fa fa-eye"></i></a>
                    <?php
                }
                ?>
            </td>
            <td><?php echo $address; ?></td>
            <td><?php echo $contact_number; ?></td>
            <td>
                <ul class="d-flex justify-content-center">
                    <li class="mr-3"><a href="#" class="text-secondary"><i class="fa fa-edit"></i></a></li>
                    <li><a href="#" class="text-danger"><i class="ti-trash"></i></a></li>
                </ul>
            </td>
        </tr>
		<?php
	}

}
?>