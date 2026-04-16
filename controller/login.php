<?php
include '../include/db.php';
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_POST['adminLogin'])) {

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($username === '' || $password === '') {
        echo "empty";
        exit;
    }

    // Basic escaping to avoid SQL break (you should move to prepared statements later)
    $username_esc = mysqli_real_escape_string($con, $username);
    $password_esc = mysqli_real_escape_string($con, $password);

    // Identify client
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
    $ip_esc = mysqli_real_escape_string($con, $ip);

    // Ensure row exists for this username+ip
    $now = date('Y-m-d H:i:s');

    $qAttempt = mysqli_query($con, "
        SELECT attempt_count, locked_until
        FROM login_attempts_tbl
        WHERE username = '$username_esc' AND ip_address = '$ip_esc'
        LIMIT 1
    ");

    if (!$qAttempt || mysqli_num_rows($qAttempt) == 0) {
        // create entry
        mysqli_query($con, "
            INSERT INTO login_attempts_tbl (username, ip_address, attempt_count, locked_until, last_attempt)
            VALUES ('$username_esc', '$ip_esc', 0, NULL, '$now')
        ");

        $attempt_count = 0;
        $locked_until = null;
    } else {
        $rowAttempt = mysqli_fetch_assoc($qAttempt);
        $attempt_count = (int)$rowAttempt['attempt_count'];
        $locked_until = $rowAttempt['locked_until'];
    }

    // Check lock
    if (!empty($locked_until)) {
        $locked_ts = strtotime($locked_until);
        $now_ts = time();

        if ($locked_ts !== false && $now_ts < $locked_ts) {
            // still locked
            $remaining = $locked_ts - $now_ts; // seconds
            echo "locked|" . $remaining;
            exit;
        } else {
            // lock expired -> reset
            mysqli_query($con, "
                UPDATE login_attempts_tbl
                SET attempt_count = 0, locked_until = NULL, last_attempt = '$now'
                WHERE username = '$username_esc' AND ip_address = '$ip_esc'
            ");
            $attempt_count = 0;
        }
    }

    // Authenticate user
    $resQ = mysqli_query($con, "
        SELECT * FROM users_tbl
        WHERE username = '$username_esc' AND password = '$password_esc'
        LIMIT 1
    ");

    $res = ($resQ && mysqli_num_rows($resQ) == 1) ? mysqli_fetch_assoc($resQ) : null;

    if ($res) {
        // SUCCESS: reset attempts
        mysqli_query($con, "
            UPDATE login_attempts_tbl
            SET attempt_count = 0, locked_until = NULL, last_attempt = '$now'
            WHERE username = '$username_esc' AND ip_address = '$ip_esc'
        ");

        if ($res['user_type'] == '1') {
            $_SESSION['uid'] = $res['user_id'];
            $_SESSION['username'] = $res['username'];
            echo "Login Admin";
            exit;
        } elseif ($res['user_type'] == '2') {
            $_SESSION['uid'] = $res['user_id'];
            $_SESSION['username'] = $res['username'];
            echo "Login Secretary";
            exit;
        } else {
            // If you have account verification logic, keep your own rule here
            echo "denied";
            exit;
        }
    }

    // FAILED LOGIN: increment attempts
    $attempt_count++;

    if ($attempt_count >= 3) {
        // Lock for 5 minutes
        $locked_until_new = date('Y-m-d H:i:s', time() + (5 * 60));

        mysqli_query($con, "
            UPDATE login_attempts_tbl
            SET attempt_count = $attempt_count,
                locked_until = '$locked_until_new',
                last_attempt = '$now'
            WHERE username = '$username_esc' AND ip_address = '$ip_esc'
        ");

        echo "locked|" . (5 * 60);
        exit;
    } else {
        mysqli_query($con, "
            UPDATE login_attempts_tbl
            SET attempt_count = $attempt_count,
                last_attempt = '$now'
            WHERE username = '$username_esc' AND ip_address = '$ip_esc'
        ");

        echo "Error";
        exit;
    }
}elseif (isset($_POST['btnUserLogin'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if ($username != '' && $password != '') {
		
		$res = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE username = '$username' AND password = '$password'"));

		if ($res['username'] == $username && $res['password'] == $password) {
			
			if ($res['account_status'] == '0') {
				$_SESSION['member_id'] = $res['member_id'];
				$_SESSION['username'] = $res['username'];

				$log_date = date('Y-m-d');
				$log_time = date('h:i a');

				$queryLog = mysqli_query($con, "INSERT INTO logs_tbl (member_id, action, log_date, log_time) VALUES ('{$res['member_id']}', 'Logged In', '$log_date', '$log_time')");

				if ($queryLog) {
					echo "login";
				}
				
			}elseif($res['account_status'] == '1'){
				echo "denied";
			}

		}else{
			echo "wrong";
		}

	}else{
		echo "empty";
	}

}elseif (isset($_POST['coordinatorBtn'])) {

    date_default_timezone_set('Asia/Manila');

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($username === '' || $password === '') {
        echo "empty";
        exit;
    }

    $username_esc = mysqli_real_escape_string($con, $username);
    $password_esc = mysqli_real_escape_string($con, $password);

    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
    $ip_esc = mysqli_real_escape_string($con, $ip);

    $now = date('Y-m-d H:i:s');

    // Ensure row exists for this username+ip
    $qAttempt = mysqli_query($con, "
        SELECT attempt_count, locked_until
        FROM login_attempts_tbl
        WHERE username = '$username_esc' AND ip_address = '$ip_esc'
        LIMIT 1
    ");

    if (!$qAttempt || mysqli_num_rows($qAttempt) == 0) {
        mysqli_query($con, "
            INSERT INTO login_attempts_tbl (username, ip_address, attempt_count, locked_until, last_attempt)
            VALUES ('$username_esc', '$ip_esc', 0, NULL, '$now')
        ");
        $attempt_count = 0;
        $locked_until = null;
    } else {
        $rowAttempt = mysqli_fetch_assoc($qAttempt);
        $attempt_count = (int)$rowAttempt['attempt_count'];
        $locked_until = $rowAttempt['locked_until'];
    }

    // Check lock
    if (!empty($locked_until)) {
        $locked_ts = strtotime($locked_until);
        $now_ts = time();

        if ($locked_ts !== false && $now_ts < $locked_ts) {
            $remaining = $locked_ts - $now_ts;
            echo "locked|" . $remaining;
            exit;
        } else {
            // lock expired -> reset
            mysqli_query($con, "
                UPDATE login_attempts_tbl
                SET attempt_count = 0, locked_until = NULL, last_attempt = '$now'
                WHERE username = '$username_esc' AND ip_address = '$ip_esc'
            ");
            $attempt_count = 0;
        }
    }

    // Authenticate
    $qUser = mysqli_query($con, "
        SELECT * FROM users_tbl
        WHERE username = '$username_esc' AND password = '$password_esc'
        LIMIT 1
    ");

    if ($qUser && mysqli_num_rows($qUser) == 1) {
        $res = mysqli_fetch_assoc($qUser);

        // Deny admin user_type 1
        if ($res['user_type'] == '1') {
            echo "denied";
            exit;
        }

        // SUCCESS: reset attempts
        mysqli_query($con, "
            UPDATE login_attempts_tbl
            SET attempt_count = 0, locked_until = NULL, last_attempt = '$now'
            WHERE username = '$username_esc' AND ip_address = '$ip_esc'
        ");

        $_SESSION['uid'] = $res['user_id'];
        $_SESSION['username'] = $res['username'];

        echo "Login";
        exit;
    }

    // FAILED: increment attempts
    $attempt_count++;

    if ($attempt_count >= 3) {
        $locked_until_new = date('Y-m-d H:i:s', time() + (5 * 60));

        mysqli_query($con, "
            UPDATE login_attempts_tbl
            SET attempt_count = $attempt_count,
                locked_until = '$locked_until_new',
                last_attempt = '$now'
            WHERE username = '$username_esc' AND ip_address = '$ip_esc'
        ");

        echo "locked|" . (5 * 60);
        exit;
    } else {
        mysqli_query($con, "
            UPDATE login_attempts_tbl
            SET attempt_count = $attempt_count,
                last_attempt = '$now'
            WHERE username = '$username_esc' AND ip_address = '$ip_esc'
        ");

        echo "Error";
        exit;
    }
}
?>