<?php  
	$pmID = $_GET['pmID'];
	$userID = $_GET['userID'];
	//$userID = "1";
	session_start();
?>
<!DOCTYPE html>

	<style type="text/css">
		.pm {
			border: 2px solid;
		}
		.pm tr,th,td {
			border: 2px solid;
		}
		.pm-content{
			width: 400px;
			height: 300px;
		}

	</style>

<?php
    echo '<table class="pm">';
	$conn = mysqli_connect("*", "*", "*", "b3_20806446_Member");
	//$conn = mysqli_connect("localhost", "root", "", "pmtest");
	if ($conn->connect_error) {
			echo "Unable to connect to database";
		   	exit;
	}
///////////////Set the msg is viewed////////////////////////
	$query2 = "update PM set Viewed = 1 where recipientID = '".$userID."' and pmID = '".$pmID."'";
	//$query2 = "update pm set Viewed = 1 where recipientID = '".$userID."' and pmID = '".$pmID."'";
	$result2 = $conn->query($query2);
///////////////Retrieve the message////////////////////////
	$query = "select senderID, UserName, Topic, Content, Date from PM, member where PM.senderID=member.id and recipientID = '".$userID."' and pmID = '".$pmID."'";
	//$query = "select senderID, UserName, Topic, Content, Date from pm, member where pm.senderID=member.id and recipientID = '".$userID."' and pmID = '".$pmID."'";
	$result = $conn->query($query);
	$result->data_seek(0);
	while ($row = $result->fetch_assoc()){
		echo "<tr><td><label for='pmsender'>Sender: </label></td><td><div>".$row['UserName']."</div></td></tr>";
		echo "<tr><td><label for='pmtopic'>Topic: </label></td><td><div>".$row['Topic']."</div></td></tr>";
		echo "<tr><td><label for='pmdate'>Date: </label></td><td><div>".$row['Date']."</div></td></tr>";
		echo "<tr><td><label for='pmcontent'>Content: </label></td><td class='pm-content'><div>".$row['Content']."</div></td></tr>";
		echo '<tr><td></td><td><a data-dismiss="modal"   data-toggle="modal" data-target="#PM" ><input type="button" name="reply" value="Reply"></a><a data-dismiss="modal"   data-toggle="modal" data-target="#Check_PM" ><input type="button" name="delete" value="Delete" onclick="delPM('.$pmID.','.$userID.')"></a><a data-dismiss="modal"   data-toggle="modal" data-target="#Check_PM" ><input type="button" name="back" value="Back"></a></td></tr>';
        $username=$row['UserName'];
	}
	$result->free();
	echo '</table>';
	echo '@@@';
	echo $username;
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

  
