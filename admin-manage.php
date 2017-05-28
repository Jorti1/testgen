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

if (isset($_POST['accounts']) & isset($_POST['accountname'])){

$accountname = strip_tags($_POST['accountname']);
mysqli_query($con,"DELETE FROM `$accountname`") or die(mysqli_error($con));
$values = htmlspecialchars($_POST['accounts']);
$array = explode("\n", $values);
foreach($array as $line){
$line = mysqli_real_escape_string($con, $line);
if (empty($line)) {
}else{
  mysqli_query($con, "INSERT INTO `$accountname` (`alt`) VALUES ('$line')") or die(mysqli_error($con));
}
}

}

if (isset($_POST['addaccount'])){
$name = mysqli_real_escape_string($con, $_POST['addaccount']);
mysqli_query($con, "CREATE TABLE `$name` (id INT NOT NULL AUTO_INCREMENT,alt VARCHAR(1000),status INT(1) DEFAULT '1',primary key (id))") or die(mysqli_error($con));
mysqli_query($con, "INSERT INTO `accounts` (`name`) VALUES ('$name')") or die(mysqli_error($con));
}

if (isset($_GET['deleteaccount'])){
$name = mysqli_real_escape_string($con, $_GET['deleteaccount']);
mysqli_query($con, "DROP TABLE `$name`") or die(mysqli_error($con));
mysqli_query($con, "DELETE FROM `accounts` WHERE `name` = '$name'") or die(mysqli_error($con));
}

if (isset($_GET['deletepackage'])){
$name = mysqli_real_escape_string($con, $_GET['deletepackage']);
mysqli_query($con, "DELETE FROM `packages` WHERE `name` = '$name'") or die(mysqli_error($con));
}

if (isset($_POST['website']) & isset($_POST['paypal'])){
$website = mysqli_real_escape_string($con, $_POST['website']);
$paypal = mysqli_real_escape_string($con, $_POST['paypal']);
$bitcoin = mysqli_real_escape_string($con, $_POST['bitcoin']);
mysqli_query($con, "UPDATE `settings` SET `website` = '$website'") or die(mysqli_error($con));
mysqli_query($con, "UPDATE `settings` SET `paypal` = '$paypal'") or die(mysqli_error($con));
if (isset($_POST['bitcoin'])){
mysqli_query($con, "UPDATE `settings` SET `bitcoin` = '$bitcoin'") or die(mysqli_error($con));
}
}

if (isset($_POST['name']) & isset($_POST['price']) & isset($_POST['length'])){
$name = mysqli_real_escape_string($con, $_POST['name']);
$price = mysqli_real_escape_string($con, $_POST['price']);
$generator = mysqli_real_escape_string($con, $_POST['generator']);
$accounts = mysqli_real_escape_string($con, $_POST['accounts']);
$length = mysqli_real_escape_string($con, $_POST['length']);
mysqli_query($con, "INSERT INTO `packages` (`name`, `price`, `length`, `generator`, `accounts`) VALUES ('$name', '$price', '$length', '$generator', '$accounts')") or die(mysqli_error($con));
}

if (isset($_POST['message']) & isset($_POST['writer'])){
$message = mysqli_real_escape_string($con, $_POST['message']);
$writer = mysqli_real_escape_string($con, $_POST['writer']);
$date = date("Y-m-d");
mysqli_query($con, "INSERT INTO `news` (`message`, `writer`, `date`) VALUES ('$message', '$writer', DATE('$date'))") or die(mysqli_error($con));
}


if (isset($_POST['file'])){

$target_dir = "/update";
$target_file = $target_dir . basename($_FILES["file"]["name"]);

if(isset($_POST["submit"])) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "<meta http-equiv='refresh' content='5'>";
    } else {
        echo "There was an error uploading the update.";
    }
}

}
?>

<!DOCTYPE html>
<html lang="en">
  	
