<?php
include '../../../include/db.php';

if (isset($_POST['btnUpdateUser'])) {
    $id = $_POST['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $contact = $_POST['contact_number'];
    $college_id = $_POST['college_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $query = "UPDATE users_tbl SET fname='$fname', lname='$lname', email='$email', contact_number='$contact',
                  college_id='$college_id', username='$username', password='$password' WHERE user_id='$id'";
    } else {
        $query = "UPDATE users_tbl SET fname='$fname', lname='$lname', email='$email', contact_number='$contact',
                  college_id='$college_id', username='$username' WHERE user_id='$id'";
    }

    mysqli_query($con, $query);
    header("Location: ../../../views/admin/users_view.php?update=success");
    exit();
}
?>
