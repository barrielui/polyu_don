<html>
<head>
<style>
#submit{
	color:#000000;
}
</style>


<!--get session-->
<?php
session_start();
$Username=$_SESSION['username'];
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

$UI_Q = "select id from member where UserName = '".$Username."'";
$UI_R = $conn->query($UI_Q);
if(!$UI_R) die("No information");
$UI_R->data_seek(0);
while ($row=$UI_R->fetch_assoc()){
$UI=$row["id"];
}
$_SESSION["UserID"] =$UI;
$UserID=$UI;
?>
<!--open new Topic-->
<?php

	if(isset($_POST["open_topic"])){
		if(isset($_POST["topic_name"])){
		$TN=$_POST["topic_name"];
		$sql = "insert into Topic(UserID,CategoryID,Topic_name,Content) values ('".$UserID."','".$_SESSION["CategoryID"]."','".$TN."','".$_POST["open_topic"]."')";
	//$sql = "/insert into comment(ID,Content) values ('3','i am third')";
	//echo "\"insert into comment(ID,Content) values (\'\" . $_SESSION[\"number\"].\"\',\'\".$_POST[\"comment\"].\"\')\"";
		$conn->query($sql);
		
		//Get topic id
		$T_Q = "select TopicID from Topic where Topic_name='".$TN."'";
		$T_R = $conn->query($T_Q);
		if(!$T_R) die("No information");
		$T_R->data_seek(0);
		while ($row=$T_R->fetch_assoc()){
		$TI=$row["TopicID"];
		}
		$_SESSION["$titleid"]=$TI;
		header('Location: index.php#');

		}
	}


?>


<style>
#new_post{
	text-align:center;
	color:#000000;
}
#open_topic{
	color:#000000;
}
#topic_name{
	color:#000000;
}
</style>
<!--check new post title content empty-->
  <script type="text/javascript">
	
		function checkEmpty ()  {
		var t1=0;
		
		if(topic_name.value==""||open_topic.value==""){
			alert("Topic title or content is empty!");
			t1 =1;
		}
	
		if(t1==0)
		return true;
		else
		return false;
 	}
  </script>
</head>
<body id="new_post" name="new_post">
<?php 

if(isset($_SESSION['username'])){

$C_Q = "select * from Category where CategoryID='".$_SESSION["CategoryID"]."'";
$C_R = $conn->query($C_Q);
if(!$C_R) die("No information??");
$C_R->data_seek(0);
while ($row=$C_R->fetch_assoc()){
echo "<h3>".$row["Category"]."</h3>";
}

echo "<form action=\"new_post.php\" method=\"POST\" onsubmit=\"return checkEmpty()\">";
echo "Please input your Topic Name";
echo "<br>";
echo "<input type=\"textarea\" name=\"topic_name\" cols=\"30%\" id=\"topic_name\"></textarea>";
echo "<br>";
/*echo "<select name=\"Category\" id=\"Category\" >";
$C_Q = "select * from Category";
$C_R = $conn->query($C_Q);
if(!$C_R) die("No information??");
$C_R->data_seek(0);
while ($row=$C_R->fetch_assoc()){
echo "<option value=\"".$row["CategoryID"]."\">".$row["Category"]."</option>";
}
echo "</select>";*/
echo "<br>";
echo "Please input content of topic";
echo "<br>
<textarea name=\"open_topic\" cols=\"70\" rows=\"20%\" id=\"open_topic\"></textarea>";
echo "<br>";
echo "<input type=\"submit\" value=\"submit\" id=\"submit\" >";
echo "</form>";
}else{
	echo "<H1>Please Login First</H1>";
}
?>

</body>
</html>

