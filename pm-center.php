<?php  
	session_start();
	$userID = "30"; //30 is Ming456
	$conn = mysqli_connect("*", "*", "*", "b3_20806446_Member");
	//$userID = "1";
	//$conn = mysqli_connect("localhost", "root", "", "pmtest");
	if ($conn->connect_error) {
			echo "Unable to connect to database";
		   	exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.pm {
			border: 2px solid;
		}
		.pm tr,th,td {
			border: 2px solid;
		}
	</style>
	<title></title>
</head>
<body>
<table class="pm">
	<tr><th>Topic</th><th>Sender</th><th>Receive Date</th><th>Viewed</th></tr>
	<?php //List the received message
		$query = "select pmID, recipientID, senderID, UserName, Topic, Content, Date, Viewed from PM, member where PM.senderID = member.id and recipientID = '".$userID."' order by Date desc";
		//$query = "select pmID, recipientID, senderID, UserName, Topic, Content, Date, Viewed from pm, member where pm.senderID = member.id and recipientID = '".$userID."' order by Date desc";
		$result = $conn->query($query);
		if ($result->num_rows == 0) {
			echo "<tr><td>No related message</td></tr>";
		} else {
			$result->data_seek(0);
			while ($row = $result->fetch_assoc())  {
				$Viewed;
				if ($row['Viewed'] == 0) {
					$Viewed = "F";
				} else {
					$Viewed = "T";
				}
				echo "<tr><td><a href='pm-read.php?pmID=".$row['pmID']."'>".$row['Topic']."</a></td><td>".$row['UserName']."</td><td>".$row['Date']."</td><td>".$Viewed."</td></tr>";
			}
			$result->free();
		}
	?>
</table>
<a href="pm-draft.php">Draft Msg</a>
</body>
</html>
<?php 
	$conn->close();
?>