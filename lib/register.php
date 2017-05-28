<?php
error_reporting(0);

include '../inc/database.php';

$username = mysqli_real_escape_string($con, htmlspecialchars($_POST['username']));
$password = mysqli_real_escape_string($con, htmlspecialchars(md5($_POST['password'])));
$pass_conf = mysqli_real_escape_string($con, htmlspecialchars(md5($_POST['password_conf'])));
$email = mysqli_real_escape_string($con, htmlspecialchars($_POST['email']));


if(empty($username)){
die("Fill in a username!<br>");
}


if(empty($password)){
die("Fill in a password!<br>");
}


if(empty($pass_conf)){
die("Confirm your password!<br>");
}


if(empty($email)){
die("Fill in your email!");
}


$user_check = mysqli_query($con, "SELECT `username` FROM `users` WHERE `username` = '$username'") or die(mysqli_error($con));
$do_user_check = mysqli_num_rows($user_check);


$email_check = mysqli_query($con, "SELECT `email` FROM `users` WHERE `email` = '$email'") or die(mysqli_error($con));
$do_email_check = mysqli_num_rows($email_check);

if($do_user_check > 0){
die("Username is already in use!<br>");
}


if($do_email_check > 0){
die("Email is already in use!");
}


if($password != $pass_conf){
die("Confirmation password is not equal!");
}

date_default_timezone_set('Europe/London');
$timestamp = date('Y-m-d H:i:s');

$ip = mysqli_real_escape_string($con, htmlspecialchars($_SERVER['REMOTE_ADDR']));

$insert = mysqli_query($con, "INSERT INTO `users` (username, password, email, date, ip) VALUES ('$username', '$password', '$email', '$timestamp', '$ip')") or die(mysqli_error($con));

if(!$insert){
die("There's little problem: ".mysqli_error());
}

header("Location: ../signin.php?action=registered");

?> 