<?php
include '../../../include/db.php'; // adjust path if needed

if (isset($_POST['btnSaveCoord'])) {
    // Collect & sanitize input
    $fname          = mysqli_real_escape_string($con, $_POST['fname']);
    $lname          = mysqli_real_escape_string($con, $_POST['lname']);
    $email          = mysqli_real_escape_string($con, $_POST['email']);
    $email_password = mysqli_real_escape_string($con, $_POST['email_password']);
    $contact_number = mysqli_real_escape_string($con, $_POST['contact_number']);
    $username       = mysqli_real_escape_string($con, $_POST['username']);
    //$password       = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure hash
    $user_type      = mysqli_real_escape_string($con, $_POST['user_type']);
    $password = mysqli_escape_string($con, $_POST['password']);
    $college_id = $_POST['college_id'];
    // Check if username or email already exists
    $checkUser = "SELECT * FROM users_tbl WHERE username='$username' OR email='$email'";
    $result = mysqli_query($con, $checkUser);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username or Email already exists!'); window.history.back();</script>";
        exit;
    }

    // Insert into DB
    $query = "INSERT INTO users_tbl (fname, lname, email, email_password, contact_number, username, password, user_type, college_id) 
              VALUES ('$fname', '$lname', '$email', '$email_password', '$contact_number', '$username', '$password', '$user_type', '$college_id')";
    
    if (mysqli_query($con, $query)) {
        echo "<script>alert('User saved successfully!'); window.location='../../../views/admin/users_view.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>
