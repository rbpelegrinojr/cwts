<?php
include '../../../include/db.php';
// if (isset($_REQUEST['btnDelEvent'])) {
// 	$query = mysqli_query($con, "DELETE FROM events_tbl WHERE event_id = '{$_REQUEST['e_id']}'");
// 	if ($query) {
// 		?>
		<script type="text/javascript">
// 			window.location.href='../../../views/admin/events_view';
// 		</script>
		<?php
// 	}
// }elseif (isset($_REQUEST['btnDenyUser'])) {
// 	$resU = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$_REQUEST['m_id']}'"));


// 	$date_sent = date('Y-m-d');

// 	$sms_content = "Good day ".$resU['fname']." ".$resU['lname']." Your account has been denied.";

// 	$member_name = $resU['fname'].' '.$resU['lname'];

// 	$qSms = mysqli_query($con, "INSERT INTO sms_tbl (member_id, sms_content, contact_number, date_sent, sms_status, member_name) VALUES ('{$resU['member_id']}', '$sms_content', '{$resU['contact_number']}', '$date_sent', '1', '$member_name')");

// 	if ($qSms) {

// 		$query = mysqli_query($con, "DELETE FROM members_tbl WHERE member_id = '{$resU['member_id']}'");

// 		if ($query) {
// 			?>
		<script type="text/javascript">
// 			window.location.href='../../../views/admin/pending_accounts_view';
// 		</script>
 		<?php
// 		}

		
// 	}

// }
if (isset($_REQUEST['btnDelResType'])) {
	$query = mysqli_query($con, "DELETE FROM reservation_type_tbl WHERE reservation_type_id = '{$_REQUEST['r_id']}'");
	if ($query) {
		?>
		<script type="text/javascript">
			window.location.href='../../../views/admin/settings_view';
		</script>
		<?php
	}
}
// }elseif (isset($_REQUEST['btnDelRole'])) {
// 	$query = mysqli_query($con, "DELETE FROM role_tbl WHERE role_id = '{$_REQUEST['r_id']}'");
// 	if ($query) {
// 		?>
		<script type="text/javascript">
// 			window.location.href='../../../views/admin/settings_view';
// 		</script>
 		<?php
// 	}
// }elseif (isset($_REQUEST['btnDenyCoord'])) {
// 	$resU = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM coordinators_tbl WHERE coordinator_id = '{$_REQUEST['c_id']}'"));


// 	$date_sent = date('Y-m-d');

// 	$sms_content = "Good day ".$resU['fname']." ".$resU['lname']." Your account has been denied.";

// 	$member_name = $resU['fname'].' '.$resU['lname'];

// 	$qSms = mysqli_query($con, "INSERT INTO sms_tbl (sms_content, contact_number, date_sent, sms_status, member_name, send_by) VALUES ('$sms_content', '{$resU['contact_number']}', '$date_sent', '1', '$member_name', 'admin')");

// 	if ($qSms) {

// 		$query = mysqli_query($con, "DELETE FROM coordinators_tbl WHERE coordinator_id = '{$resU['coordinator_id']}'");

// 		if ($query) {
// 			?>
		<script type="text/javascript">
// 			window.location.href='../../../views/admin/pending_accounts_view';
// 		</script>
		<?php
// 		}

		
// 	}
// }elseif (isset($_REQUEST['btnDelSchool'])) {
// 	$query = mysqli_query($con, "DELETE FROM schools_tbl WHERE school_id = '{$_REQUEST['s_id']}'");
// 	if ($query) {
// 			?>
 		<script type="text/javascript">
// 			window.location.href='../../../views/admin/settings_view';
// 		</script>
 		<?php
// 		}
// }


 if (isset($_GET['btnDelCollege'])) {
    $college_id = mysqli_escape_string($con, $_GET['c_id']);
    $query = mysqli_query($con, "DELETE FROM colleges WHERE college_id='$college_id'");
    if ($query) {
        ?>
        <script>
            alert("College Deleted Successfully!");
            window.location.href='../../../views/admin/settings_view';
        </script>
        <?php
    }
}

// ================= DELETE COURSE =================
elseif (isset($_GET['btnDelCourse'])) {
    $course_id = mysqli_escape_string($con, $_GET['c_id']);
    $query = mysqli_query($con, "DELETE FROM courses WHERE course_id='$course_id'");
    if ($query) {
        ?>
        <script>
            alert("Course Deleted Successfully!");
            window.location.href='../../../views/admin/settings_view';
        </script>
        <?php
    }
}elseif (isset($_GET['btnDelSchoolYear'])) {
    $sy_id = isset($_GET['sy_id']) ? (int)$_GET['sy_id'] : 0;

    if ($sy_id > 0) {
        // Optional safety: prevent deleting active school year
        $chk = mysqli_query($con, "SELECT is_active FROM school_years WHERE school_year_id = $sy_id LIMIT 1");
        if ($chk && mysqli_num_rows($chk) > 0) {
            $r = mysqli_fetch_assoc($chk);
            if ((int)$r['is_active'] === 1) {
                header("Location: ../../../views/admin/settings_view.php?err=CannotDeleteActiveSchoolYear");
                exit;
            }
        }

        mysqli_query($con, "DELETE FROM school_years WHERE school_year_id = $sy_id");
    }

    header("Location: ../../../views/admin/settings_view.php?ok=SchoolYearDeleted");
    exit;
}

?>