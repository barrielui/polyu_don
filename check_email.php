<?php
Session_start();
$find=0;
$email= $_REQUEST["email"];  //Remember Always Upper Letter!

		if($email=="")                             //input checking
	{
		echo "Please Enter Your Email";
	  
	}
	else if (!preg_match("/^([0-9]{8}[D,d,G,g,X,x,R,r]@connect.polyu.hk|[0-9]{8}[D,d,G,g,X,x,R,r]@polyu.edu.hk)$/",$email))
	{
		echo "Only Polyu Email is allowed";
	
	}
	else
	{

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

$sql = "SELECT Email FROM member";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if(($row["Email"]==strtolower($email)))
		{
			$find=1;
		}
			
    }
} 

$conn->close();
if($find==1)
		echo "This email has been registered";
	else 
		{
			echo "✓";
			$_SESSION["R_email"]=$email;
		
		
		}

	}
	
	
?>