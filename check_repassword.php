<?php
Session_start();

$password=$_REQUEST["password"];
$repassword=$_REQUEST["repassword"];


if($repassword=="")                           //input checking
	{
		echo "Please Confirm your Password";
	}
	else if ($password!=$repassword)
	{
		echo "Not match";
	}
	else
	{
		echo "✓";
		$_SESSION["R_password"]=$password;
		
		
	}


?>