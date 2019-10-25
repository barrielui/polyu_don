<?php

session_start();

$email=strtolower($_REQUEST['email']);

$password=$_REQUEST['password'];
				


												 
												 
												 
$remember_tag=$_REQUEST['remember_tag'];
$flag=0;

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

$sql = "SELECT Email,Password,UserName,Activated FROM member";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if(($row["Email"]==$email))
		{
			
			$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
            $key_size =  strlen($key);
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			
			

            $ciphertext_dec = base64_decode($row["Password"]);
            $iv_dec = substr($ciphertext_dec, 0, $iv_size);
            $ciphertext_dec = substr($ciphertext_dec, $iv_size);
            $de_password = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
			
			$de_password= trim($de_password);
			
			if(($de_password ==$password))
			{
				$_SESSION['email']=$row["Email"];
                $_SESSION['password']=$row["Password"];
                $_SESSION['username']=$row["UserName"];
                $_SESSION['Activated']=$row["Activated"];
				$flag=1;
			}
		}
			
    }
} 

$conn->close();

if($flag==1)
{
	echo "Login Sucessful";	
    if($remember_tag=="Yes")
	{
	//	setcookie(email,$_SESSION['email'],time()+87600);
	//	setcookie(password,$_SESSION['password'],time()+87600);
	//	setcookie(username,$_SESSION['username'],time()+87600);
	//	setcookie(Activated,$_SESSION['Activated'],time()+87600);

	}

	}
else
	echo "Wrong Email/Password";

?>