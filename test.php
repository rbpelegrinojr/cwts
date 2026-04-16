<?php
$response = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cmd = escapeshellarg($_POST['command']);

    // Full path to Anaconda Python in your 'Finger' environment
    $python = "C:\\Users\\Adhara_Reign\\anaconda3\\envs\\Finger\\python.exe";
    $script = "C:\\xampp\\htdocs\\cwts\\app.py";

    $command = "$python $script $cmd";
    $response = shell_exec($command);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Command to Arduino</title>
</head>
<body>
    <h1>Send Command to Arduino via PHP</h1>
    <form method="POST">
        <select name="command">
            <option value="ENROLL">ENROLL</option>
            <option value="DELETE">DELETE</option>
        </select>
        <button type="submit">Send</button>
    </form>

    <?php if ($response): ?>
        <p><strong>Arduino Response:</strong> <?= htmlspecialchars($response) ?></p>
    <?php endif; ?>
</body>
</html>
