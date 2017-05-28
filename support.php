<?php
include 'inc/database.php';

error_reporting(0);

if (!isset($_SESSION)) { session_start(); }

if (!isset($_SESSION['username'])) {
echo '
<script language="javascript">
    window.location.href = "login.php"
</script>
';
exit();
}

include 'inc/header.php';

$username = $_SESSION['username'];

if (isset($_POST['message']) & isset($_POST['subject']) & isset($_SESSION['username'])) {
$subject = strip_tags($_POST['subject']);
$message = strip_tags($_POST['message']);
$date = date("Y-m-d");
mysqli_query($con, "INSERT INTO `support` (`from`, `to`, `subject`, `message`, `date`) VALUES ('$username', 'admin', '$subject', '$message', DATE('$date'))") or die(mysqli_error($con));
}

?>

<!DOCTYPE html>
<html lang="en">
  	
<head>
  		<meta charset="utf-8">
    	<title><?php echo $website;?> - Support</title>
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
        <section id="main">
        
        
            <section id="content">
                <div class="container">
                    <div class="block-header">
                        <h2>Support</h2>

                    
                    </div>
                

                    <div class="card">
                        <div class="card-header">
                                            <div class="row">
                    <div class="col-md-6 well" style="margin-left: 10px;">
                        <legend>Support Tickets</legend>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="home">
        <div id="menu">
                    <div class="list-group">
<?php
$supportquery = mysqli_query($con, "SELECT * FROM `support` WHERE `to` = '$username' ORDER BY `date` DESC");
while ($row = mysqli_fetch_assoc($supportquery)) {
echo '
    <a href="#" class="list-group-item" data-toggle="collapse" data-target="#message'.$row['id'].'" data-parent="#menu">
        <span class="name" style="min-width: 120px;display: inline-block;">'.$row["from"].'</span> <span class="">'.$row["subject"].'</span>
            <span class="badge">'.$row["date"].'</span> 
        </span>
    </a>
    <div id="message'.$row['id'].'" class="sublinks collapse">
        <textarea class="form-control" rows="8">'.$row['message'].'</textarea>
    </div>
';}
?>
                    </div>
        </div>
        </div>
    </div>

                        </div>
 
            <div class="col-md-5 well" style="margin-left: 10px;">
                        <legend>Submit Support Ticket</legend>
            <form method="POST"/>
            <label>Subject:</label></br>
            <div class="fg-line">
            <input type="text" name="subject" class="form-control input-sm" placeholder="Input Subject" required>
            </div>
            <label>Message:</label></br>

            <textarea name="message" class="form-control" rows="8"></textarea></br>

            <button class="btn btn-success btn-large btn-block">Submit Ticket</button>
            </form>
                    </div>
                        </div>
                    </div>
                
                    </div>
            </section>
        </section>
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
