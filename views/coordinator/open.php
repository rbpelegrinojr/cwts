//
//$exePath = 'C:\\xampp\\htdocs\\cwts\\Attendance Files\\Register.exe';
// Non-blocking using start
//exec('start "" "' . $exePath . '"');

//header('location: index.php');

<?php
$exePath = 'C:\\xampp\\htdocs\\cwts\\Attendance Files\\Register.exe';
pclose(popen('start /B "" "' . $exePath . '"', 'r'));

header('Location: members_view.php');
exit;
