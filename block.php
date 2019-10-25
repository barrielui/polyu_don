<?php

session_start();

$username=$_SESSION['username'];
$blockuser=$_GET['blockuser'];

 //Database checking
$servername = "*";
$un = "*";
$pw = "*";
$dbname = "b3_20806446_Member";


// Create connection
$conn = new mysqli($servername, $un, $pw, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


if($username==$blockuser)
{
	echo "Block yourself?!";
	$conn->close();
	exit();
}
$sql = "insert into Block (UserName,BlockedUser) values ('$username','$blockuser') ";
$result = $conn->query($sql);

if ($result === TRUE) {
   echo "Blocked";
}   
else {
		
}
$conn->close();











?>