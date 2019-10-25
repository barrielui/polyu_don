<?php

session_start();


if(isset($_SESSION['R_email']) &&  isset($_SESSION['R_password']) && isset($_SESSION['R_username']) )
{
$email=strtolower($_SESSION['R_email']);
$password=$_SESSION['R_password'];
$username=$_SESSION['R_username'];


 $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
 $key_size =  strlen($key);
 $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
 $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
 $EN_password=mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$password, MCRYPT_MODE_CBC, $iv);
 $EN_password = $iv . $EN_password;
 $EN_password_base64 = base64_encode($EN_password);								 
			



$servername = "*";
$un = "*";
$pw = "*";
$dbname = "b3_20806446_Member";

// Create connection
$conn = new mysqli($servername, $un, $pw , $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	
} 

$email = mysqli_real_escape_string($conn, $email);

$sql = "INSERT INTO member (UserName, Email, Password, Activated) VALUES ('$username','$email',' $EN_password_base64','No')";

if ( $conn->query($sql) === TRUE) {
   
} 
else {
		
}

$conn->close();

$code_1=strval(round(rand(0,9),0));
$code_2=strval(round(rand(0,9),0));
$code_3=strval(round(rand(0,9),0));
$code_4=strval(round(rand(0,9),0));
$code_5=strval(round(rand(0,9),0));
$code_6=strval(round(rand(0,9),0));

$verification_code= $code_1.$code_2.$code_3.$code_4.$code_5.$code_6;

//Database checking
$servername = "sql302.byethost3.com";
$un = "b3_20806446";
$pw = "@EIE4432201718";
$dbname = "b3_20806446_Member";


// Create connection
$conn = new mysqli($servername, $un, $pw, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 




$sql = "insert into Verifitication (UserName,Code) values ('$username','$verification_code') ";
$result = $conn->query($sql);

if ($result === TRUE) {
   
}   
else {
		
}



  require_once('PHPMailer/PHPMailerAutoload.php'); //引入phpMailer 記得將路徑換成您自己的path
    $mail= new PHPMailer(); //初始化一個PHPMailer物件
    $mail->Host = "smtp.gmail.com"; //SMTP主機 (這邊以gmail為例，所以填寫gmail stmp)
    $mail->IsSMTP(); //設定使用SMTP方式寄信
    $mail->SMTPAuth = true; //啟用SMTP驗證模式
    $mail->Username = "polydon.forum@gmail.com"; //您的 gamil 帳號
    $mail->Password = "EIE4432201718"; //您的 gmail 密碼
    $mail->SMTPSecure = "ssl"; // SSL連線 (要使用gmail stmp需要設定ssl模式) 
    $mail->Port = 465; //Gamil的SMTP主機的port(Gmail為465)。
    $mail->CharSet = "utf-8"; //郵件編碼
      
    $mail->From = "polydon.forum@gmail.com"; //寄件者信箱
    $mail->FromName = "Poly Don"; //寄件者姓名
    $mail->AddAddress($email, $username); //收件人郵件和名稱

    
    $mail->IsHTML(true); //郵件內容為html 
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //添加附件(若不需要則註解掉就好)
     
    $mail->Subject = "Welcome to Polyu Don!"; //郵件標題
    $mail->Body ="Dear Sir/Madam,</br></br>
                  Thank You for your registration!</br>
				  Your Username is <b>".$username."</b></br>
				  Your Verifitication Code is : <b>".$verification_code."</b></br>
         		  <a href='http://polyudon.byethost3.com/lok/index.php?v=-1'>http://polyudon.byethost3.com/lok/index.php?v=-1</a></br>
				  
				  Wish you have fun in Poly Don!</br></br>
				  Best Regarts,</br></br>
				  Poly Don</br></br>
				  Adminstrator </br></br>".
				  Date("d/m/Y"); //郵件內容
    $mail->AltBody = '當收件人的電子信箱不支援html時，會顯示這串~~';
     
    if(!$mail->send()) {
          
        echo 'Mailer Error: ' . $mail->ErrorInfo;
		
    } else {    
        echo 'Your verification email has been sent!';
    }
	

}
session_destroy();




?>