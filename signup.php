<?php
include 'inc/database.php';

if (!isset($_SESSION)) { session_start(); }

if (isset($_SESSION['username'])) {
echo '
<script language="javascript">
    window.location.href = "index.php"
</script>
';
}

$checksettings = mysqli_query($con, "SELECT * FROM `settings` LIMIT 1") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($checksettings)){
$website = $row['website'];
$paypal = $row['paypal'];
}

?>

<!DOCTYPE html>
<html lang="en">
  	
<head>
	    <meta charset="utf-8">
	    <title><?php echo $website;?> - Register</title>
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

  	<body class="overflow-hidden light-background">
		<div class="wrapper no-navigation preload">
			<div class="sign-in-wrapper">
				<div class="sign-in-inner">
					<div class="login-brand text-center">
						<i class="fa fa-refresh fa-spin m-right-xs"></i> <strong class="text-skin"><?php echo $website;?></strong>
					</div>

					<form action="lib/register.php" method="POST">
						<div class="form-group m-bottom-md">
							<input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
						</div>
						<div class="form-group m-bottom-md">
							<input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
						</div>
						<div class="form-group">
							<input type="password" id="password" name="password" minlength="4" class="form-control" placeholder="Password" required>
						</div>
						<div class="form-group">
							<input type="password" id="password_conf" name="password_conf" class="form-control" placeholder="Confirm Password" required>
						</div>
						<div class="form-group">
							<div class="custom-checkbox">
								<input type="checkbox" id="chkAccept" required>
								<label for="chkAccept"></label>
							</div>
							I accept the agreement
						</div>
					
						<div class="m-top-md p-top-sm">
							<center><button class="btn btn-success block">Create an accounts</button></center>
						</div>
					</form>
					<form action="login.php" method="POST">
						<div class="m-top-md p-top-sm">
							<div class="font-12 text-center m-bottom-xs">Already have an account?</div>
							<center><button href="signin.html" class="btn btn-default block">Sign In</button></center>
						</div>
					</form>
				</div><!-- ./sign-in-inner -->
			</div><!-- ./sign-in-wrapper -->
		</div><!-- /wrapper -->

		<a href="#" id="scroll-to-top" class="hidden-print"><i class="icon-chevron-up"></i></a>

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
