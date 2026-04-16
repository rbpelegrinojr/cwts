//
//$exePath = 'C:\\xampp\\htdocs\\cwts\\Attendance Files\\Attendance.exe';
// Non-blocking using start
//exec('start "" "' . $exePath . '"');

//header('location: index.php');

<?php
$exePath = 'C:\\xampp\\htdocs\\cwts\\Attendance Files\\Attendance.exe';
pclose(popen('start /B "" "' . $exePath . '"', 'r'));

header('Location: attendance_view.php');
exit;

