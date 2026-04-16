<?php

$member_id = $_REQUEST['member_id'];

$response = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["command"])) {
    $python = "C:\\Users\\Adhara_Reign\\anaconda3\\envs\\Finger\\python.exe";
    $script = "C:\\xampp\\htdocs\\cwts\\app.py";
    $command = $_POST["command"];

    $id = isset($_POST["finger_id"]) ? intval($_POST["finger_id"]) : 1;

    if ($command === "ENROLL") {
        $fullCommand = "$python $script ENROLL $id 2>&1";
    } else if ($command === "DELETE") {
        $fullCommand = "$python $script DELETE $id 2>&1";
    }

    $response = shell_exec($fullCommand);

    // ✅ If "Enrollment successful" is in the response, insert into the database
    if ($command === "ENROLL" && strpos($response, "Enrollment successful") !== false) {
        // Replace with your DB credentials
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "cwts";  // Replace with your DB name

        $conn = new mysqli($host, $user, $password, $database);

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO fingerprints (id, created_at) VALUES (?, NOW())");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fingerprint Management</title>
</head>
<body>
    <h2>Fingerprint Command Interface</h2>
    <form method="POST">
        <label>Select Command:</label><br>
        <select name="command" id="commandSelect" onchange="toggleIDField()">
            <option value="ENROLL">ENROLL</option>
            <option value="DELETE">DELETE</option>
        </select><br><br>

        <div id="idField">
            <label>Finger ID:</label><br>
            <input type="number" name="finger_id" min="1" value="<?php echo $member_id; ?>" readonly required><br><br>
        </div>

        <input type="submit" value="Send Command">
    </form>

    <?php if (!empty($response)): ?>
        <h3>Arduino Response:</h3>
        <pre><?php echo htmlspecialchars($response); ?></pre>
    <?php endif; ?>

    <hr>
    <h2>Live Fingerprint Scan</h2>
    <button onclick="startScan()">Start Scan</button>
    <div id="scanResult" style="white-space: pre-wrap; margin-top: 10px; background: #f0f0f0; padding: 10px;"></div>

    <script>
        function toggleIDField() {
            var command = document.getElementById("commandSelect").value;
            document.getElementById("idField").style.display = (command === "DELETE" || command === "ENROLL") ? "block" : "none";
        }

        function startScan() {
            document.getElementById("scanResult").innerText = "Scanning...";
            fetch("test4.php")
                .then(response => response.text())
                .then(data => {
                    document.getElementById("scanResult").innerText = data;
                })
                .catch(err => {
                    document.getElementById("scanResult").innerText = "Error: " + err;
                });
        }

        toggleIDField(); // Ensure correct display on page load
    </script>
</body>
</html>
