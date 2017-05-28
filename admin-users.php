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
if ($_GET['deleteuser']){
$id = strip_tags($_GET['deleteuser']);
mysqli_query($con, "DELETE FROM `users` WHERE `id` = '$id'") or die(mysqli_error($con));
}
}

if(isset($_POST)){
if ($_POST['edituser']){
$id = strip_tags($_POST['edituser']);
if (isset($_POST['username'])){
$newusername = $_POST['username'];
mysqli_query($con,"UPDATE `users` SET `username` = '$newusername' WHERE `id` = '$id'") or die(mysqli_error($con));
}
if (isset($_POST['password'])){
$newpassword = $_POST['password'];
mysqli_query($con,"UPDATE `users` SET `password` = '$newpassword' WHERE `id` = '$id'") or die(mysqli_error($con));
}
if (isset($_POST['email'])){
$newemail = $_POST['email'];
mysqli_query($con,"UPDATE `users` SET `email` = '$newemail' WHERE `id` = '$id'") or die(mysqli_error($con));
}
if (isset($_POST['rank'])){
$newrank = $_POST['rank'];
mysqli_query($con,"UPDATE `users` SET `rank` = '$newrank' WHERE `id` = '$id'") or die(mysqli_error($con));
}
}

if ($_POST['action'] == "adduser"){
$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mysqli_real_escape_string($con, md5($_POST['password']));
$email = mysqli_real_escape_string($con, $_POST['email']);
$rank = mysqli_real_escape_string($con, $_POST['rank']);
$date = date("Y-m-d");
mysqli_query($con, "INSERT INTO `users` (`username`, `password`, `email`, `rank`, `date`) VALUES ('$username', '$password', '$email', '$rank', DATE('$date'))") or die(mysqli_error($con));
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

        <div class="col-md-10">
        <div class="table-responsive">

              <table id="mytable" class="table table-bordred table-striped">

<div id="collapse">

        <button class="btn btn-default btn-large btn-block" data-toggle="collapse" data-target="#adduser" data-parent="#collapse">Add User</button></br>

<div id="adduser" class="sublinks collapse">
<legend></legend>
<form action="admin-users.php" method="POST">
<input type="hidden" name="action" value="adduser"/>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Username</span>
        <input type="text" name="username" class="form-control" style="width: 815px;" placeholder="username">
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Password</span>
        <input type="password" name="password" class="form-control" style="width: 815px;" placeholder="username">
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Email</span>
        <input type="email" name="email" class="form-control" style="width: 815px;" placeholder="username">
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Rank</span>
        <select name="rank" class="form-control" style="width: 815px;">
            <option value="1">Member</option>
            <option value="5">Admin</option>
        </select>
    </div>
</div>
<button type="submit" class="btn btn-default btn-large btn-block">Add User</button></br>
</form>


</div>

        <legend></legend>
                   
        <div class="input-group"> <span class="input-group-addon">Filter</span>
            <input id="filter" type="text" class="form-control">
        </div>

                   <thead>
                     <th>ID</th>
                     <th>Username</th>
                     <th>Email</th>
                     <th>Rank</th>
                     <th>IP</th>
                     <th>Register Date</th>
                     <th>Edit</th>
                     <th>Delete</th>
                   </thead>
    <tbody class="searchable">
<div id="menu">
<?php
$result = mysqli_query($con, "SELECT * FROM `users`") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['username'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    if($row['rank'] == "1"){echo '<td>Member</td>';}elseif($row['rank'] == "5"){echo '<td>Admin</td>';}else{echo '<td></td>';}
    echo '<td>' . $row['ip'] . '</td>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td><p><a class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#user'.$row['id'].'" data-parent="#menu"><span class="glyphicon glyphicon-pencil"></span></a></p></td>';
    echo '<td><p><a class="btn btn-danger btn-xs" href="admin-users.php?deleteuser=' . $row['id'] . '" data-title="Delete"><span class="glyphicon glyphicon-trash"></span></a></p></td>';
    echo '</tr>';
    echo '
<div id="user'.$row['id'].'" class="sublinks collapse">
<form action="admin-users.php" method="POST">
<legend></legend>
<input type="hidden" name="edituser" value="'.$row['id'].'"/>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Username</span>
        <input type="text" name="username" class="form-control" style="width: 815px;" value="'.$row['username'].'">
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Password</span>
        <input type="text" name="password" class="form-control" style="width: 815px;" placeholder="Leave empty">
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Email</span>
        <input type="text" name="email" class="form-control" style="width: 815px;" value="'.$row['email'].'">
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width: 130px;">Rank</span>
        <select name="rank" class="form-control" style="width: 815px;">
            <option value="1" ';
if($row[rank] < 5){echo 'selected';}
echo '>Member</option>
            <option value="5" ';
if($row[rank] == 5){echo 'selected';}
echo '>Admin</option>
        </select>
    </div>
</div>
<button class="btn btn-default btn-block" type="submit">Edit User</button></br>
<legend></legend>
</form>
</div>';

}
?>
</div>
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
