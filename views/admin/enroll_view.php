<?php include 'header.php'; ?>
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

    <!-- <form method="POST">
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
    </form> -->
    <style type="text/css">
        .main_content .main_content_iners {
            min-height: 68vh;
            transition: .5s;
            position: relative;
            /*background: #f3f4f3;*/
            margin: 0;
            /*z-index: 22;*/
            border-radius: 0;
            padding: 30px;
        }

        .main_content .main_content_iners.overly_inners::before {
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            height: 160px;
            z-index: -1;
            background: #4aa9ff;
            content: '';
            border-radius: 0;
            left: 0;
        }

        .footer_part{
            background: #4aa9ff;
        }
        .footer_part .footer_iner.text-center{
            background: #4aa9ff;
        }
    </style>
<div class="main_content_iners overly_inners ">
    <div class="container-fluid p-0 ">
        <div class="row">
            <div class="col-12">
                <div class="page_title_box d-flex align-items-center justify-content-between">
                    <div class="page_title_left">
                        <h3 class="f_s_30 f_w_700 text_white">Students</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="index">Dashboard </a></li>
                            <li class="breadcrumb-item active">Students</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row ">

            <div class="col-lg-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <!-- <div class="main-title">
                            
                        </div> -->
                    </div>
                </div>
                <div class="white_card_body">
                <div class="container">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Command Control</h5>

                            <form method="POST">
                                <div class="mb-3">
                                    <label for="commandSelect" class="form-label">Select Command:</label>
                                    <select name="command" id="commandSelect" class="form-control" onchange="toggleIDField()">
                                        <option value="ENROLL">ENROLL</option>
                                        <option value="DELETE">DELETE</option>
                                    </select>
                                </div>

                                <div id="idField" class="mb-3">
                                    <label for="finger_id" class="form-label">Finger ID:</label>
                                    <input type="number" name="finger_id" id="finger_id" class="form-control" min="1" value="<?php echo $member_id; ?>" readonly required>
                                </div>

                                <button type="submit" class="btn btn-success">Send Command</button>
                            </form>
                        </div>
                    </div>
                </div>

    <?php if (!empty($response)): ?>
        <h3>Response:</h3>
        <pre><?php echo htmlspecialchars($response); ?></pre>
    <?php endif; ?>



</div>
            </div>
        </div>

        </div>
    </div>
</div>
  <!--   <h2>Live Fingerprint Scan</h2>
    <button onclick="startScan()">Start Scan</button>
    <div id="scanResult" style="white-space: pre-wrap; margin-top: 10px; background: #f0f0f0; padding: 10px;"></div> -->

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
<?php include 'footer.php'; ?>