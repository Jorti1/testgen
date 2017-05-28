<?php

if(file_exists("install.php") == "1"){
header('Location: install.php');
exit();
}

include 'database.php';

if (!isset($_SESSION)) { session_start(); }

$checksettings = mysqli_query($con, "SELECT * FROM `settings` LIMIT 1") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($checksettings)){
$website = $row['website'];
$paypal = $row['paypal'];
$bitcoin = $row['bitcoin'];
$secret = $row['secret'];
$generated = $row['generated'];
}


?>