<?php
// include 'db.php';
$today = date('Y-m-d');

// Update schedules that are already past today
$sql = "
    UPDATE schedules_tbl 
    SET status = 'inactive', updated_at = NOW()
    WHERE status = 'active' 
      AND schedule_date < ?
";

if ($stmt = mysqli_prepare($con, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $today);
    mysqli_stmt_execute($stmt);
    $affected_rows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    //echo "$affected_rows schedule(s) updated to inactive.";
} else {
    //echo "Failed to prepare statement.";
}
?>