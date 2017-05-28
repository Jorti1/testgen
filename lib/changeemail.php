<?php
error_reporting(0);

include '../inc/database.php';

if (!isset($_SESSION)) { session_start(); }

if (!isset($_SESSION['username'])) {
echo '
<script language="javascript">
    window.location.href = "../login.php"
</script>
';
exit();
}

$email = mysqli_real_escape_string($con, $_POST['email']);
$id = mysqli_real_escape_string($con, $_SESSION['id']);

mysqli_query($con,"UPDATE `users` SET `email` = '$email' WHERE `id` = '$id'") or die(mysqli_error($con));

$_SESSION['password'] = $password;

header("Location: ../index.php");

?>