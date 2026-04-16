<?php
$response = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cmdType = $_POST['command'];
    $id = isset($_POST['finger_id']) ? $_POST['finger_id'] : '';

    $python = "C:\\Users\\Adhara_Reign\\anaconda3\\envs\\Finger\\python.exe";
    $script = "C:\\xampp\\htdocs\\cwts\\app.py";

    if ($cmdType === 'ENROLL') {
        $cmd = 'ENROLL';
    } elseif ($cmdType === 'DELETE' && is_numeric($id)) {
        $cmd = 'DELETE ' . $id;
    } else {
        $response = "Invalid input";
    }

    if (!empty($cmd)) {
        $command = "$python $script " . escapeshellarg($cmd) . " 2>&1";
        $response = shell_exec($command);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Fingerprint Management</title></head>
<body>
    <h2>Fingerprint Commands</h2>
    <form method="POST">
        <select name="command" onchange="document.getElementById('idField').style.display = this.value === 'DELETE' ? 'block' : 'none'">
            <option value="ENROLL">ENROLL (Auto-ID)</option>
            <option value="DELETE">DELETE (by ID)</option>
        </select>
        <div id="idField" style="display:none;">
            <input type="number" name="finger_id" placeholder="Enter Finger ID to Delete" />
        </div>
        <br>
        <button type="submit">Send Command</button>
    </form>

    <?php if (!empty($response)): ?>
        <h3>Response from Arduino:</h3>
        <pre><?php echo htmlspecialchars($response); ?></pre>
    <?php endif; ?>
</body>
</html>
