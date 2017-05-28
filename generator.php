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

$date = date("Y-m-d");

$checksubscription = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username' AND `active` = '1' AND `expires` >= '$date'") or die(mysqli_error($con));
if (mysqli_num_rows($checksubscription) < 1 && $_SESSION['rank'] != "5") {
echo '
<script language="javascript">
    window.location.href = "purchase.php"
</script>
';
exit();
}else{
while($row = mysqli_fetch_assoc($checksubscription)){
$package = $row['package'];
$checkpackage = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$package'") or die(mysqli_error($con));
while($row1 = mysqli_fetch_assoc($checkpackage)){
$generator = $row1['generator'];
}
}
}

include 'inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">
  	
<head>
	    <meta charset="utf-8">
	    <title><?php echo $website;?> - Generator</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


	    <!-- Bootstrap core CSS -->
	    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Font Awesome -->
		<link href="css/font-awesome.min.css" rel="stylesheet">

		<!-- ionicons -->
		<link href="css/ionicons.min.css" rel="stylesheet">
		
		<!-- Datepicker -->
		<link href="css/datepicker.css" rel="stylesheet"/>	

		<!-- Animate -->
		<link href="css/animate.min.css" rel="stylesheet">

		<!-- Owl Carousel -->
		<link href="css/owl.carousel.min.css" rel="stylesheet">
		<link href="css/owl.theme.default.min.css" rel="stylesheet">
		
		<!-- Simplify -->
		<link href="css/simplify.min.css" rel="stylesheet">

  	</head>
<?php include 'inc/navbar.php' ?>
  	<body class="overflow-hidden">
		<div class="wrapper preload">
			
			<div class="main-container">
				<div class="padding-md">
										<div class="row">
						<div class="col-sm-6">
							<div class="page-title">
								Generator
							</div>
							<div class="page-sub-header">
								Welcome Back, <?php echo $_SESSION['username'];?>
							</div>
						</div>
					</div>
					<br>
<div class="row">
<?php

if($generator == ""){
$generatorquery = "SELECT * FROM `accounts`";
}else{
$generatorquery = "SELECT * FROM `accounts` WHERE `id` = ".$generator;
}

$result = mysqli_query($con, $generatorquery) or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
echo '
						<div class="col-lg-4">
							<div class="user-widget user-widget2">
								<div class="user-widget-body bg-success">
										<center><div class="m-top-sm">'.$row["name"].' Generator</div>
                        
				<div class="small-text text-white">Account</div></center>
								</div>
<center></br><i class="fa fa-user"></i> : <i class="fa fa-lock"></i>
				<script>

    				$(document).ready(function(){
        			$("#'.$row['name'].'").click(function(){
         			 $("p[class='.$row["name"].']").load("generate.php?account='.$row["name"].'&username='.$username.'",function(responseTxt,statusTxt,xhr){
            			if(statusTxt=="error")
              			alert("Error: "+xhr.status+": "+xhr.statusText);
          			});
        			});

    				$("#'.$row["name"].'").click();
    				});
    				</script>
				<p class="'.$row["name"].'"></p>
				</center><div class="list-group">
									<a class="list-group-item">
<center><button id="'.$row["name"].'" class="btn btn-success block">Generate</button></center>
									</a></div>
                    </div></div>
';
}
?>
</div>

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

		<!-- Owl Carousel -->
		<script src='js/owl.carousel.min.js'></script>

		<!-- Skycons -->
		<script src='js/uncompressed/skycons.js'></script>

		<!-- Datepicker -->
		<script src='js/uncompressed/datepicker.js'></script>

		<!-- Modernizr -->
		<script src='js/modernizr.min.js'></script>
		
		<!-- Simplify -->
		<script src="js/simplify/simplify.js"></script>


		<script>
			$(function()	{
				//Skycon
				var icons = new Skycons({"color": "white"});
			    icons.set("skycon1", "sleet");
			   
			    icons.play();

			    var iconsSmall = new Skycons({"color": "#777"});
			    iconsSmall.set("skycon-sm1", "partly-cloudy-day");
			    iconsSmall.set("skycon-sm2", "wind");
			    iconsSmall.set("skycon-sm3", "clear-day");

			    iconsSmall.play();

			    //Owl Carousel
			    $('.custom-carousel2').owlCarousel({
				    items:1,
				    loop:true,
				    autoplay:true,
					autoplayTimeout:2000,
					autoplayHoverPause:true,
				    stagePadding:0,
				    smartSpeed:450,
				    dots: false
				});

			    $('.custom-carousel3').owlCarousel({
			    	animateOut: 'fadeOut',
	    			animateIn: 'fadeInDown',
					items:1,
				    loop:true,
				    autoplay:true,
					autoplayTimeout:2000,
					autoplayHoverPause:true,
				    stagePadding:0,
				    smartSpeed:450,
				});

				//Datepicker
				$('#calendar').DatePicker({
					flat: true,
					date: '2014-07-17',
					current: '2014-07-17',
					calendars: 1,
					starts: 1
				});
			});
		</script>
	
  	</body>

</html>
