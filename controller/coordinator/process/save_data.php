<?php
include '../../../include/db.php';
if (isset($_REQUEST['btnVerify'])) {
	$query = mysqli_query($con, "UPDATE members_tbl SET account_status = '0' WHERE member_id = '{$_REQUEST['m_id']}'");
	if ($query) {
		$res = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$_REQUEST['m_id']}'"));

		$sms_content = "Good day ".$res['fname'].' '.$res['lname'].', Your account has been approved. Thank you.';
		$date_sent = date('Y-m-d');
		$qSms = mysqli_query($con, "INSERT INTO sms_tbl (member_id, sms_content, contact_number, date_sent, sms_status) VALUES ('{$res['member_id']}', '$sms_content', '{$res['contact_number']}', '$date_sent', '1')");

		if ($qSms) {
			?>
			<script type="text/javascript">
				//alert('User Verified');
				window.location.href='../../../views/coordinator/pending_accounts_view';
			</script>
			<?php
		}
		
	}
}elseif (isset($_REQUEST['btnSaveEvent'])) {

	$user_id = mysqli_escape_string($con, $_REQUEST['user_id']);
	$user_username = mysqli_escape_string($con, $_REQUEST['user_username']);
	$school_id = mysqli_escape_string($con, $_REQUEST['school_id']);
	$department_id = mysqli_escape_string($con, $_REQUEST['department_id']);
	$event_title = mysqli_escape_string($con, $_REQUEST['event_title']);
	$gender_scope = mysqli_escape_string($con, $_REQUEST['gender_scope']);
	$role_scope = mysqli_escape_string($con, $_REQUEST['role_scope']);
	$event_date_start = mysqli_escape_string($con, $_REQUEST['event_date_start']);
	$event_time = mysqli_escape_string($con, $_REQUEST['event_time']);
	$event_description = mysqli_escape_string($con, $_REQUEST['event_description']);
	$global_url = mysqli_escape_string($con, $_REQUEST['global_url']);
	$event_date_end = "";
	$date_created = date('Y-m-d');

	if (empty($_REQUEST['event_date_end'])) {
		$event_date_end = "N/A";
	}else{
		$event_date_end = $_REQUEST['event_date_end'];
	}

	$query = mysqli_query($con, "INSERT INTO events_tbl (user_id, user_username, event_title, gender_scope, role_scope, event_date_start, event_date_end, event_time, event_description, date_created, school_id, department_id, event_status, archive_status) VALUES ('$user_id', '$user_username', '$event_title', '$gender_scope', '$role_scope', '$event_date_start', '$event_date_end', '$event_time', '$event_description', '$date_created', '$school_id', '$department_id', '1', '1')");

	if ($query) {

		$date_sent = date('Y-m-d');

		if ($gender_scope == '0' && $school_id == '0') {
			
			$qMem = mysqli_query($con, "SELECT * FROM members_tbl WHERE account_status = '0'");

		}elseif ($gender_scope != '0' && $school_id == '0') {
			
			$qMem = mysqli_query($con, "SELECT * FROM members_tbl WHERE gender = '$gender_scope' AND account_status = '0'");

		}elseif ($gender_scope == '0' && $school_id != '0') {
			
			$qMem = mysqli_query($con, "SELECT * FROM members_tbl WHERE school_id = '$school_id' AND department_id = '$department_id' AND account_status = '0'");

		}elseif ($gender_scope != '0' && $school_id != '0') {
			
			$qMem = mysqli_query($con, "SELECT * FROM members_tbl WHERE gender = '$gender_scope' AND school_id = '$school_id' AND department_id = '$department_id' AND account_status = '0'");

		}

		// if ($gender_scope != '0') {
			
		// 	$qMem = mysqli_query($con, "SELECT * FROM members_tbl WHERE account_status = '0' AND department_id = '$department_id' AND school_id = '$school_id' AND gender = '$gender_scope'");

		// }else{
		// 	$qMem = mysqli_query($con, "SELECT * FROM members_tbl WHERE account_status = '0' AND department_id = '$department_id' AND school_id = '$school_id'");
		// }

		if ($numRows = mysqli_num_rows($qMem) > 0) {
				while ($rMem = mysqli_fetch_assoc($qMem)) {
					$sms_content = "";
					$member_name = $rMem['fname'].' '.$rMem['lname'];
					if (empty($event_date_end)) {
						$sms_content = "Good day ".$rMem['fname']." ".$rMem['lname']." New Event Schedule. What: ".$event_title." When: ".date('F j, Y', strtotime($event_date_start))." @ ".$event_time.". Thank you.";
					}else{
						$sms_content = "Good day ".$rMem['fname']." ".$rMem['lname']." New Event Schedule. What: ".$event_title." When: ".date('F j, Y', strtotime($event_date_start))." To ".date('F j, Y', strtotime($event_date_end))." @ ".$event_time.". Thank you.";
					}

					$qSms = mysqli_query($con, "INSERT INTO sms_tbl (send_by, member_id, sms_content, contact_number, date_sent, sms_status, member_name) VALUES ('$user_username', '{$rMem['member_id']}', '$sms_content', '{$rMem['contact_number']}', '$date_sent', '1', '$member_name')");

			}

			if ($qSms) {
				?>
				<script type="text/javascript">
					alert('Event Created');
					window.location.href='<?php echo $global_url; ?>';
				</script>
				<?php
			}
		}else{
			?>
			<script type="text/javascript">
				alert('Event Created');
				window.location.href='<?php echo $global_url; ?>';
			</script>
			<?php
			
		}
		
	}

}elseif (isset($_REQUEST['btnEditEvent'])) {
	$event_id = $_REQUEST['event_id'];
	$event_title = mysqli_escape_string($con, $_REQUEST['event_title']);
	$gender_scope = mysqli_escape_string($con, $_REQUEST['gender_scope']);
	$role_scope = mysqli_escape_string($con, $_REQUEST['role_scope']);
	$event_date_start = mysqli_escape_string($con, $_REQUEST['event_date_start']);
	$event_date_end = "";
	if (empty($event_date_end)) {
		$event_date_end = "N/A";
	}else{
		$event_date_end = $_REQUEST['event_date_end'];
	}
	$event_time = mysqli_escape_string($con, $_REQUEST['event_time']);
	$event_description = mysqli_escape_string($con, $_REQUEST['event_description']);
	$date_created = date('Y-m-d');

	$query = mysqli_query($con, "UPDATE events_tbl SET event_title = '$event_title', gender_scope = '$gender_scope', role_scope = '$role_scope', event_date_start = '$event_date_start', event_date_end = '$event_date_end', event_time = '$event_time', event_description = '$event_description', date_created = '$date_created' WHERE event_id = '$event_id'");

	if ($query) {


		$date_sent = date('Y-m-d');

		$qMem = mysqli_query($con, "SELECT * FROM members_tbl WHERE gender = '$gender_scope' AND account_status = '0' OR role = '$role_scope' AND account_status = '0' OR role = 'All' AND account_status = '0' OR gender = 'All' AND account_status = '0'");
		if ($numRows = mysqli_num_rows($qMem) > 0) {
				while ($rMem = mysqli_fetch_assoc($qMem)) {
				
				$sms_content = "Good day ".$rMem['fname']." ".$rMem['lname']." New Event Schedule. What: ".$event_title." When: ".date('F j, Y', strtotime($event_date_start))." @ ".$event_time.". Thank you.";

				$qSms = mysqli_query($con, "INSERT INTO sms_tbl (member_id, sms_content, contact_number, date_sent, sms_status) VALUES ('{$rMem['member_id']}', '$sms_content', '{$rMem['contact_number']}', '$date_sent', '1')");

			}

			if ($qSms) {
				?>
				<script type="text/javascript">
					alert('Event Edited');
					window.location.href='../../../views/coordinator/events_view';
				</script>
				<?php
			}
		}else{
			?>
			<script type="text/javascript">
				alert('Event Edited');
				window.location.href='../../../views/coordinator/events_view';
			</script>
			<?php
		}

		
	}
}elseif (isset($_REQUEST['btnEditProfile'])) {
	$coordinator_id = $_REQUEST['coordinator_id'];
	$email = $_REQUEST['email'];
	$fname = mysqli_escape_string($con, $_REQUEST['fname']);
	$mname = mysqli_escape_string($con, $_REQUEST['mname']);
	$lname = mysqli_escape_string($con, $_REQUEST['lname']);
	$contact_number = mysqli_escape_string($con, $_REQUEST['contact_number']);
	$username = mysqli_escape_string($con, $_REQUEST['username']);
	$password = mysqli_escape_string($con, $_REQUEST['password']);
	$url = "";

	$profile_image = $_FILES['profile_image']['name'];
	$tmpName = $_FILES['profile_image']['tmp_name'];

	move_uploaded_file($tmpName, "../../../profile_images/".$profile_image);

	$resU = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM coordinators_tbl WHERE coordinator_id = '$coordinator_id'"));

	if (empty($profile_image)) {
		$url = $resU['profile_image'];
	}else{
		$url = "http://localhost/gad/profile_images/".$profile_image;
	}

	$query = mysqli_query($con, "UPDATE coordinators_tbl SET fname = '$fname', mname = '$mname', lname = '$lname', contact_number = '$contact_number', username = '$username', password = '$password', profile_image = '$url' WHERE coordinator_id = '$coordinator_id'");

	if ($query) {
		?>
		<script type="text/javascript">
			alert('Profile Updated');
			window.location.href='../../../views/coordinator/profile_view';
		</script>
		<?php
	}

	// $profile_image = mysqli_escape_string($con, $_REQUEST['profile_image']);
}elseif (isset($_REQUEST['btnAddGender'])) {
	$gender_name = $_REQUEST['gender_name'];
	$resGend = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM gender_tbl WHERE gender_name = '$gender_name'"));

	if ($resGend['gender_name'] != $gender_name) {
		$query = mysqli_query($con, "INSERT INTO gender_tbl (gender_name) VALUES ('$gender_name')");

		if ($query) {
			?>
			<script type="text/javascript">
				alert('New Gender Added');
				window.location.href='../../../views/coordinator/settings_view';
			</script>
			<?php
		}
	}else{
		?>
		<script type="text/javascript">
			alert('Gender Already Exist');
			window.location.href='../../../views/coordinator/settings_view';
		</script>
		<?php
	}
}elseif (isset($_REQUEST['btnAddRole'])) {
	$role_name = $_REQUEST['role_name'];
	$resGend = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM role_tbl WHERE role_name = '$role_name'"));

	if ($resGend['role_name'] != $role_name) {
		$query = mysqli_query($con, "INSERT INTO role_tbl (role_name) VALUES ('$role_name')");

		if ($query) {
			?>
			<script type="text/javascript">
				alert('New Role Added');
				window.location.href='../../../views/coordinator/settings_view';
			</script>
			<?php
		}
	}else{
		?>
		<script type="text/javascript">
			alert('Role Already Exist');
			window.location.href='../../../views/coordinator/settings_view';
		</script>
		<?php
	}
}elseif (isset($_REQUEST['btnEditGender'])) {
	$gender_id = $_REQUEST['gender_id'];
	$gender_name = $_REQUEST['gender_name'];

	$resGend = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM gender_tbl WHERE gender_name != '$gender_name' AND gender_id = '$gender_id'"));

	if ($resGend['gender_name'] != $gender_name) {
		
		$query = mysqli_query($con, "UPDATE gender_tbl SET gender_name = '$gender_name' WHERE gender_id = '$gender_id'");

		if ($query) {
			?>
			<script type="text/javascript">
				alert('Gender Edited');
				window.location.href='../../../views/coordinator/settings_view';
			</script>
			<?php
		}

	}

}elseif (isset($_REQUEST['btnEditRole'])) {
	$role_id = $_REQUEST['role_id'];
	$role_name = $_REQUEST['role_name'];

	$resRole = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM role_tbl WHERE role_name != '$role_name' AND role_id = '$role_id'"));

	if ($resRole['role_name'] != $role_name) {
		
		$query = mysqli_query($con, "UPDATE role_tbl SET role_name = '$role_name' WHERE role_id = '$role_id'");

		if ($query) {
			?>
			<script type="text/javascript">
				alert('Role Edited');
				window.location.href='../../../views/coordinator/settings_view';
			</script>
			<?php
		}

	}

}elseif (isset($_REQUEST['btnAddWalkinMember'])) {
    $fname = mysqli_escape_string($con, $_REQUEST['fname']);
    $mname = mysqli_escape_string($con, $_REQUEST['mname']);
    $lname = mysqli_escape_string($con, $_REQUEST['lname']);
    $email = mysqli_escape_string($con, $_REQUEST['email']);
    $contact_number = mysqli_escape_string($con, $_REQUEST['contact_number']);
    $college = mysqli_escape_string($con, $_REQUEST['college_id']);
    $course = mysqli_escape_string($con, $_REQUEST['course_id']);
    $dob = mysqli_escape_string($con, $_REQUEST['dob']);
    $address = mysqli_escape_string($con, $_REQUEST['address']);
    $school_year = mysqli_escape_string($con, $_REQUEST['school_year']);
    $guardian_contact_number = mysqli_escape_string($con, $_REQUEST['guardian_contact_number']);
    $guardian_name = mysqli_escape_string($con, $_REQUEST['guardian_name']);

    $resEmail = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '$email'"));

    if ($resEmail['email'] != $email) {
        
        $resNum = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE contact_number = '$contact_number'"));

        if ($resNum['contact_number'] != $contact_number) {
            
            $query = mysqli_query($con, "INSERT INTO members_tbl 
                (fname, mname, lname, email, contact_number, college_id, course_id, dob, address, school_year, member_type, account_status, guardian_contact_number, guardian_name) 
                VALUES 
                ('$fname', '$mname', '$lname', '$email', '$contact_number', '$college', '$course', '$dob', '$address', '$school_year', '1', '1', '$guardian_contact_number', '$guardian_name')");

            if ($query) {
                ?>
                <script type="text/javascript">
                    alert('Member Encoded.');
                    window.location.href='../../../views/coordinator/members_view';
                </script>
                <?php
            }

        } else {
            ?>
            <script type="text/javascript">
                alert('Contact Number Exists.');
               window.location.href='../../../views/coordinator/members_view';
            </script>
            <?php
        }

    } else {
        ?>
        <script type="text/javascript">
            alert('Email Exists.');
            window.location.href='../../../views/coordinator/members_view';
        </script>
        <?php
    }
}elseif (isset($_POST['btnEditMember'])) {
    $id = $_POST['member_id'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $contact = $_POST['contact_number'];
    $college = $_POST['college_id'];
    $course = $_POST['course_id'];
    $dob = $_POST['dob'];
    $sy = $_POST['school_year'];
    $address = $_POST['address'];
    $guardian_contact_number = mysqli_escape_string($con, $_REQUEST['guardian_contact_number']);
    $guardian_name = mysqli_escape_string($con, $_REQUEST['guardian_name']);


    mysqli_query($con, "UPDATE members_tbl 
        SET fname='$fname', mname='$mname', lname='$lname', email='$email', contact_number='$contact',
            college_id='$college', course_id='$course', dob='$dob', school_year='$sy', address='$address', guardian_contact_number = '$guardian_contact_number', guardian_name = '$guardian_name'
        WHERE member_id='$id'") or die(mysqli_error($con));

    echo "<script>alert('Student updated successfully!'); window.location='../../../views/coordinator/members_view';</script>";
}elseif (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    mysqli_query($con, "DELETE FROM members_tbl WHERE member_id='$id'") or die(mysqli_error($con));
    echo "<script>alert('Student deleted successfully!'); window.location='../../../views/coordinator/members_view';</script>";
}
?>

?>