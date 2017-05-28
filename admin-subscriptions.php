<?php

if (!isset($_SESSION)) { session_start(); }

if (!isset($_SESSION['username'])) {
echo '
<script language="javascript">
    window.location.href = "login.php"
</script>
';
exit();
}
if ($_SESSION['rank'] < "5") {
echo '
<script language="javascript">
    window.location.href = "../index.php"
</script>
';
exit();
}

include 'inc/header.php';

if (isset($_GET)){
if ($_GET['deletesubscription']){
$id = strip_tags($_GET['deletesubscription']);
mysqli_query($con, "DELETE FROM `subscriptions` WHERE `id` = '$id'") or die(mysqli_error($con));
}
}

if(isset($_POST)){
if ($_POST['editsubscription']){
$id = strip_tags($_POST['editsubscription']);
if (isset($_POST['package'])){
$newpackage = $_POST['package'];
mysqli_query($con,"UPDATE `subscriptions` SET `package` = '$newpackage' WHERE `id` = '$id'") or die(mysqli_error($con));
}
if (isset($_POST['expires'])){
$newexpires = $_POST['expires'];
mysqli_query($con,"UPDATE `subscriptions` SET `expires` = DATE('$newexpires') WHERE `id` = '$id'") or die(mysqli_error($con));
}
}

if ($_POST['action'] == "addsubscription"){
$username = mysqli_real_escape_string($con, $_POST['username']);
$package = mysqli_real_escape_string($con, $_POST['package']);

$checkpackage = mysqli_query($con,"SELECT * FROM `packages` WHERE `id` = '$package'");
while ($row = mysqli_fetch_array($checkpackage)) 
{
    $length = $row['length'];
}

$today = time();

if($length == "Lifetime"){
    $expires = strtotime("+9 year", $today);
}elseif($length == "1 Day"){
    $expires = strtotime("+1 day", $today);
}elseif($length == "3 Days"){
    $expires = strtotime("+3 days", $today);
}elseif($length == "1 Week"){
    $expires = strtotime("+1 week", $today);
}elseif($length == "1 Month"){
    $expires = strtotime("+1 month", $today);
}elseif($length == "2 Months"){
    $expires = strtotime("+2 months", $today);
}elseif($length == "3 Months"){
    $expires = strtotime("+3 months", $today);
}elseif($length == "4 Months"){
    $expires = strtotime("+4 months", $today);
}elseif($length == "5 Months"){
    $expires = strtotime("+5 months", $today);
}elseif($length == "6 Months"){
    $expires = strtotime("+6 months", $today);
}elseif($length == "7 Months"){
    $expires = strtotime("+7 months", $today);
}elseif($length == "8 Months"){
    $expires = strtotime("+8 months", $today);
}elseif($length == "9 Months"){
    $expires = strtotime("+9 months", $today);
}elseif($length == "10 Months"){
    $expires = strtotime("+10 months", $today);
}elseif($length == "11 Months"){
    $expires = strtotime("+11 months", $today);
}elseif($length == "12 Months"){
    $expires = strtotime("+12 months", $today);
}else{
}

$expires = date('Y-m-d', $expires);
$date = date("Y-m-d");
mysqli_query($con, "INSERT INTO `subscriptions` (`username`, `date`, `price`, `payment`, `package`, `expires`) VALUES ('$username', DATE('$date'), '0.00', 'Gift', '$package', '$expires')") or die(mysqli_error($con));
}

}

?>

<!DOCTYPE html>
<html lang="en">
  	
<head>
  		<meta charset="utf-8">
    	<title><?php echo $website;?> - Support Admin</title>
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
        
                    <div class="row">
                    <div class="col-md-11 well" style="margin-left: 10px;">
                        <legend>Subscriptions</legend>
  <div class="container">
    <div class="row">

        <div class="col-md-10">
        <div class="table-responsive">

              <table id="mytable" class="table table-bordred table-striped">

