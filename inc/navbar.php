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

?>
			<header class="top-nav">
				<div class="top-nav-inner">
					<div class="nav-header">						
						<?php include "inc/header.php" ?>
						
						<a href="#" class="brand">
							<i class="fa fa-refresh fa-spin"></i><span class="brand-name"><?php echo $website;?></span>
						</a>
					</div>
					<div class="nav-container">
						<button type="button" class="navbar-toggle pull-left sidebar-toggle" id="sidebarToggleLG">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<div class="pull-right m-right-sm">
							<div class="user-block hidden-xs">
								<a href="#" id="userToggle" data-toggle="dropdown">
									<img src="images/profile/profile1.jpg" alt="" class="img-circle inline-block user-profile-pic">
									<div class="user-detail inline-block">
										<?php echo $_SESSION['username'];?>
										<i class="fa fa-angle-down"></i>
									</div>
								</a>
								<div class="panel border dropdown-menu user-panel">
									<div class="panel-body paddingTB-sm">
										<ul>
											<li>
												<a href="profile.php">
													<i class="fa fa-edit fa-lg"></i><span class="m-left-xs">My Profile</span>
												</a>
											</li>
											<li>
												<a href="lib/logout.php">
													<i class="fa fa-power-off fa-lg"></i><span class="m-left-xs">Sign out</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- ./top-nav-inner -->	
			</header>
			<aside class="sidebar-menu fixed">
				<div class="sidebar-inner scrollable-sidebar">
					<div class="main-menu">
						<ul class="accordion">
							<li class="menu-header">
								Main Menu
							</li>
							<li class="bg-palette1 active">
								<a href="index.php">
									<span class="menu-content block">
										<span class="menu-icon"><i class="block fa fa-home fa-lg"></i></span>
										<span class="text m-left-sm">Home</span>
									</span>
									<span class="menu-content-hover block">
										Home
									</span>
								</a>
							</li>
							<li class="bg-palette2">
								<a href="purchase.php">
									<span class="menu-content block">
										<span class="menu-icon"><i class="block fa fa-usd fa-lg"></i></span>
										<span class="text m-left-sm">Purchase</span>
									</span>
									<span class="menu-content-hover block">
										Buy
									</span>
								</a>
							</li>
							<li class="bg-palette3">
								<a href="generator.php">
									<span class="menu-content block">
										<span class="menu-icon"><i class="block fa fa-refresh fa-spin fa-lg"></i></span>
										<span class="text m-left-sm">Generator</span>
									</span>
									<span class="menu-content-hover block">
										Generate
									</span>
								</a>
							</li>
							<li class="bg-palette4">
								<a href="support.php">
									<span class="menu-content block">
										<span class="menu-icon"><i class="block fa fa-question fa-lg"></i></span>
										<span  class="text m-left-sm">Support (Créating)</span>
									</span>
									<span class="menu-content-hover block">
										Support
									</span>
								</a>
							</li>
							<?php
            if (($_SESSION['rank']) == "5") {
                            echo '
							<li class="openable bg-palette3">
								<a href="#">
									<span class="menu-content block">
										<span class="menu-icon"><i class="block fa fa-ban fa-lg"></i></span>
										<span class="text m-left-sm">Administration</span>
										<span class="submenu-icon"></span>
									</span>
									<span class="menu-content-hover block">
										Admin
									</span>
								</a>
								<ul class="submenu bg-palette4">
									<li><a href="admin-manage.php"><span class="submenu-label">Manage</span></a></li>
									<li><a href="admin-support.php"><span class="submenu-label">Support</span></a></li>
									<li><a href="admin-users.php"><span class="submenu-label">Users</span></a></li>
									<li><a href="admin-subscriptions.php"><span class="submenu-label">Subscriptions</span></a></li>
								</ul>
							</li>'; }
                    ?>
						</ul>
					</div>	
					<div class="sidebar-fix-bottom clearfix">
						<a href="lib/logout.php" class="pull-right font-18"><i class="ion-log-out"></i></a>
					</div>
				</div><!-- sidebar-inner -->
			</aside>