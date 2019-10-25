<?php

$F_Email=$_GET['F_Email'];

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

$sql = "SELECT Email,Password,password_reset FROM member";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if ($row['password_reset']==1)
		{
			echo "You have reset Password already";
			exit();
		}
		if(($row["Email"]==strtolower($F_Email)))
		{
			$Email=$row["Email"];
			$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
            $key_size =  strlen($key);
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			
			

            $ciphertext_dec = base64_decode($row["Password"]);
            $iv_dec = substr($ciphertext_dec, 0, $iv_size);
            $ciphertext_dec = substr($ciphertext_dec, $iv_size);
            $de_password = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
			
			$de_password= trim($de_password);
			$find=1;
			
			$update_sql = "UPDATE member SET password_reset = 1 WHERE  Email = '".$Email."'";
              $conn->query($update_sql);
                 
   

		}
			
    }
} 

$conn->close();
if($find==1)
{
	
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
    $mail->AddAddress($Email, "Password Loster"); //收件人郵件和名稱

    
    $mail->IsHTML(true); //郵件內容為html 
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //添加附件(若不需要則註解掉就好)
     
    $mail->Subject = "Welcome to Polyu Don!"; //郵件標題
    $mail->Body ="Dear Sir/Madam,</br></br>
                  It is Your Password <b>".$de_password."</b></br></br>
				  Please mind you password and we only send you the password once </br></br>
				  Best Regarts,</br></br>
				  Poly Don</br></br>
				  Adminstrator </br></br>".
				  Date("d/m/Y"); //郵件內容
    $mail->AltBody = 'This will be shown if browser does not support HTML';
     
    if(!$mail->send()) {
          
        echo 'Mailer Error: ' . $mail->ErrorInfo;
		
    } else {    
        echo 'Your  password has been sent!';
    }
	

}

	else 
		{
			echo "No the Email";
		
		
		}

	



?>