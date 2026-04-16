<?php
$python = "C:\\Users\\Adhara_Reign\\anaconda3\\envs\\Finger\\python.exe";
$script = "C:\\xampp\\htdocs\\cwts\\app.py";
$cmd = "SCAN";

$command = "$python $script $cmd 2>&1";
$output = shell_exec($command);
echo nl2br(htmlspecialchars($output));
?>
