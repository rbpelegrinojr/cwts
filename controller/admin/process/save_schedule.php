<?php
include '../../../include/db.php'; // adjust path if needed

if (isset($_POST['btnSaveSchedule'])) {
    $coordinator_id = mysqli_real_escape_string($con, $_POST['coordinator_id']);
    $college_id     = mysqli_real_escape_string($con, $_POST['college_id']);
    $schedule_date  = mysqli_real_escape_string($con, $_POST['schedule_date']);
    $start_time     = mysqli_real_escape_string($con, $_POST['start_time']);
    $end_time       = mysqli_real_escape_string($con, $_POST['end_time']);
    $status         = mysqli_real_escape_string($con, $_POST['status']);
    $device_id      = mysqli_real_escape_string($con, $_POST['device_id']);
    $schedule_type  = mysqli_real_escape_string($con, $_POST['schedule_type']);

    $query = "INSERT INTO schedules_tbl 
    (coordinator_id, college_id, schedule_date, start_time, end_time, status, device_id, schedule_type) 
    VALUES ('$coordinator_id', '$college_id', '$schedule_date', '$start_time', '$end_time', '$status', '$device_id', '$schedule_type')";

    
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Schedule saved successfully!'); window.location='../../../views/admin/schedules_view.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
}
?>
