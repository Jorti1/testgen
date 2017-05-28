<?php

$myhost = "localhost";
$myuser = "exploit_user";
$mypass = "minecrafT1";
$mydb = "exploit_database";
$key = "2147828743"; //Don't tuch this !

$con = mysqli_connect($myhost, $myuser, $mypass, $mydb);

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>