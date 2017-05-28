<?php

ini_set("log_errors", 1);
ini_set("error_log", "log.txt");

include "../inc/database.php";

if($_GET){
file_put_contents('log.txt', $_GET);
}

$getsecret = mysqli_query($con, "SELECT * FROM `settings` LIMIT 1") or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($getsecret))
{
  $secret = $row['secret'];
  $bitcoin = $row['bitcoin'];
}

$transaction = $_GET['transaction'];
$transaction_hash = $_GET['transaction_hash'];
$satoshi = $_GET['value'];
$btc = $satoshi / 100000000;

if ($_GET['test'] == true) {
  echo "This is a test";
  exit();
}

$getorder = mysqli_query($con, "SELECT * FROM `orders` WHERE `transaction` = '$transaction'") or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($getorder))
{
  $btcamount = $row['amount'];
  $price = $row['price'];
  $username = $row['username'];
  $package = $row['package'];
}

if(isset($_GET["anonymous"], $_GET["secret"]) && $_GET["secret"] == $secret && $_GET["destination_address"] == $bitcoin && $btc == $btcamount) {
        if($value == $price) {
                if($_GET["confirmations"] >= 1) {

			file_put_contents('log.txt', 'Success');
			
			$checkpackage = mysqli_query($con,"SELECT * FROM `packages` WHERE `id` = '$package'");

			if(mysqli_num_rows($checkpackage) < "1")
			{
				file_put_contents('log.txt', 'Package does not exist');
				exit();
			}

			while ($row = mysqli_fetch_array($checkpackage)) 
			{
				$length = $row['length'];
			}

			$today = time();

			if($length == "Lifetime"){
				$expiresdate = strtotime("100 years", $today);
			}elseif($length == "1 Day"){
				$expiresdate = strtotime("+1 day", $today);
			}elseif($length == "3 Days"){
				$expiresdate = strtotime("+3 days", $today);
			}elseif($length == "1 Week"){
				$expiresdate = strtotime("+1 week", $today);
			}elseif($length == "1 Month"){
				$expiresdate = strtotime("+1 month", $today);
			}elseif($length == "2 Months"){
				$expiresdate = strtotime("+2 months", $today);
			}elseif($length == "3 Months"){
				$expiresdate = strtotime("+3 months", $today);
			}elseif($length == "4 Months"){
				$expiresdate = strtotime("+4 months", $today);
			}elseif($length == "5 Months"){
				$expiresdate = strtotime("+5 months", $today);
			}elseif($length == "6 Months"){
				$expiresdate = strtotime("+6 months", $today);
			}elseif($length == "7 Months"){
				$expiresdate = strtotime("+7 months", $today);
			}elseif($length == "8 Months"){
				$expiresdate = strtotime("+8 months", $today);
			}elseif($length == "9 Months"){
				$expiresdate = strtotime("+9 months", $today);
			}elseif($length == "10 Months"){
				$expiresdate = strtotime("+10 months", $today);
			}elseif($length == "11 Months"){
				$expiresdate = strtotime("+11 months", $today);
			}elseif($length == "12 Months"){
				$expiresdate = strtotime("+12 months", $today);
			}else{
			exit();
			}

			$expires = date('Y-m-d', $expiresdate);
			$date = date("Y-m-d");
			mysqli_query($con, "INSERT INTO `subscriptions` (`username`, `date`, `price`, `btc`, `payment`, `package`, `expires`, `txn_id`, `active`) VALUES ('$username', DATE('$date'), '$price', '$btcamount', 'Bitcoin', '$package', DATE('$expires'), '$transaction_hash', '1')") or die(mysqli_error($con));
			mysqli_query($con, "UPDATE `orders` SET `paid` = '1' WHERE `transaction` = '$transaction'") or die(mysqli_error($con));

                        echo "*ok*";
                }
        }
}elseif($_GET["secret"] != $secret){
echo "Wrong Secret";
file_put_contents('log.txt', 'Wrong Secret');
}elseif($_GET["destination_address"] != $bitcoin){
echo "Wrong Destination Address";
file_put_contents('log.txt', 'Wrong Destination Address');
}elseif($btc != $btcamount){
echo "Wrong Amount";
file_put_contents('log.txt', 'Wrong Amount');
}else{
echo "Unknown Issue";
}

?>