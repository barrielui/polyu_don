<?php
session_start();
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


$action=$_GET['action'];

if($action==0)
{

echo "<table>";

echo "<tr>";
echo "<th>Find Something?";
echo "</th>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<label>Topic Name: <input name="Topic_Name" id="Topic_Name" type="text" style="color:black"></label>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<input  type="button" value="Search" style="color:black" onclick="searchtable(1,Topic_Name.value)">';
echo "</td>";
echo "</tr>";

echo "</table>";

}
else if($action==1)
{
	unset($_SESSION['Search_Topic']);
	unset($_SESSION['Search_ID']);
	$topic_name=$_GET['topic_name'];
	
	if($topic_name=="")
	{
	echo "<table><tr><th>Result</th></tr>";
	echo "<tr><td>No Record</td></tr></table>";
	$_SESSION['find']=0;
	exit();
	}
	$find=0;
	$_SESSION["no_of_search"]=0;
	$topic_name=trim($topic_name);
	$array=explode(" ",$topic_name);
	
	
	$sql = "select Topic_name,TopicID from Topic ";
	$result = $conn->query($sql);
	if(!$result) die("No information");
	$result->data_seek(0);
	
	echo "<table><tr><th>Result</th></tr>";
	while ($row=$result->fetch_assoc()){

	$array2=explode(" ",trim($row["Topic_name"]));
	
	if(sizeOF($array2)==1)
	{
		
		if(strtolower(trim($topic_name))==strtolower(trim($row["Topic_name"])))
	   {
	     $_SESSION['Search_ID'][$_SESSION["no_of_search"]]=$row["TopicID"];
			$_SESSION['Search_Topic'][$_SESSION["no_of_search"]]=$row["Topic_name"];
			$_SESSION["no_of_search"]++;
           $find=1;
		   $_SESSION['find']=1;
     	}
		
	}
	else
	{
		
		for ($i=0;$i<=sizeOF($array2);$i++)
		{
			
			for ($k=0;$k<=sizeOF($array);$k++)
			if(strtolower(trim($array[$i]))==strtolower(trim($array2[$k])))
	      {
			 $get_data=1;
			
			for ($a=0;$a<=$_SESSION["no_of_search"];$a++)
			{
				if($_SESSION['Search_Topic'][$a]==$row["Topic_name"])
					$get_data=0;
			}
			if($get_data==1)
			{
			$_SESSION['Search_Topic'][$_SESSION["no_of_search"]]=$row["Topic_name"];
		
			$_SESSION['Search_ID'][$_SESSION["no_of_search"]]=$row["TopicID"];
			$_SESSION["no_of_search"]++;
			$find=1;
		   $_SESSION['find']=1;
			}
           
     	  }

		}
			
	}
	
	}	
	if ($find==0)
	{
		echo "<tr><td>No Record</td></tr>";
		$_SESSION['find']=0;
	}
    else
	{
		for ($i=0;$i<5;$i++)
		{
			 echo "<tr ><td><a href='#' onclick=\"ajax_hotpost(".$_SESSION['Search_ID'][$i].")\">".$_SESSION['Search_Topic'][$i]. "</a></td></tr>";
		}
	}
	echo "</table>";
	
	$_SESSION["Search_seek"]=5;
}
else if ($action==2)
{
	if($_SESSION['find']==0)
		echo "<table><tr><th>Result</th></tr><tr><td>No Record</td></tr>";
	else
	{
	$_SESSION["Search_seek"]=$_SESSION["Search_seek"]-10;
	
	if($_SESSION["Search_seek"]<0)
		$_SESSION["Search_seek"]=0;
	
	echo "<table><tr><th>Result</th></tr>";
	for ($i=$_SESSION["Search_seek"];$i<($_SESSION["Search_seek"]+5);$i++)
		{
			 echo "<tr ><td><a href='#' onclick=\"ajax_hotpost(".$_SESSION['Search_ID'][$i].")\">".$_SESSION['Search_Topic'][$i]. "</a></td></tr>";
		}
	
	
	$_SESSION["Search_seek"]=$_SESSION["Search_seek"]+5;
	}
	echo "</table>";
}
else if ($action==3)
{
	if($_SESSION['find']==0)

		echo "<table><tr><th>Result</th></tr><tr><td>No Record</td></tr>";
	else
	{
	if($_SESSION["Search_seek"]>=$_SESSION["no_of_search"])
		$_SESSION["Search_seek"]=$_SESSION["Search_seek"]-5;
	
	echo "<table><tr><th>Result</th></tr>";
	for ($i=$_SESSION["Search_seek"];$i<($_SESSION["Search_seek"]+5);$i++)
		{
			 echo "<tr ><td><a href='#' onclick=\"ajax_hotpost(".$_SESSION['Search_ID'][$i].")\">".$_SESSION['Search_Topic'][$i]. "</a></td></tr>";
		}

	$_SESSION["Search_seek"]=$_SESSION["Search_seek"]+5;
	}
		echo "</table>";	
}
if(($action!=0)&&($_SESSION['find']==1))
echo '
	<div class="custom-row">	
		<div class="btn-group btn-group-md custom-btn-group">
			<button type="button" class="btn custom-btn-topic-list" onclick="searchtable(2)" >Previous</button>
			
			<button type="button" class="btn custom-btn-topic-list" onclick="searchtable(3)">Next</button>
		</div>
	</div>
';


	
?>