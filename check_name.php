<?php  //input checking
Session_start();
$find=0;

$username = $_REQUEST["username"];;


	if($username=="")                                 //input checking
	{
		echo "Please Enter your Username";
		
	}
	else if (!preg_match("/^[a-zA-z0-9]*$/",$username))
	{
		echo "Only letters and numbers allowed";
	
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

$sql = "SELECT UserName FROM member";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if(($row["UserName"]==$username))
		{
			$find=1;
		}
			
    }
} 

$conn->close();
	if($find==1)
	echo "This username has been registered";
else
{
	echo "✓";
	$_SESSION["R_username"]=$username;
}
	}



?>