<?php
$response = "";

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "fingerprint_db";  // <- Change this to your actual DB name

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cmdType = $_POST['command'];
    $id = isset($_POST['finger_id']) ? $_POST['finger_id'] : '';

    $python = "C:\\Users\\Adhara_Reign\\anaconda3\\envs\\Finger\\python.exe";
    $script = "C:\\xampp\\htdocs\\cwts\\app.py";

    if ($cmdType === 'ENROLL') {
        // Get the max ID from DB and increment
        $result = $conn->query("SELECT MAX(id) AS max_id FROM fingerprints");
        $row = $result->fetch_assoc();
        $new_id = $row['max_id'] ? $row['max_id'] + 1 : 1;
        $cmd = 'ENROLL ' . $new_id;
    } elseif ($cmdType === 'DELETE' && is_numeric($id)) {
        $cmd = 'DELETE ' . $id;
    } else {
        $response = "Invalid input";
    }

    if (!empty($cmd)) {
        $command = "$python $script " . escapeshellarg($cmd) . " 2>&1";
        $output = shell_exec($command);
        $response = $output;

        if (strpos($output, 'ENROLL_SUCCESS') !== false) {
            $conn->query("INSERT INTO fingerprints (id) VALUES ($new_id)");
        } elseif (strpos($output, 'DELETE_SUCCESS') !== false) {
            $conn->query("DELETE FROM fingerprints WHERE id = $id");
        }
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