<head>
  		<meta charset="utf-8">
    	<title><?php echo $website;?> - Admin Dashboard</title>
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
                    <div class="col-md-5 well" style="margin-left: 10px;">
                        <legend>Manage Accounts</legend>
            <div class="container">

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="width: 400px">

<?php

$accountsquery = mysqli_query($con, "SELECT * FROM `accounts`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($accountsquery)){

$accountname = $row['name'];
$getaccountsquery = mysqli_query($con, "SELECT * FROM `$accountname`") or die(mysqli_error($con));

$accountamount = mysqli_num_rows($getaccountsquery);

echo '
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading'.$row['id'].'">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row['id'].'" aria-expanded="true" aria-controls="collapse'.$row['id'].'" class="">
          '.$row['name'].'
        </a>&nbsp<span class="label label-default">'.$accountamount.'</span><a href="admin-manage.php?deleteaccount='.$accountname.'" class="btn btn-sm btn-default pull-right"><span class="fa fa-times"></a>
      </h4>
    </div>
    <div id="collapse'.$row['id'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$row['id'].'" style="height: 0px;">
      <div class="panel-body">
    <center>
<form action="admin-manage.php" method="POST">
<input type="hidden" name="accountname" value="'.$row['name'].'"/>
<textarea name="accounts" rows="10" class="form-control" placeholder="username:password
username:password">';

while($row = mysqli_fetch_assoc($getaccountsquery))
{
  echo $row['alt']."\n";
}

echo '</textarea>
<br>
<button type="submit" class="btn btn-large btn-block">Update Accounts</button>
</form>
    </center>
      </div>
    </div>
  </div>
';
}
?>

</div>

<form action="admin-manage.php" method="POST">
<input type="text" name="addaccount" class="form-control" placeholder="name" style="width: 400px; margin-bottom: 5px;">
<button type="submit" class="btn btn-default btn-large btn-block" style="width: 400px">Add Account</button>
</form>

            </div>
                    </div>
                    <div class="col-md-5 well" style="margin-left: 10px;">
                        <legend>Manage Settings</legend>
            <div class="container">
            <form method="POST" action="admin-manage.php"/>
            <label>Website Name:</label></br>
            <input type="text" name="website" class="form-control" style="width: 400px" value="<?php echo $website;?>" required/></br>
            <label>Paypal:</label></br>
            <input type="text" name="paypal" class="form-control" style="width: 400px" value="<?php echo $paypal;?>" required/></br>
            <label>Bitcoin:</label></br>
            <input type="text" name="bitcoin" class="form-control" style="width: 400px" placeholder="Leave empty" value="<?php echo $bitcoin;?>" disabled/></br>
            <button class="btn btn-default btn-large btn-block"style="width: 400px">Update Settings</button>
            </form>
            </div>
                    </div>

        </div>
                <div class="row">

                    <div class="col-md-5 well" style="margin-left: 10px;">
                        <legend>Manage Packages</legend>
            <div class="container">

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="width: 400px">

<?php

$packagesquery = mysqli_query($con, "SELECT * FROM `packages` order by id") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($packagesquery)){

$packagename = $row['name'];

echo '
  <div class="panel panel-default">
    <div class="panel-heading" role="tab">
      <h4 class="panel-title">
        <a href="#">
          '.$row['name'].'
        </a><a href="admin-manage.php?deletepackage='.$packagename.'" class="btn btn-sm btn-default pull-right"><span class="fa fa-times"></a>
      </h4>
    </div>
  </div>
';
}
?>

</div>

