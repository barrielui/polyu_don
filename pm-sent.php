<?php  
	session_start();+
	$userID = "30"; //30 is Ming456
	//$userID = "1";
	$pmsender = $_GET['pmsender'];
	$pmrecipient = $_GET['pmrecipient'];
	$pmrecipientID;
	$pmtopic = $_GET['pmtopic'];
	$pmcontent = $_GET['pmcontent'];

	$conn = mysqli_connect("*", "*", "*", "b3_20806446_Member");
	//$conn = mysqli_connect("localhost", "root", "", "pmtest");
	if ($conn->connect_error) {
			echo "Unable to connect to database";
		   	exit;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////
	$query = "select id from member where UserName = '".$pmrecipient."'";
	$result = $conn->query($query);
   
	$result->data_seek(0);
	while ($row = $result->fetch_assoc()){
		$pmrecipientID = $row['id'];
	}
	$result->free();
	if ($pmrecipientID=="")
	{
		echo "No such user";
		exit();
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	$query = "select id from member where UserName = '".$pmsender."'";
	$result = $conn->query($query);
	$result->data_seek(0);
	while ($row = $result->fetch_assoc()){
		$userID = $row['id'];
	}
	$result->free();
///////////////////////////////////////////////////////////////////////////////////////////////////////
	$query2 = "insert into PM (recipientID, senderID, Topic, Content) values (".$pmrecipientID.",".$userID.",'".$pmtopic."','".$pmcontent."')";
	//$query2 = "insert into pm (recipientID, senderID, Topic, Content) values (".$pmrecipientID.",".$userID.",'".$pmtopic."','".$pmcontent."')";
	$result2 = $conn->query($query2);
///////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "Message has been sent";
	//echo "<p>You will be redirected to pm center after 3 seconds</p>";
	//header("Refresh:3;url=pm-center.php");
///////////////////////////////////////////////////////////////////////////////////////////////////////
	$conn->close();
?>