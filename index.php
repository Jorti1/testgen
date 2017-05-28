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
}

include 'inc/header.php';

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

?>

<!DOCTYPE html>
<html lang="en">
  	
<head>
	    <meta charset="utf-8">
	    <title><?php echo $website;?> - Dashboard</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <!-- Bootstrap core CSS -->
	    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Font Awesome -->
		<link href="css/font-awesome.min.css" rel="stylesheet">

		<!-- ionicons -->
		<link href="css/ionicons.min.css" rel="stylesheet">
		
		<!-- Morris -->
		<link href="css/morris.css" rel="stylesheet"/>	

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

  	<body class="overflow-hidden">
		<div class="wrapper preload">
<?php include 'inc/navbar.php' ?>
			
			<div class="main-container">
				<div class="padding-md">
					<div class="row">
						<div class="col-sm-6">
							<div class="page-title">
								Dashboard
							</div>
							<div class="page-sub-header">
								Welcome Back, <?php echo $_SESSION['username'];?>
							</div>
						</div>
					</div>

					<div class="row m-top-md">
						<div class="col-lg-3 col-sm-6">
							<div class="statistic-box bg-danger m-bottom-md">
								<div class="statistic-title">
									Total Accounts
								</div>

								<div class="statistic-value">
									<?php echo $totalaccounts;?>
								</div>

								<div class="m-top-md">11% Higher than last week</div>

								<div class="statistic-icon-background">
									<i class="ion-eye"></i>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-sm-6">
							<div class="statistic-box bg-info m-bottom-md">
								<div class="statistic-title">
									Generated Accounts
								</div>

								<div class="statistic-value">
									<?php echo $generated;?>
								</div>

								<div class="m-top-md">8% Higher than last week</div>

								<div class="statistic-icon-background">
									<i class="ion-stats-bars"></i>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-sm-6">
							<div class="statistic-box bg-purple m-bottom-md">
								<div class="statistic-title">
									Account Quality
								</div>

								<div class="statistic-value">
									100%
								</div>

								<div class="m-top-md">3% Higher than last week</div>

								<div class="statistic-icon-background">
									<i class="ion-person-add"></i>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-sm-6">
							<div class="statistic-box bg-success m-bottom-md">
								<div class="statistic-title">
									Subscription
								</div>

								<div class="top-md"><?php
            if ($subscription != "1") {
                echo 'You do not have a subscription, please visit the "Purchase" page.';
            } else {
                echo '
                        Package: '.$subscriptionpackage.'</br>
                        Expires: '.$subscriptionexpires.'</br>
            Date: '.$subscriptiondate.'</br>
            Price: $'.$subscriptionprice.'</br>
            Payment: '.$subscriptionpayment;
            }
            ?></div>

								<div class="statistic-icon-background">
									<i class="ion-ios7-cart-outline"></i>
								</div>
							</div>
						</div>
					</div>

<div class="smart-widget">
						<div class="smart-widget-inner">
							<ul class="nav nav-tabs tab-style2">
								<li class="active">
							  		<a href="#style2Tab1" data-toggle="tab">
							  			<span class="icon-wrapper"><i class="fa fa-lightbulb-o"></i></span>
							  			<span class="text-wrapper">News</span>
							  		</a>
							  	</li>
							</ul>
							<div class="smart-widget-body">
								<div class="tab-content">
									<div class="tab-pane fade in active" id="style2Tab1">
										                                    <?php
$result = mysqli_query($con, "SELECT * FROM `news` ORDER BY `id` DESC") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
echo '
            <blockquote>
                <p>'.$row['message'].'</p>
                <p><small>'.$row['writer'].' ('.$row['date'].')</small></p>
            </blockquote>
';
}
?> 									</div><!-- ./tab-pane -->
								</div><!-- ./tab-content -->
							</div>
						</div>
					</div>

				</div><!-- ./padding-md -->
			</div><!-- /main-container -->

<?php include 'inc/footer.php' ?>
		</div><!-- /wrapper -->

		<a href="#" class="scroll-to-top hidden-print"><i class="fa fa-chevron-up fa-lg"></i></a>

		<!-- Delete Widget Confirmation -->
		
	    <!-- Le javascript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
		
		<!-- Jquery -->
		<script src="js/jquery-1.11.1.min.js"></script>
		
		<!-- Bootstrap -->
	    <script src="bootstrap/js/bootstrap.min.js"></script>
	  
		<!-- Flot -->
		<script src='js/jquery.flot.min.js'></script>

		<!-- Slimscroll -->
		<script src='js/jquery.slimscroll.min.js'></script>
		
		<!-- Morris -->
		<script src='js/rapheal.min.js'></script>	
		<script src='js/morris.min.js'></script>	

		<!-- Datepicker -->
		<script src='js/uncompressed/datepicker.js'></script>

		<!-- Sparkline -->
		<script src='js/sparkline.min.js'></script>

		<!-- Skycons -->
		<script src='js/uncompressed/skycons.js'></script>
		
		<!-- Popup Overlay -->
		<script src='js/jquery.popupoverlay.min.js'></script>

		<!-- Easy Pie Chart -->
		<script src='js/jquery.easypiechart.min.js'></script>

		<!-- Sortable -->
		<script src='js/uncompressed/jquery.sortable.js'></script>

		<!-- Owl Carousel -->
		<script src='js/owl.carousel.min.js'></script>

		<!-- Modernizr -->
		<script src='js/modernizr.min.js'></script>
		
		<!-- Simplify -->
		<script src="js/simplify/simplify.js"></script>
		<script src="js/simplify/simplify_dashboard.js"></script>


		<script>
			$(function()	{
				$('.chart').easyPieChart({
					easing: 'easeOutBounce',
					size: '140',
					lineWidth: '7',
					barColor: '#7266ba',
					onStep: function(from, to, percent) {
						$(this.el).find('.percent').text(Math.round(percent));
					}
				});

				$('.sortable-list').sortable();

				$('.todo-checkbox').click(function()	{
					
					var _activeCheckbox = $(this).find('input[type="checkbox"]');

					if(_activeCheckbox.is(':checked'))	{
						$(this).parent().addClass('selected');					
					}
					else	{
						$(this).parent().removeClass('selected');
					}
				
				});

				//Delete Widget Confirmation
				$('#deleteWidgetConfirm').popup({
					vertical: 'top',
					pagecontainer: '.container',
					transition: 'all 0.3s'
				});
			});
			
		</script>
	
  	</body>
	
</html>
