<?php
$servername = "*";
$un = "*";
$pw = "*";
$dbname = "b3_20806446_Member";
$conn = new mysqli($servername, $un, $pw, $dbname);

if ($conn->connect_error){
	die("Connection fail: ".$conn->connect_error);exit();
}

$category=$_GET["chosenCat"];
$sort=$_GET["chosenSort"];
$keyword=$_GET["keyword"];
$word_array=explode(" ",$keyword);

$like_topic;
for ($i=0;$i<count($word_array);$i++)
{
	if ($i==0)
		$like_topic="Topic_name LIKE '%$word_array[$i]%'";
	else
	$like_topic.=" OR Topic_name LIKE '%$word_array[$i]%'";
}
echo("sorting by: ".$sort);
echo($like_topic);
if ($category=="All"){$q_catID="select CategoryID,Category from Category";}
else {$q_catID="select CategoryID, Category from Category where Category='".$category."'";}
$r_catID=$conn->query($q_catID);
if (!$r_catID) die("");
$r_catID->data_seek(0);
while ($row_catID=$r_catID->fetch_assoc())
{
	echo ("<ul><li>Category: ".$row_catID["Category"]."</li><br>");
	if ($sort=="Latest"){
		if ($keyword==""){
			$q_topic="select TopicID as TID, MAX(Date) as LastDate, Count(Content) as no from Comment inner join (select TopicID as T_ID from Topic where CategoryID='".$row_catID["CategoryID"]."')a on (a.T_ID=Comment.TopicID) group by TopicID ORDER BY MAX(Date) DESC";
		}
		else {
			$q_topic="select TopicID as TID, MAX(Date) as LastDate, Count(Content) as no from Comment inner join (select TopicID as T_ID from Topic where CategoryID='".$row_catID["CategoryID"]."' AND (".$like_topic. ") )a on (a.T_ID=Comment.TopicID) group by TopicID ORDER BY MAX(Date) DESC";
		}
	}
	else if ($sort=="Oldest"){
		if ($keyword==""){
			$q_topic="select TopicID as TID, MAX(Date) as LastDate, Count(Content) as no from Comment inner join (select TopicID as T_ID from Topic where CategoryID='".$row_catID["CategoryID"]."')a on (a.T_ID=Comment.TopicID) group by TopicID ORDER BY MAX(Date) ASC";
		}
		else {
			$q_topic="select TopicID as TID, MAX(Date) as LastDate, Count(Content) as no from Comment inner join (select TopicID as T_ID from Topic where CategoryID='".$row_catID["CategoryID"]."' AND (".$like_topic. ") )a on (a.T_ID=Comment.TopicID) group by TopicID ORDER BY MAX(Date) ASC";
		}
	}
	else if ($sort=="Most Comments"){
		if ($keyword==""){
			$q_topic="select TopicID as TID, MAX(Date) as LastDate, Count(Content) as no from Comment inner join (select TopicID as T_ID from Topic where CategoryID='".$row_catID["CategoryID"]."')a on (a.T_ID=Comment.TopicID) group by TopicID ORDER BY no DESC";
		}
		else {
			$q_topic="select TopicID as TID, MAX(Date) as LastDate, Count(Content) as no from Comment inner join (select TopicID as T_ID from Topic where CategoryID='".$row_catID["CategoryID"]."' AND (".$like_topic. ") )a on (a.T_ID=Comment.TopicID) group by TopicID ORDER BY no DESC";
		}
	}
	
	$r_topic=$conn->query($q_topic);
	if (!$r_topic) die("");
	$r_topic->data_seek(0);
	while ($row_topic=$r_topic->fetch_assoc())
		{
			$q_name="select Topic_name from Topic where TopicID='".$row_topic["TID"]."'";
			$r_name=$conn->query($q_name);
			while ($row_name=$r_name->fetch_assoc())
			echo ("Topic name: ".$row_name["Topic_name"]."\t Topic ID: ".$row_topic["TID"]."\t Last update: ".$row_topic["LastDate"]."  No. of Comments: ".$row_topic["no"]."<br />");
			//$q_time="select TopicID, max_date from Comment inner join (select MAX(Date) as max_date, TopicID as ID from Comment where TopicID='".$row_topic["TopicID"]."' GROUP BY TopicID ORDER BY max_date DESC)a on (a.ID=Comment.TopicID and a.max_date=Comment.Date) ORDER BY max_date DESC";
			
		}
		
			
		
		
		echo ("</ul>");
}
echo($q_topic);


?>