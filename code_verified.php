<?php

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


$username=$_GET['username'];
$code=$_GET['code'];





$sql3= "select Activated from member where UserName= '$username'";
$result3 = $conn->query($sql3);
$result3->data_seek(0);
if ($result3->num_rows > 0) {
// output data of each row
while($row3 = $result3->fetch_assoc()) {
if(($row3["Activated"]=="Yes"))
 {
	 
	echo "User have been activated"; 	 
	 
 }
 else 
 {
 $sql = "select UserName,Code from Verifitication ";
$result = $conn->query($sql);
$result->data_seek(0);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

		if(($row["UserName"]==$username))
		{
			if(($row["Code"]==$code))
			{
				
				
                $sql2 = "update member set Activated = 'Yes' where UserName ='$username'";
                $result2 = $conn->query($sql2);
			    if ($result2 === true)
				{
					echo "User Activated";
					exit();
				}
				
				 
			}
			else 
		    {
			echo "Your verification Code is wrong";
			exit();
		    }
		
		}
		
    }

    
} 



 }
}
}

$conn->close();






echo "No such user";


session_start();

session_unset();
session_destroy();

setcookie(email,$_SESSION['email'],time()-87600);
setcookie(password,$_SESSION['password'],time()-87600);
setcookie(username,$_SESSION['username'],time()-87600);

session_start();
$_SESSION["table"]=1;












?>