<div id="collapse">

        <button class="btn btn-default btn-large btn-block" data-toggle="collapse" data-target="#addsubscription" data-parent="#collapse">Add Subscription</button></br>

<div id="addsubscription" class="sublinks collapse">
<legend></legend>
<form action="admin-subscriptions.php" method="POST">
<input type="hidden" name="action" value="addsubscription"/>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Username</span>
        <input type="text" name="username" class="form-control" style="width: 815px;" placeholder="username">
    </div>
</div>
<select name="package" class="form-control" style="width: 945px;">
<?php
$packagesquery = mysqli_query($con, "SELECT * FROM `packages`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($packagesquery)){
echo '<option value="'.$row[id].'">'.$row[name].'</option>';
}
?>
</select></br>
<button type="submit" class="btn btn-default btn-large btn-block">Add Subscription</button></br>
</form>


</div>

        <legend></legend>
              

        <div class="input-group"> <span class="input-group-addon">Filter</span>
            <input id="filter" type="text" class="form-control">
        </div>
                   
                   <thead>
                     <th>Username</th>
                     <th>Date</th>
                     <th>Price</th>
                     <th>Payment</th>
                     <th>Package</th>
                     <th>Expires</th>
                     <th>Transaction ID</th>
                     <th>Edit</th>
                     <th>Delete</th>
                   </thead>
    <tbody class="searchable">
<div id="menu">
<?php
$result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `active` = '1'") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
    echo '<tr>';
    echo '<td>' . $row['username'] . '</td>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td>$' . $row['price'] . '</td>';
    echo '<td>' . $row['payment'] . '</td>';

    $packagequery = mysqli_query($con, "SELECT * FROM `packages` WHERE `id` = '$row[package]'") or die(mysqli_error($con));
    while ($packageinfo = mysqli_fetch_array($packagequery)) {
    echo '<td>' . $packageinfo['name'] . '</td>';
    }

    echo '<td>' . $row['expires'] . '</td>';
    if(strlen($row['txn_id']) > 17){ $row['txn_id'] = substr($row['txn_id'], 0, 17)."...";}
    echo '<td>' . $row['txn_id'] . '</td>';
    echo '<td><p><a class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#subscription'.$row['id'].'" data-parent="#menu"><span class="glyphicon glyphicon-pencil"></span></a></p></td>';
    echo '<td><p><a class="btn btn-danger btn-xs" href="admin-subscriptions.php?deletesubscription=' . $row['id'] . '" data-title="Delete"><span class="glyphicon glyphicon-trash"></span></a></p></td>';
    echo '</tr>';
    echo '
<div id="subscription'.$row['id'].'" class="sublinks collapse">
<form action="admin-subscriptions.php" method="POST">
<legend></legend>
<input type="hidden" id="editsubscription" name="editsubscription" value="'.$row['id'].'"/>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Package</span>
        <select name="package" class="form-control" style="width: 815px;">';
$result1 = mysqli_query($con, "SELECT * FROM `packages`") or die(mysqli_error($con));
while ($row1 = mysqli_fetch_array($result1)) {
            echo '<option value="'.$row1['id'].'" ';
if($row['package'] == $row1['id']){echo 'selected';}
echo '>'.$row1['name'].'</option>';
}
echo '      </select>
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Expires</span>
        <input type="date" name="expires" class="form-control" style="width: 815px;" value="'.$row['expires'].'">
    </div>
</div>
<button class="btn btn-default btn-block" type="submit">Edit Subscription</button></br>
<legend></legend>
</form>
</div>';

}
?>
     
    </tbody>
        
</table>

    </div>
            
        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

<script>
$(document).ready(function () {

    (function ($) {

        $('#filter').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();

        })

    }(jQuery));

});
</script>

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

		<!-- Modernizr -->
		<script src='js/modernizr.min.js'></script>
		
		<!-- Simplify -->
		<script src="js/simplify/simplify.js"></script>

  	</body>

</html>
