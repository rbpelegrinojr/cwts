<?php
include '../../include/db.php';
date_default_timezone_set('Asia/Manila');

// ✅ SMS API Function
function sendSMS($apiKey, $number, $message) {
    $sms_api = "https://lintechsms.thesissystems.link";

    $data = http_build_query(array(
        'api_key' => $apiKey,
        'num' => $number,
        'msg' => $message
    ));

    $opts = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => $data,
            'timeout' => 10
        )
    );

    $context = stream_context_create($opts);
    $response = @file_get_contents($sms_api, false, $context);
    return ($response !== FALSE);
}

// ✅ API Key
$apiKey = "Baho_ka_buli"; // Replace with your actual API key

// ✅ Get unsent SMS (status = 1)
$q = mysqli_query($con, "SELECT sms_id, contact_number, sms_content FROM sms_tbl WHERE sms_status = 1 LIMIT 10");

if (mysqli_num_rows($q) > 0) {
    while ($row = mysqli_fetch_assoc($q)) {
        $sms_id = $row['sms_id'];
        $number = $row['contact_number'];
        $message = $row['sms_content'];

        $sent = sendSMS($apiKey, $number, $message);

        if ($sent) {
            // ✅ Mark as sent (status = 0)
            mysqli_query($con, "UPDATE sms_tbl SET sms_status = 0, date_sent = NOW() WHERE sms_id = '$sms_id'");
        }
    }

    echo "Sent";
} else {
    echo "NoPending";
}
?>
