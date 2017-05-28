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


$totalaccounts = 0;

$accountsquery = mysqli_query($con, "SELECT * FROM `accounts`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($accountsquery)) {

$countaccountquery = mysqli_query($con, "SELECT * FROM `$row[name]`") or die(mysqli_error($con));
$totalaccounts = $totalaccounts + mysqli_num_rows($countaccountquery);

}

$subscriptionquery = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username'") or die(mysqli_error($con));
if (mysqli_num_rows($subscriptionquery) < 1) {
$subscription = "0";
} else {
$subscription = "1";

while($row = mysqli_fetch_assoc($subscriptionquery)) {
$subscriptiondate = $row["date"];
$subscriptionprice = $row["price"];
$subscriptionpayment = $row["payment"];
$package = $row["package"];
$subscriptionexpires = $row["expires"];
$packagequery = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$package'") or die(mysqli_error($con));
while($row1 = mysqli_fetch_array($packagequery)){
$subscriptionpackage = $row1['name'];
}
}

}
include "inc/header.php"
?>

<!DOCTYPE html>
<html lang="en">
  	
<head>
	    <meta charset="utf-8">
	    <title><?php echo $website; ?> - Profile</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <!-- Bootstrap core CSS -->
	    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Font Awesome -->
		<link href="css/font-awesome.min.css" rel="stylesheet">

		<!-- ionicons -->
		<link href="css/ionicons.min.css" rel="stylesheet">
		
		<!-- Datepicker -->
		<link href="css/datepicker.css" rel="stylesheet"/>	

		<!-- Owl Carousel -->
		<link href="css/owl.carousel.min.css" rel="stylesheet">
		<link href="css/owl.theme.default.min.css" rel="stylesheet">

		<!-- Simplify -->
		<link href="css/simplify.min.css" rel="stylesheet">
	
  	</head>

  	<body class="overflow-hidden">
		<div class="wrapper preload">
			<?php include 'inc/navbar.php' ?>
			<div class="main-container">
				<div class="padding-md">
					<h3 class="header-text m-bottom-md">
						User Profile
						<span class="sub-header">
							Welocome back, <?php echo $_SESSION['username']; ?>
						</span>
					</h3>

					<div class="row user-profile-wrapper">
						<div class="col-md-3 user-profile-sidebar m-bottom-md">
							<div class="row">
								<div class="col-sm-4 col-md-12">
									<div class="user-profile-pic">
										<img src="images/profile/profile1.jpg" alt="">
									</div>
								</div>
								<div class="col-sm-6 col-md-12">
									<div class="user-name m-top-sm"><?php echo $_SESSION['username']; ?><i class="fa fa-circle text-success m-left-xs font-14"></i></div>

								</div>
							</div><!-- ./row -->
						</div><!-- ./col -->
						<div class="col-md-9">
							<div class="smart-widget">
								<div class="smart-widget-inner">
									<ul class="nav nav-tabs tab-style2 tab-right bg-grey">		
								  		<li class="active">
								  			<a href="#profileTab2" data-toggle="tab">
								  				<span class="icon-wrapper"><i class="fa fa-book"></i></span>
								  				<span class="text-wrapper">Account</span>
								  			</a>
								  		</li>
									</ul>
									<div class="smart-widget-body">
										<div class="tab-content">
											<div class="tab-pane fade in active" id="profileTab2">
												<h4 class="header-text m-top-md">General Information</h4>
												<span class="form-horizontal m-top-md">
													<div class="form-group">
													    <label class="col-sm-3 control-label">Username</label>
													    <div class="col-sm-9">
													      	<input type="text" class="form-control" value="<?php echo $_SESSION['username']; ?>" readonly>
													    </div>
													</div>
													<form action="lib/changepassword.php" method="POST">
													<div class="form-group">
													    <label class="col-sm-3 control-label">Password</label>
													    <div class="col-sm-9">
													      	<input type="password" id="password" name="password" class="form-control" required>
													    </div>
													</div>
													
														<div class="form-group m-top-m">
													    <label class="col-sm-3 control-label"></label>
													    <div class="col-sm-9">
													      	<button class="btn btn-info m-left-xs">Update password</button>
													    </div>
													</div>
													</form>
													<form action="lib/changeemail.php" method="POST">
													<div class="form-group">
													    <label class="col-sm-3 control-label">Mail Address</label>
													    <div class="col-sm-9">
													      	<input type="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" required>
													    </div>
													</div>

													<div class="form-group m-top-m">
													    <label class="col-sm-3 control-label"></label>
													    <div class="col-sm-9">
													      	<button class="btn btn-info m-left-xs">Update Mail Address</button>
													    </div>
													</div>	
													</form>							
												</span>
											</div><!-- ./tab-pane -->
										</div><!-- ./tab-content -->
									</div><!-- ./smart-widget-body -->
								</div><!-- ./smart-widget-inner -->
							</div><!-- ./smart-widget -->
						</div>
					</div>
				</div><!-- ./padding-md -->
			</div><!-- /main-container -->
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

		<!-- Easy Pie Chart -->
		<script src='js/jquery.easypiechart.min.js'></script>

		<!-- Owl Carousel -->
		<script src='js/owl.carousel.min.js'></script>

		<!-- Datepicker -->
		<script src='js/uncompressed/datepicker.js'></script>

		<!-- Modernizr -->
		<script src='js/modernizr.min.js'></script>
		
		<!-- Simplify -->
		<script src="js/simplify/simplify.js"></script>

		<script>
			$(function()	{
				$('.chart-skill-red').easyPieChart({
			        barColor: '#fc8675',
			        lineWidth: '5'
			    });

			    $('.chart-skill-blue').easyPieChart({
			        barColor: '#65C3DF',
			        lineWidth: '5'
			    });

			    $('.chart-skill-green').easyPieChart({
			        barColor: '#1dc499',
			        lineWidth: '5'
			    });

			    $('.chart-skill-purple').easyPieChart({
			        barColor: '#a48ad4',
			        lineWidth: '5'
			    });
			});
		</script>
	
  	</body>

</html>