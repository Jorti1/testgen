<?php

include 'inc/database.php';

if (!isset($_SESSION)) { session_start(); }

if (!isset($_SESSION['username'])) {
echo '
<script language="javascript">
    window.location.href = "login.php"
</script>
';
exit();
}

$username = $_SESSION['username'];

$checksubscription = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `active` = '1'") or die(mysqli_error($con));
if (mysqli_num_rows($checksubscription) < 1) {
$subscription = "0";
}

include 'inc/header.php';

if(isset($_POST['purchase'])){

$id = $_POST['purchase'];

$pricequery = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$id'") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($pricequery)) {
    $price = $row['price'];
    $packagename = $row['name']." - ".$website;
    $custom = $row['id']."|".$username;
}

$paypalurl = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&amount=".urlencode($price)."&business=".urlencode($paypal)."&page_style=primary&item_name=".urlencode($packagename)."&return=http://".htmlspecialchars($_SERVER['HTTP_HOST'])."/index.php?action=buy-success"."&rm=2&notify_url=http://".htmlspecialchars($_SERVER['HTTP_HOST'])."/lib/ipn.php"."&cancel_return=http://".htmlspecialchars($_SERVER['HTTP_HOST'])."/index.php?action=buy-error&custom=".urlencode($custom)."&mc_currency=USD";

echo '<script> location.replace("'.$paypalurl.'"); </script>';

}

?>

<!DOCTYPE html>
<html lang="en">
  	
<head>
	    <meta charset="utf-8">
	    <title><?php echo $website;?> - Purchase</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <!-- Bootstrap core CSS -->
	    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Font Awesome -->
		<link href="css/font-awesome.min.css" rel="stylesheet">

		<!-- ionicons -->
		<link href="css/ionicons.min.css" rel="stylesheet">

		<!-- Simplify -->
		<link href="css/simplify.min.css" rel="stylesheet">
	
  	</head>

  	<body class="overflow-hidden">
		<div class="wrapper preload">
			<?php include 'inc/navbar.php' ?>
			<div class="main-container">
				<div class="padding-md">
					<h3 class="header-text">
						Pricing Table
					</h3>

					
<?php
$packagequery = mysqli_query($con, "SELECT * FROM `packages` order by price") or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($packagequery)){
$accountquery = mysqli_query($con, "SELECT * FROM `accounts` WHERE `id` = '$row[generator]'") or die(mysqli_error($con));
while($row1 = mysqli_fetch_array($accountquery)){
$accountname = $row1['name'];
}
if($row['generator'] == ""){
$accountname = "All";
}
if($row['accounts'] == "0" || $row['accounts'] == ""){
$accounts = "Unlimited";
}else{
$accounts = $row['accounts']."/day";
}
echo '
                    <div class="col-md-3 col-sm-6">
							<div class="pricing-widget clean-pricing">
								<div class="pricing-type bg-info text-center">'.$row['name'].'</div>
																<div class="pricing-value bg-grey">
									<span class="value">$'.$row['price'].'</span>
								</div>
								<ul class="pricing-service m-top-sm">
									<li>Generator(s): <span class="font-semi-bold">'.$accountname.'</span></li>
									<li>Length: <span class="font-semi-bold">'.$row['length'].'</span></li>
									<li>Accounts: <span class="font-semi-bold">'.$accounts.'</span></li>
								</ul>
            <form method="POST" action="purchase.php">
            <input type="hidden" name="purchase" value="'.$row['id'].'"/>
            <div class="m-top-md m-bottom-md text-center">
            <button type="submit" class="btn btn-info btn-block" ';
if ($subscription != "0" || $_SESSION['rank'] == "5"){
echo "disabled";
}
echo '>Purchase with Paypal</button>
            </form>
            <form method="POST" action="purchase-btc.php">
            <input type="hidden" name="purchase" value="'.$row['id'].'"/>
            <button type="submit" class="btn bgm-red btn-large btn-block" ';
if ($subscription != "0" || $_SESSION['rank'] == "5"){
echo "disabled";
}
echo ' disabled>Purchase with BTC</button></div>
            </form>
                    </div><!-- ./pricing-widget -->
						</div>
';
}
?>
					<div class="row m-top-md">

					</div><!-- ./row -->
				</div><!-- ./padding-md -->
			</div><!-- /main-container -->
			<?php include 'inc/footer.php' ?>
		</div><!-- /wrapper -->

		<a href="#" class="scroll-to-top hidden-print"><i class="fa fa-chevron-up fa-lg"></i></a>

	    <!-- Le javascript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
		
		<!-- Jquery -->
		<script src="js/jquery-1.11.1.min.js"></script>
		
		<!-- Bootstrap -->
	    <script src="bootstrap/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll -->
		<script src='js/jquery.slimscroll.min.js'></script>
		
		<!-- Popup Overlay -->
		<script src='js/jquery.popupoverlay.min.js'></script>

		<!-- Modernizr -->
		<script src='js/modernizr.min.js'></script>

		<!-- Simplify -->
		<script src="js/simplify/simplify.js"></script>
	
  	</body>

</html>
