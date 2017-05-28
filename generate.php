<?php

$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($pos===false){
  die('No Access');
}

include 'inc/database.php';
$date = date("Y-m-d");
$account = strip_tags($_GET['account']);
$username = strip_tags($_GET['username']);

$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)){
$package = $row['package'];
}

$result = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$package'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)){
$accounts = $row['accounts'];
}


if($accounts != "0" && $accounts != ""){
$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)){
if($row['generated'] >= $accounts){
exit("Generated max per day");
}
}
}

$result = mysqli_query($con, "SELECT * FROM `$account` ORDER BY RAND() LIMIT 1") or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)){
echo $row['alt'];
}

$result = mysqli_query($con, "SELECT * FROM `settings`") or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)){
$generated = $row['generated'] + "1";
mysqli_query($con, "UPDATE `settings` SET `generated` = '$generated'") or die(mysqli_error($con));
}

$date = date("Y-m-d");

$result = mysqli_query($con, "SELECT * FROM `statistics` WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
if(mysqli_num_rows($result) == "0"){
mysqli_query($con, "INSERT INTO `statistics` (`username`, `generated`, `date`) VALUES ('$username', '1', DATE('$date'))") or die(mysqli_error($con));
}else{
while($row = mysqli_fetch_array($result)){
$generated = $row['generated'] + "1";
mysqli_query($con, "UPDATE `statistics` SET `generated` = '$generated' WHERE `username` = '$username' AND `date` = '$date'") or die(mysqli_error($con));
}
}
?>