<?php
include '../../../include/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM users_tbl WHERE user_id='$id'");
    header("Location: ../../../views/admin/users_view.php?delete=success");
    exit();
}
?>
