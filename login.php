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

	    <title> Exploit Generator - Login</title>

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

						<i class="fa fa-refresh fa-spin m-right-xs"></i> <?php echo $website;?><strong class="text-skin"></strong>

					</div>



					<form action="lib/login.php" method="POST">

						<div class="form-group m-bottom-md">

							<input type="text" class="form-control" id="username" name="username"  placeholder="Username">

						</div>

						<div class="form-group">

							<input type="password" class="form-control" id="password" name="password" placeholder="Password">

						</div>



						<div class="form-group">

							<div class="custom-checkbox">

								<input type="checkbox" id="chkRemember">

								<label for="chkRemember"></label>

							</div>

							Remember me

						</div>



						<div class="m-top-md p-top-sm">

							<center><button class="btn btn-success block">Sign in</button></center>

						</div>

					</form>

						<div class="m-top-md p-top-sm">

							<div class="font-12 text-center m-bottom-xs">Do not have an account?</div>

						<form action="signup.php">

							<center><button class="btn btn-default block">Create an account</button></center>

						</form>

						</div>

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

