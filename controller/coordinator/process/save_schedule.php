<?php
include '../../../include/db.php'; // adjust path if needed

// if (isset($_POST['btnSaveSchedule'])) {
//     $coordinator_id = mysqli_real_escape_string($con, $_POST['coordinator_id']);
//     $college_id     = mysqli_real_escape_string($con, $_POST['college_id']);
//     $schedule_date  = mysqli_real_escape_string($con, $_POST['schedule_date']);
//     $start_time     = mysqli_real_escape_string($con, $_POST['start_time']);
//     $end_time       = mysqli_real_escape_string($con, $_POST['end_time']);
//     $status         = mysqli_real_escape_string($con, $_POST['status']);
//     $device_id      = mysqli_real_escape_string($con, $_POST['device_id']);
//     $schedule_type  = mysqli_real_escape_string($con, $_POST['schedule_type']);

//     $query = "INSERT INTO schedules_tbl 
//     (coordinator_id, college_id, schedule_date, start_time, end_time, status, device_id, schedule_type) 
//     VALUES ('$coordinator_id', '$college_id', '$schedule_date', '$start_time', '$end_time', '$status', '$device_id', '$schedule_type')";

    
//     if (mysqli_query($con, $query)) {
//         echo "<script>alert('Schedule saved successfully!'); window.location='../../../views/coordinator/schedules_view.php';</script>";
//     } else {
//         echo "<script>alert('Error: " . mysqli_error($con) . "'); window.history.back();</script>";
//     }
// }

// ------------------------------
// ADD / SAVE SCHEDULE
// ------------------------------
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
        echo "<script>alert('Schedule saved successfully!'); window.location='../../../views/coordinator/schedules_view.php';</script>";
    } else {
        echo "<script>alert('Error saving schedule: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
}



// ------------------------------
// UPDATE SCHEDULE
// ------------------------------
elseif (isset($_POST['btnUpdateSchedule'])) {
    $schedule_id   = mysqli_real_escape_string($con, $_POST['schedule_id']);
    $schedule_date = mysqli_real_escape_string($con, $_POST['schedule_date']);
    $start_time    = mysqli_real_escape_string($con, $_POST['start_time']);
    $end_time      = mysqli_real_escape_string($con, $_POST['end_time']);
    $status        = mysqli_real_escape_string($con, $_POST['status']);
    $device_id     = mysqli_real_escape_string($con, $_POST['device_id']);

    $query = "UPDATE schedules_tbl 
              SET schedule_date='$schedule_date',
                  start_time='$start_time',
                  end_time='$end_time',
                  status='$status',
                  device_id='$device_id'
              WHERE schedule_id='$schedule_id'";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Schedule updated successfully!'); window.location='../../../views/coordinator/schedules_view.php';</script>";
    } else {
        echo "<script>alert('Error updating schedule: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
}



// ------------------------------
// DELETE SCHEDULE
// ------------------------------
elseif (isset($_GET['delete_id'])) {
    $schedule_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $query = "DELETE FROM schedules_tbl WHERE schedule_id='$schedule_id'";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Schedule deleted successfully!'); window.location='../../../views/coordinator/schedules_view.php';</script>";
    } else {
        echo "<script>alert('Error deleting schedule: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
}



// ------------------------------
// CANCEL SCHEDULE
// ------------------------------
elseif (isset($_GET['cancel_id'])) {
    $schedule_id = mysqli_real_escape_string($con, $_GET['cancel_id']);
    $query = "UPDATE schedules_tbl SET status='Cancelled' WHERE schedule_id='$schedule_id'";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Schedule cancelled successfully!'); window.location='../../../views/coordinator/schedules_view.php';</script>";
    } else {
        echo "<script>alert('Error cancelling schedule: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
}

?>