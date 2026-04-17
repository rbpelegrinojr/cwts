<?php
include '../../../include/db.php';
require_once('../../../PHPMailer/PHPMailerAutoload.php');
if (isset($_REQUEST['btnApproveRes'])) {
	
	$resRes = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_id = '{$_REQUEST['r_id']}'"));
	$resMem = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$resRes['member_id']}'"));
	$resResType = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservation_type_tbl WHERE reservation_type_id = '{$resRes['reservation_type']}'"));
	$resAdmin = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users_tbl WHERE user_id = '{$_REQUEST['user_id']}'"));
	$user_email = $resMem['email'];
	$date_now = date('Y-m-d');

	$query = mysqli_query($con, "UPDATE reservations_tbl SET reservation_status = '1' WHERE reservation_id = '{$resRes['reservation_id']}'");

	if ($query) {

		$sms_content = "Saint Isidore Parish Online Scheduling Management System\n\nGood day ".$resMem['fname']." ".$resMem['lname'].", Your reservation for ".$resResType['reservation_type']." has been approved.";
		$qSms = mysqli_query($con, "INSERT INTO sms_tbl (member_id, contact_number, sms_content, sms_type, date_sent, sms_status) VALUES ('{$resMem['member_id']}', '{$resMem['contact_number']}', '$sms_content', '2', '$date_now', '1')");
		$num = $resMem['contact_number'];
		if ($qSms) {
			
			function sendSMS($apiKey, $number, $message) {
			    $sms_api = "https://lintechsms.thesissystems.link"; // Ang API URL

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

			    $http_status = isset($http_response_header[0]) ? $http_response_header[0] : "";

			    if ($response === FALSE) {
			        if (strpos($http_status, "403") !== false) {
			            echo "Error: Unauthorized access. Invalid API key.";
			        } elseif (strpos($http_status, "500") !== false) {
			            echo "Error: Server error. Please try again later.";
			        } else {
			            echo "Error: Could not send SMS.";
			        }
			    } else {
			        ?>
			        <script type="text/javascript">alert('Reservation has been approved');
			        window.location.href='../'
			    </script>
			        <?php
			    }

			}

			sendSMS("Baho_ka_buli", $num, $sms_content);


		}
		
	}
	

}elseif (isset($_REQUEST['btnDeclineRes'])) {


	$reservation_id = $_REQUEST['r_id'];
	$resRes = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_id = '$reservation_id'"));
	$resMem = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$resRes['member_id']}'"));
	$resResType = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservation_type_tbl WHERE reservation_type_id = '{$resRes['reservation_type']}'"));
	$date_now = date('Y-m-d');

	$disapprove_new_date = $_REQUEST['disapprove_new_date'];
	$disapprove_new_time = $_REQUEST['disapprove_new_time'];
	$disapprove_reason = mysqli_escape_string($con, $_REQUEST['disapprove_reason']);

	$resEx = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_date = '$disapprove_new_date' AND reservation_time = '$disapprove_new_time' AND reservation_id != '$reservation_id'"));
	$num = $resMem['contact_number'];
	if (empty($resEx['reservation_id'])) {
		
		$query = mysqli_query($con, "UPDATE reservations_tbl SET reservation_status = '2', disapproved_date = '$date_now', disapprove_new_date = '$disapprove_new_date', disapprove_new_time = '$disapprove_new_time', disapprove_reason = '$disapprove_reason' WHERE reservation_id = '$reservation_id'");

		if ($query) {
			$sms_content = 'Good day '.$resMem['fname'].' '.$resMem['lname'].', Your reservation for '.$resResType['reservation_type'].' has been Disapproved. Reason: '.$disapprove_reason;
			$qSms = mysqli_query($con, "INSERT INTO sms_tbl (member_id, contact_number, sms_content, sms_type, date_sent, sms_status) VALUES ('{$resMem['member_id']}', '{$resMem['contact_number']}', '$sms_content', '3', '$date_now', '1')");

			if ($qSms) {

				function sendSMS($apiKey, $number, $message) {
			    $sms_api = "https://lintechsms.thesissystems.link"; // Ang API URL

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

			    $http_status = isset($http_response_header[0]) ? $http_response_header[0] : "";

			    if ($response === FALSE) {
			        if (strpos($http_status, "403") !== false) {
			            echo "Error: Unauthorized access. Invalid API key.";
			        } elseif (strpos($http_status, "500") !== false) {
			            echo "Error: Server error. Please try again later.";
			        } else {
			            echo "Error: Could not send SMS.";
			        }
			    } else {
			        ?>
					<script type="text/javascript">
						alert('Reservation Disapproved');
						window.location.href='../../../views/admin/pendings_view';
					</script>
					<?php
			    }

			}

			sendSMS("Baho_ka_buli", $num, $sms_content);


				
				//header('location: ../../../views/admin/pendings_view');
			}
		}

	}else{
		?>
		<script type="text/javascript">
			alert('Date and Time Already Exist');
			window.location.href='../../../views/admin/pendings_view';
		</script>
		<?php
	}

	

}elseif (isset($_REQUEST['btnCompleted'])) {
	$reservation_id = $_REQUEST['r_id'];
	$resRes = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_id = '$reservation_id'"));
	$resMem = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '{$resRes['member_id']}'"));
	$date_now = date('Y-m-d');

	$query = mysqli_query($con, "UPDATE reservations_tbl SET reservation_status = '4', date_completed = '$date_now' WHERE reservation_id = '$reservation_id'");

	if ($query) {
		header('location: ../../../views/admin/approved_view');
	}
}elseif (isset($_REQUEST['btnAnnouncementInactive'])) {

	$query = mysqli_query($con, "UPDATE announcements_tbl SET announcement_status = '0' WHERE announcement_id = '{$_REQUEST['a_id']}'");

	if ($query) {
		header('location: ../../../views/admin/active_announcements');
	}
}elseif (isset($_REQUEST['btnCancelAnnouncement'])) {

	$a_id = (int)$_REQUEST['a_id'];
	$query = mysqli_query($con, "UPDATE announcements_tbl SET announcement_status = '2' WHERE announcement_id = '$a_id'");

	if ($query) {
		header('location: ../../../views/admin/active_announcements');
	}
}elseif (isset($_REQUEST['btnSaveAnnouncement1111'])) {
	$announcement = mysqli_escape_string($con, $_REQUEST['announcement']);
	$subject_announcement = mysqli_escape_string($con, $_REQUEST['subject_announcement']);
	$date_now = $_REQUEST['date_created'];

	$query = mysqli_query($con, "INSERT INTO announcements_tbl (announcement, date_created, announcement_status, subject_announcement) VALUES ('$announcement', '$date_now', '1', '$subject_announcement')");

	if ($query) {

		header('location: ../../../views/admin/active_announcements');

		// $qMem = mysqli_query($con, "SELECT * FROM members_tbl WHERE account_status = '1'");
		// while ($rMem = mysqli_fetch_assoc($qMem)) {
		// 	$sms_content = "Announcement: ".$announcement;
		// 	$date_now = date('Y-m-d');
		// 	$qSms = mysqli_query($con, "INSERT INTO sms_tbl (member_id, contact_number, sms_content, sms_type, date_sent, sms_status) VALUES ('{$rMem['member_id']}', '{$rMem['contact_number']}', '$sms_content', '1', '$date_now', '1')");
		// }
		// if ($qSms) {
		// 	header('location: ../../../views/admin/active_announcements');
		// }
	}

}elseif (isset($_REQUEST['btnSaveAnnouncement'])) {

    // REQUIRED FIELDS
    $announcement = mysqli_real_escape_string($con, $_REQUEST['announcement']);
    $subject_announcement = mysqli_real_escape_string($con, $_REQUEST['subject_announcement']);
    $date_now = isset($_REQUEST['date_created']) ? $_REQUEST['date_created'] : date('Y-m-d');

    // NEW: college filter (0 = ALL)
    $college_id = isset($_REQUEST['college_id']) ? (int)$_REQUEST['college_id'] : 0;
    if ($college_id < 0) $college_id = 0;

    // Insert with college_id
    $query = mysqli_query($con, "
        INSERT INTO announcements_tbl
            (announcement, date_created, announcement_status, subject_announcement, college_id)
        VALUES
            ('$announcement', '$date_now', '1', '$subject_announcement', '$college_id')
    ");

    if ($query) {

        // ✅ SMS API function
        function sendSMS($apiKey, $number, $message) {
            $sms_api = "https://lintechsms.thesissystems.link";

            $data = http_build_query(array(
                'api_key' => $apiKey,
                'num'     => $number,
                'msg'     => $message
            ));

            $opts = array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                    'content' => $data,
                    'timeout' => 10
                )
            );

            $context  = stream_context_create($opts);
            $response = @file_get_contents($sms_api, false, $context);

            return ($response !== FALSE);
        }

        // ✅ Your API key
        $apiKey = "Baho_ka_buli"; // Replace with your real key

        // Get college abbreviation for SMS header (optional but nice)
        $college_tag = "ALL";
        if ($college_id > 0) {
            $qCol = mysqli_query($con, "SELECT college_abbreviation FROM colleges WHERE college_id = $college_id LIMIT 1");
            if ($qCol && mysqli_num_rows($qCol) == 1) {
                $rCol = mysqli_fetch_assoc($qCol);
                $college_tag = $rCol['college_abbreviation'];
            } else {
                $college_tag = "COLLEGE";
            }
        }

        // ✅ Fetch recipients based on college filter
        // members_tbl.college_id is TEXT in your dump, so we compare safely by casting college_id to string
        if ($college_id == 0) {
            $qMem = mysqli_query($con, "SELECT member_id, contact_number FROM members_tbl WHERE account_status = '1'");
        } else {
            $qMem = mysqli_query($con, "SELECT member_id, contact_number FROM members_tbl WHERE account_status = '1' AND college_id = '$college_id'");
        }

        // ✅ Send SMS
        while ($qMem && ($rMem = mysqli_fetch_assoc($qMem))) {
            $number = $rMem['contact_number'];

            $sms_content =
                "CWTS - {$college_tag}\n\n" .
                "ANNOUNCEMENT: {$subject_announcement}\n\n" .
                "{$announcement}\n\n" .
                "Date: {$date_now}";

            sendSMS($apiKey, $number, $sms_content);

            // Optional logging (uncomment if needed)
            // $date_sent = date('Y-m-d');
            // mysqli_query($con, "INSERT INTO sms_tbl (contact_number, sms_content, date_sent, sms_status)
            //                     VALUES ('$number', '".mysqli_real_escape_string($con, $sms_content)."', '$date_sent', '1')");
        }

        // ✅ Redirect
        header('location: ../../../views/admin/active_announcements');
        exit;
    }
}elseif (isset($_REQUEST['btnBlockMem'])) {
	
	$query = mysqli_query($con, "UPDATE members_tbl SET account_status = '0' WHERE member_id = '{$_REQUEST['m_id']}'");

	if ($query) {
		header('location: ../../../views/admin/members_view');
	}

}elseif (isset($_REQUEST['btnUnblock'])) {
	$query = mysqli_query($con, "UPDATE members_tbl SET account_status = '1' WHERE member_id = '{$_REQUEST['m_id']}'");

	if ($query) {
		header('location: ../../../views/admin/blocked_members_view');
	}
}elseif (isset($_REQUEST['btnArchive'])) {
	$query = mysqli_query($con, "UPDATE reservations_tbl SET reservation_status = '5' WHERE reservation_id = '{$_REQUEST['r_id']}'");
	if ($query) {
		header('location: ../../../views/admin/completed_view');
	}
}elseif (isset($_REQUEST['btnAddReservation'])) {
	$reservation_type = $_REQUEST['reservation_type'];
	$resResType = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservation_type_tbl WHERE reservation_type = '$reservation_type'"));

	if ($resResType['reservation_type'] != $reservation_type) {
		$query = mysqli_query($con, "INSERT INTO reservation_type_tbl (reservation_type) VALUES ('$reservation_type')");

		if ($query) {
			?>
			<script type="text/javascript">
				//alert('New Reservation Type Added');
				window.location.href='../../../views/admin/settings_view';
			</script>
			<?php
		}
	}else{
		?>
		<script type="text/javascript">
			alert('Reservation Type Already Exist');
			window.location.href='../../../views/admin/settings_view';
		</script>
		<?php
	}
}elseif (isset($_REQUEST['btnEditReservation'])) {
	$reservation_type_id = $_REQUEST['reservation_type_id'];
	$reservation_type = $_REQUEST['reservation_type'];

	$resResType = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservation_type_tbl WHERE reservation_type != '$reservation_type' AND reservation_type_id = '$reservation_type_id'"));

	if ($resResType['reservation_type'] != $reservation_type) {
		
		$query = mysqli_query($con, "UPDATE reservation_type_tbl SET reservation_type = '$reservation_type' WHERE reservation_type_id = '$reservation_type_id'");

		if ($query) {
			?>
			<script type="text/javascript">
				alert('Reservation Edited');
				window.location.href='../../../views/admin/settings_view';
			</script>
			<?php
		}

	}
}elseif (isset($_REQUEST['btnUpdateSysTitle'])) {
	$system_title = $_REQUEST['system_title'];
	$query = mysqli_query($con, "UPDATE settings_tbl SET system_title = '$system_title'");
	if ($query) {
		header('location: ../../../views/admin/settings_view');
	}
}elseif (isset($_REQUEST['btnUpdateLogo'])) {
	$system_logo = $_FILES['system_logo']['name'];
	$tmpName = $_FILES['system_logo']['tmp_name'];
	move_uploaded_file($tmpName, "../../../system_images/".$system_logo);
	$resSets = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM settings_tbl"));
	$url = "";
	if(empty($system_logo)){
		$url = $resSets['system_logo'];
	}else{
		$url = "http://localhost/cwts/system_images/".$system_logo;
	}
	$query = mysqli_query($con, "UPDATE settings_tbl SET system_logo = '$url'");
	if ($query) {
		header('location: ../../../views/admin/settings_view');
	}
}elseif (isset($_REQUEST['btnEditProfile'])) {
	$fname = mysqli_escape_string($con, $_REQUEST['fname']);
	$lname = mysqli_escape_string($con, $_REQUEST['lname']);
	$contact_number = mysqli_escape_string($con, $_REQUEST['contact_number']);
	$email = mysqli_escape_string($con, $_REQUEST['email']);
	$username = mysqli_escape_string($con, $_REQUEST['username']);
	$password = mysqli_escape_string($con, $_REQUEST['password']);
	$user_id = mysqli_escape_string($con, $_REQUEST['user_id']);
	$profile_image = $_FILES['profile_image']['name'];
	$tmpName = $_FILES['profile_image']['tmp_name'];
	move_uploaded_file($tmpName, "../../../profile_images/".$profile_image);
	$resU = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users_tbl WHERE user_id = '$user_id'"));
	$url = "";
	if (empty($profile_image)) {
		$url = $resU['profile_image'];
	}else{
		$url = "http://localhost/cwts/profile_images/".$profile_image;
	}

	$query = mysqli_query($con, "UPDATE users_tbl SET fname = '$fname', lname = '$lname', contact_number = '$contact_number', email = '$email', username = '$username', password = '$password', profile_image = '$url' WHERE user_id = '$user_id'");

	if ($query) {
		header('location: ../../../views/admin/profile_view');
	}

}elseif (isset($_REQUEST['btnCancel'])) {
	
	$reservation_id = $_REQUEST['r_id'];
	$date_now = date('Y-m-d');

	$query = mysqli_query($con, "UPDATE reservations_tbl SET reservation_status = '3', date_cancelled = '$date_now' WHERE reservation_id = '$reservation_id'");

	if ($query) {
		?>
		<script type="text/javascript">
			alert('Reservation Canceled');
			window.location.href='../../../views/admin/pendings_view';
		</script>
		<?php
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

    $resEmail = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE email = '$email'"));

    if ($resEmail['email'] != $email) {
        
        $resNum = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE contact_number = '$contact_number'"));

        if ($resNum['contact_number'] != $contact_number) {
            
            $query = mysqli_query($con, "INSERT INTO members_tbl 
                (fname, mname, lname, email, contact_number, college_id, course_id, dob, address, school_year, member_type, account_status) 
                VALUES 
                ('$fname', '$mname', '$lname', '$email', '$contact_number', '$college', '$course', '$dob', '$address', '$school_year', '1', '1')");

            if ($query) {
                ?>
                <script type="text/javascript">
                    alert('Member Encoded.');
                    window.location.href='../../../views/admin/members_view';
                </script>
                <?php
            }

        } else {
            ?>
            <script type="text/javascript">
                alert('Contact Number Exists.');
               window.location.href='../../../views/admin/members_view';
            </script>
            <?php
        }

    } else {
        ?>
        <script type="text/javascript">
            alert('Email Exists.');
            window.location.href='../../../views/admin/members_view';
        </script>
        <?php
    }
}elseif (isset($_REQUEST['btnAddReservationWalkIn'])) {
	
	$reservation_type = mysqli_escape_string($con, $_REQUEST['reservation_type']);
	$reservation_date = mysqli_escape_string($con, $_REQUEST['reservation_date']);
	$reservation_time = mysqli_escape_string($con, $_REQUEST['reservation_time']);
	$reservation_description = mysqli_escape_string($con, $_REQUEST['reservation_description']);
	$member_id = mysqli_escape_string($con, $_REQUEST['member_id']);
	$date_now = date('Y-m-d');

	$resResType = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservation_type_tbl WHERE reservation_type = '$reservation_type'"));

	$resExist = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM reservations_tbl WHERE reservation_type = '{$resResType['reservation_type_id']}' AND reservation_date = '$reservation_date' AND reservation_time = '$reservation_time'"));

	if ($resExist['reservation_date'] != $reservation_date && $resExist['reservation_time'] != $reservation_time) {
		
		if ($reservation_date > $date_now) {
				
				$query = mysqli_query($con, "INSERT INTO reservations_tbl (member_id, reservation_type, reservation_description, reservation_date, reservation_time, reservation_status, date_created) VALUES ('$member_id', '$reservation_type', '$reservation_description', '$reservation_date', '$reservation_time', '1', '$date_now')");

				if ($query) {
					$resMem = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM members_tbl WHERE member_id = '$member_id'"));
					$sms_content = "Reservation from ".$resMem['fname'].' '.$resMem['lname'].'('.$resResType['reservation_type'].' @ '.$reservation_date.'  '.$reservation_time.')';
					$qSms = mysqli_query($con, "INSERT INTO sms_tbl (contact_number, sms_content, date_sent, sms_status) VALUES ('09308242900', '$sms_content', '$date_now', '1')");

					if ($qSms) {
						?>
						<script type="text/javascript">
							alert('Transaction Complete');
							window.location.href='../../../views/admin/members_view';
						</script>
						<?php
					}

				}

			}else{
				?>

				<?php
			}

	}else{
		?>
		<script type="text/javascript">
			alert('No Date Available');
			window.location.href='../../../views/admin/members_view';
		</script>
		<?php
	}

}elseif (isset($_POST['btnAddCollege'])) {
    $college_name = mysqli_escape_string($con, $_POST['college_name']);
    $college_abbreviation = mysqli_escape_string($con, $_POST['college_abbreviation']);

    $query = mysqli_query($con, "INSERT INTO colleges (college_name, college_abbreviation) VALUES ('$college_name', '$college_abbreviation')");
    if ($query) {
        ?>
        <script>
            alert("College Added Successfully!");
            window.location.href='../../../views/admin/settings_view';
        </script>
        <?php
    }
}

// ================= EDIT COLLEGE =================
elseif (isset($_POST['btnEditCollege'])) {
    $college_id = mysqli_escape_string($con, $_POST['college_id']);
    $college_name = mysqli_escape_string($con, $_POST['college_name']);
    $college_abbreviation = mysqli_escape_string($con, $_POST['college_abbreviation']);

    $query = mysqli_query($con, "UPDATE colleges SET college_name='$college_name', college_abbreviation='$college_abbreviation' WHERE college_id='$college_id'");
    if ($query) {
        ?>
        <script>
            alert("College Updated Successfully!");
            window.location.href='../../../views/admin/settings_view';
        </script>
        <?php
    }
}

// ================= ADD COURSE =================
elseif (isset($_POST['btnAddCourse'])) {
    $course_name = mysqli_escape_string($con, $_POST['course_name']);
    $course_abbreviation = mysqli_escape_string($con, $_POST['course_abbreviation']);
    $college_id = mysqli_escape_string($con, $_POST['college_id']);

    $query = mysqli_query($con, "INSERT INTO courses (course_name, course_abbreviation, college_id) VALUES ('$course_name', '$course_abbreviation', '$college_id')");
    if ($query) {
        ?>
        <script>
            alert("Course Added Successfully!");
            window.location.href='../../../views/admin/settings_view';
        </script>
        <?php
    }
}

// ================= EDIT COURSE =================
elseif (isset($_POST['btnEditCourse'])) {
    $course_id = mysqli_escape_string($con, $_POST['course_id']);
    $course_name = mysqli_escape_string($con, $_POST['course_name']);
    $course_abbreviation = mysqli_escape_string($con, $_POST['course_abbreviation']);
    $college_id = mysqli_escape_string($con, $_POST['college_id']);

    $query = mysqli_query($con, "UPDATE courses SET course_name='$course_name', course_abbreviation='$course_abbreviation', college_id='$college_id' WHERE course_id='$course_id'");
    if ($query) {
        ?>
        <script>
            alert("Course Updated Successfully!");
            window.location.href='../../../views/admin/settings_view';
        </script>
        <?php
    }
}elseif (isset($_POST['btnAddSchoolYear'])) {
    $school_year = isset($_POST['school_year']) ? trim($_POST['school_year']) : '';
    $make_active = isset($_POST['make_active']) ? 1 : 0;

    if ($school_year == '') {
        header("Location: ../../../views/admin/settings_view.php?err=SchoolYearEmpty");
        exit;
    }

    $school_year_esc = mysqli_real_escape_string($con, $school_year);

    // If make active, deactivate all first
    if ($make_active == 1) {
        mysqli_query($con, "UPDATE school_years SET is_active = 0");
    }

    $sql = "INSERT INTO school_years (school_year, is_active) VALUES ('$school_year_esc', $make_active)";
    $res = mysqli_query($con, $sql);

    if (!$res) {
        // Duplicate key or other error
        header("Location: ../../../views/admin/settings_view.php?err=SchoolYearAddFailed");
        exit;
    }

    header("Location: ../../../views/admin/settings_view.php?ok=SchoolYearAdded");
    exit;
}

if (isset($_POST['btnEditSchoolYear'])) {
    $school_year_id = isset($_POST['school_year_id']) ? (int)$_POST['school_year_id'] : 0;
    $school_year    = isset($_POST['school_year']) ? trim($_POST['school_year']) : '';

    if ($school_year_id <= 0 || $school_year == '') {
        header("Location: ../../../views/admin/settings_view.php?err=SchoolYearEditInvalid");
        exit;
    }

    $school_year_esc = mysqli_real_escape_string($con, $school_year);

    $sql = "UPDATE school_years SET school_year = '$school_year_esc' WHERE school_year_id = $school_year_id";
    $res = mysqli_query($con, $sql);

    if (!$res) {
        header("Location: ../../../views/admin/settings_view.php?err=SchoolYearEditFailed");
        exit;
    }

    header("Location: ../../../views/admin/settings_view.php?ok=SchoolYearUpdated");
    exit;
}

if (isset($_POST['btnSetActiveSchoolYear'])) {
    $school_year_id = isset($_POST['school_year_id']) ? (int)$_POST['school_year_id'] : 0;

    if ($school_year_id <= 0) {
        header("Location: ../../../views/admin/settings_view.php?err=SchoolYearActiveInvalid");
        exit;
    }

    mysqli_query($con, "UPDATE school_years SET is_active = 0");
    mysqli_query($con, "UPDATE school_years SET is_active = 1 WHERE school_year_id = $school_year_id");

    header("Location: ../../../views/admin/settings_view.php?ok=SchoolYearActivated");
    exit;
}


?>