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

if (isset($_GET['read'])){
$id = $_GET['read'];
mysqli_query($con, "UPDATE `support` SET `read` = '1' WHERE `id` = '$id'") or die(mysqli_error($con));
}

if (isset($_POST['reply']) & isset($_POST['id']) & isset($_POST['to']) & isset($_POST['subject'])){
$reply = $_POST['reply'];
$id = strip_tags($_POST['id']);
$to = strip_tags($_POST['to']);
$subject = $_POST['subject'];
$date = date("Y-m-d");
mysqli_query($con, "INSERT INTO `support` (`from`, `to`, `subject`, `message`, `date`) VALUES ('Admin', '$to', '$subject', '$reply', DATE('$date'))") or die(mysqli_error($con));
mysqli_query($con, "UPDATE `support` SET `read` = '1' WHERE `id` = '$id'") or die(mysqli_error($con));
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
                        <legend>Manage Support Tickets</legend>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="home">
        <div id="menu">
                    <div class="list-group">
<?php
$supportquery = mysqli_query($con, "SELECT * FROM `support` WHERE `to` = 'Admin' ORDER BY `date` DESC") or die(mysqli_error());
while ($row = mysqli_fetch_assoc($supportquery)) {
echo '
    <a href="#" class="list-group-item ';
if($row['read'] != "1"){
echo 'active';
}
echo '" data-toggle="collapse" data-target="#message'.$row[id].'" data-parent="#menu">
        <span class="name" style="min-width: 120px;display: inline-block;">'.$row["from"].'</span> <span class="">'.$row["subject"].'</span>
            <span class="badge">'.$row["date"].'</span> 
        </span>
    </a>
    <div id="message'.$row[id].'" class="sublinks collapse">
        <textarea class="form-control" rows="8" disabled>'.$row[message].'</textarea>
        <form method="POST" action="admin-support.php">
        <textarea name="reply" class="form-control" rows="4"></textarea>
        <input type="hidden" name="id" value="'.$row[id].'"/>
        <input type="hidden" name="to" value="'.$row[from].'"/>
        <input type="hidden" name="subject" value="'.$row[subject].'"/>
        <div class="btn-group">
            <button type="submit" class="btn btn-default btn-large" style="width: 800px;">Send Reply</button>
        </form>
            <a href="admin-support.php?read='.$row[id].'" class="btn btn-success btn-large" style="width: 155px;">Set Read</a>
        </div>
    </div>
';}
?>
                    </div>
        </div>
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

		<!-- Modernizr -->
		<script src='js/modernizr.min.js'></script>
		
		<!-- Simplify -->
		<script src="js/simplify/simplify.js"></script>

  	</body>

</html>
