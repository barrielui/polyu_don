<?php  

	$pmID = $_GET['pmID'];
	$userID = $_GET['userID'];
	session_start();
/////       database connection        //////////
	$conn = mysqli_connect("*", "*", "*", "b3_20806446_Member");
	//$conn = mysqli_connect("localhost", "root", "", "pmtest");
	if ($conn->connect_error) {
			echo "Unable to connect to database";
		   	exit;
	}
//////////// SQL ////////////////////
	$query = "delete from PM where recipientID = '".$userID."' and pmID = '".$pmID."'";
	$result = $conn->query($query);

	echo "Message has been deleted!";
		
	
	echo '@@@';
	
	
	echo '<tr><th>Topic</th><th>Sender</th><th>Receive Date</th><th>Viewed</th></tr>';
	//List the received message
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
				echo "<tr><td><a data-dismiss='modal'  data-toggle='modal' data-target='#showPM' onclick='showPM(\"".$row["pmID"]."\", \"".$userID."\")'>".$row['Topic']."</a></td><td>".$row['UserName']."</td><td>".$row['Date']."</td><td>".$Viewed."</td></tr>";
			}
			$result->free();
		}
 
	
	$conn->close();
?>