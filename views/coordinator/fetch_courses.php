<?php
include '../../include/db.php';

if(isset($_POST['college_id'])){
    $college_id = mysqli_real_escape_string($con, $_POST['college_id']);
    $query = mysqli_query($con, "SELECT * FROM courses WHERE college_id='$college_id'");

    echo '<option value="">Select Course</option>';
    while($row = mysqli_fetch_assoc($query)){
        echo "<option value='{$row['course_id']}'>{$row['course_name']}</option>";
    }
}
?>