<form action="admin-manage.php" method="POST">
<input type="text" name="name" class="form-control" placeholder="name" style="width: 400px; margin-bottom: 2px;" required>
<input type="text" name="price" class="form-control" placeholder="price" style="width: 400px; margin-bottom: 2px;" required>
<select name="generator" class="form-control" style="width: 400px; margin-bottom: 5px;">
<option value="">All Generators</option>
<?php
$accountsquery = mysqli_query($con, "SELECT * FROM `accounts`") or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($accountsquery)){
echo '<option value="'.$row[id].'">'.$row['name'].'</option>';
}
?>
</select>
<input type="number" name="accounts" class="form-control" placeholder="max accounts per day (Leave empty for unlimited)" style="width: 400px; margin-bottom: 2px;">
<select name="length" class="form-control" style="width: 400px; margin-bottom: 5px;" required>
<option value="Lifetime">Lifetime</option>
<option value="1 Day">1 Day</option>
<option value="3 Days">3 Days</option>
<option value="1 Weei">1 Week</option>
<option value="1 Month">1 Month</option>
<option value="2 Months">2 Months</option>
<option value="3 Months">3 Months</option>
<option value="4 Months">4 Months</option>
<option value="5 Months">5 Months</option>
<option value="6 Months">6 Months</option>
<option value="7 Months">7 Months</option>
<option value="8 Months">8 Months</option>
<option value="9 Months">9 Months</option>
<option value="10 Months">10 Months</option>
<option value="11 Months">11 Months</option>
<option value="12 Months">12 Months</option>
</select>
<button type="submit" class="btn btn-default btn-large btn-block" style="width: 400px">Add Package</button>
</form>

            </div>
                    </div>
                    <div class="col-md-5 well" style="margin-left: 10px;">
                        <legend>Manage Updates</legend>
            <div class="container">

<textarea class="form-control" rows="8" style="width: 400px" placeholder="Update Log" readonly>
<?php
if (isset($_GET['action'])) 
{
            
    if ($_GET['action'] == "install-update") 
    {

            $zipHandle = zip_open('update.zip');

            while ($aF = zip_read($zipHandle) )
            {
                $thisFileName = zip_entry_name($aF);
                $thisFileDir = dirname($thisFileName);
                   
                if ( substr($thisFileName,-1,1) == '/') continue;
                   
                if ( !is_dir ( $thisFileDir ) )
                
                {
                    mkdir ( $thisFileDir );
                    echo '- Created Directory '.$thisFileDir."\n";
                }
                   
                if ( !is_dir($thisFileName) ) 
                {
                    echo '- '.$thisFileName.'..';
                    $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                    $contents = str_replace("\\r\\n", "\\n", $contents);
                    $updateThis = '';
                       
                    $updateThis = fopen($thisFileName, 'w');
                    fwrite($updateThis, $contents);
                    fclose($updateThis);
                    unset($contents);
        
            echo ' Done'."\n";
                }
                    
            }
                
               $updated = true;
    
            if ($updated == true) 
            {
                unlink('update.zip');
                echo 'Update Installed.'."\n";
            }
            
    }
    
}

?>
</textarea></br>

<form action="admin-manage.php" method="POST" enctype="multipart/form-data">
<span class="btn btn-default btn-file" style="width: 400px; margin-bottom: 10px;" disabled>
<input type="file" name="file" id="file" required>
</span>
<input type="submit" name="submit" style="width: 400px" class="btn btn-default btn-block" value="Upload Update" disabled/>
</form>
<a class="btn btn-default btn-block" style="width: 400px" href="admin-manage.php?action=install-update" <?php if (!(file_exists('update.zip'))){echo "disabled";}?>>Upload Update</a></br>

            </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-5 well" style="margin-left: 10px;">
                        <legend>Manage News</legend>
            <div class="container">

            <form method="POST" action="admin-manage.php"/>
            <label>News Message:</label></br>
            <textarea name="message" class="form-control" rows="5" style="width: 400px" required></textarea>
            <label>Writer:</label></br>
            <input type="text" name="writer" class="form-control" style="width: 400px" value="<?php echo $_SESSION['username'];?>" required/></br>
            <button class="btn btn-default btn-large btn-block"style="width: 400px" >Add News</button>
            </form>

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
