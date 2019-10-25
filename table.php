<?php
session_start();
//Database checking
$servername = "*";
$un = "*";
$pw = "*";
$dbname = "b3_20806446_Member";



$id=$_GET['id'];
if(($id>0)&&($id<9999))
$_SESSION["CategoryID"]=$id;
echo "<div class='custom-row'>";
echo "<div class='btn-group btn-group-md custom-btn-group'>";
if($id==10000)
	echo '<button type="button" class="btn custom-btn-topic"  onclick="gettable(10000)">From Hottest</button>';
else
	if(($_SESSION['topic_sort']==10000)&&($id!=20000))
		echo '<button type="button" class="btn custom-btn-topic" onclick="gettable(10000)">From Hottest</button>';
else		
echo '<button type="button" class="btn custom-btn-topic-list" onclick="gettable(10000)">From Hottest</button>';

if($id==20000)
	echo '<button type="button" class="btn custom-btn-topic" onclick="gettable(20000)">From Newest</button>';
else
	if(($_SESSION['topic_sort']==20000)&&($id!=10000))
		echo '<button type="button" class="btn custom-btn-topic" onclick="gettable(20000)">From Newest</button>';
else
echo '<button type="button" class="btn custom-btn-topic-list" onclick="gettable(20000)">From Newest</button>';
echo "</div>";
echo "</div>";
if($id>=0)///////////////////////////////////////////Initial///////////////////////////////////////////////////
{
$_SESSION['seek']=0;
$_SESSION['seek_start']=0;
$_SESSION['topic_seek']=0;
unset($_SESSION['Topic_Name']);
unset($_SESSION['topic_id']);
$_SESSION['table']=$_SESSION["CategoryID"];
$flag=0;
$topic_count=0;
$no_of_data=0;

echo "<table>";
echo "<tr>";
echo "<th>You are now in ";
			
			
switch ($_SESSION["CategoryID"])
{
	case 1: echo "<b>Chit-chat</b>";
            break;
	case 2: echo "<b>Audio/Video</b>";
            break;	   
	case 3: echo "<b>PolyU</b>";
            break;
	case 4: echo "<b>Electronics</b>";
            break;
	case 5: echo "<b>Academic</b>";
            break;
	
}


echo "</th>";

////////////////////////////////////////////MARCO create post//////////////////////////
if ((isset($_SESSION['username']))&&($_SESSION['Activated']=="Yes"))
{echo "<tr><th><span class='glyphicon glyphicon-file'></span><a href='#' style='text-decoration: none' onclick='ajaxcreate_post(".$_SESSION['topic_id'].")'>Create Post</a></th></td>";
}
////////////////////////////////////////////MARCO create post//////////////////////////



// Create connection
$conn = new mysqli($servername, $un, $pw, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if($id==10000)////Hottest
{
	$sql = "SELECT Topic_name,TopicID,CategoryID FROM Topic order by Count desc ";
	$_SESSION['topic_sort']=10000;

}
else if($id==20000)/////Newest
{
	$sql = "SELECT Topic_name,TopicID,CategoryID FROM Topic order by Date desc ";
	$_SESSION['topic_sort']=20000;
}
else ////default Hottest
{
if(	$_SESSION['topic_sort']==10000)
$sql = "SELECT Topic_name,TopicID,CategoryID FROM Topic order by Count desc ";
else if ($_SESSION['topic_sort']==20000)
		$sql = "SELECT Topic_name,TopicID,CategoryID FROM Topic order by Date desc";
else $sql = "SELECT Topic_name,TopicID,CategoryID FROM Topic order by Date desc";
}
$result = $conn->query($sql);
$result->data_seek(0);
if ($result->num_rows > 0) {
    // output data of each row
    while(($row = $result->fetch_assoc())) {
		if(($row["CategoryID"]==$_SESSION["CategoryID"]))
		{
			if($topic_count<5)
			{
			//echo "<tr><td><a href='#' style='text-decoration: none' onclick='ajaxcontent(".$row['TopicID'].",1)'>".$row["Topic_name"]."</a></td></tr>";
			$flag=1;
			$topic_count++;
			}

			$_SESSION['Topic_Name'][$_SESSION['topic_seek']]=$row["Topic_name"];
			
			$_SESSION['topic_id'][$_SESSION['topic_seek']]=$row["TopicID"];
			$_SESSION['topic_seek']++;
		    
		}
	
		
        		
    }
} 



$conn->close();


if ($flag==0)		
echo "<tr><td>No topic</td></th>";
else
{
	for ($i=0;$i<5;$i++)
	{
	echo "<tr><td>";
    if (($_SESSION['topic_sort']==10000)&&(isset($_SESSION['Topic_Name'][$i])))
		echo "<span class='glyphicon glyphicon-fire'></span>";
	if (($_SESSION['topic_sort']==20000)&&(isset($_SESSION['Topic_Name'][$i])))
		echo "<span class='glyphicon glyphicon-flash'></span>";
    echo "<a href='#' style='text-decoration: none' onclick='ajaxcontent(".$_SESSION['topic_id'][$i].",1)'>".$_SESSION['Topic_Name'][$i]."</a></td></tr>";
    }
	$_SESSION['seek_start']=5;
}

echo "</table>";



}
else if ($id==-1)/////////////////////////////////////////////////NEXT TOPIC PAGE/////////////////////////////////////////////////////////////
{
	



$flag=0;
$topic_count=0;
$stop_flag=0;

echo "<table>";

echo "<tr>";
echo "<th>You are now in ";
		
		
			
switch ($_SESSION['table'])
{
	case 1: echo "<b>Chit-chat</b>";
            break;
	case 2: echo "<b>Audio/Video</b>";
            break;	   
	case 3: echo "<b>PolyU</b>";
            break;
	case 4: echo "<b>Electronics</b>";
            break;
	case 5: echo "<b>Academic</b>";
            break;
	
}

echo "</th>";


////////////////////////////////////////////MARCO create post//////////////////////////
if ((isset($_SESSION['username']))&&($_SESSION['Activated']=="Yes"))
{echo "<tr><th><span class='glyphicon glyphicon-file'></span><a href='#' style='text-decoration: none' onclick='ajaxcreate_post(".$_SESSION['topic_id'].")'>Create Post</a></th></td>";
}
////////////////////////////////////////////MARCO create post//////////////////////////




if(($_SESSION['seek_start'])>=$_SESSION['topic_seek'])
      	$_SESSION['seek_start']=$_SESSION['seek_start']-5;

for ($i=$_SESSION['seek_start'];$i<($_SESSION['seek_start']+5);$i++)
{
	echo "<tr><td>";
	if (($_SESSION['topic_sort']==10000)&&(isset($_SESSION['Topic_Name'][$i]))&&($_SESSION['seek_start']<5))
		echo "<span class='glyphicon glyphicon-fire'></span>";
	if (($_SESSION['topic_sort']==20000)&&(isset($_SESSION['Topic_Name'][$i]))&&($_SESSION['seek_start']<5))
		echo "<span class='glyphicon glyphicon-flash'></sapn>";
	echo "<a href='#' style='text-decoration: none' onclick='ajaxcontent(".$_SESSION['topic_id'][$i].",1)'>".$_SESSION['Topic_Name'][$i]."</a></td></tr>";
}
$_SESSION['seek_start']=$_SESSION['seek_start']+5;


echo "</table>";

}
else if ($id==-2)/////////////////////////////////////////////////PREVIOUS TOPIC PAGE/////////////////////////////////////////////////////////////
{
	

$_SESSION['seek_start']=$_SESSION['seek_start']-10;

$flag=0;
$topic_count=0;
$stop_flag=0;

echo "<table>";

echo "<tr>";
echo "<th>You are now in ";
			
			
switch ($_SESSION['table'])
{
	case 1: echo "<b>Chit-chat</b>";
            break;
	case 2: echo "<b>Audio/Video</b>";
            break;	   
	case 3: echo "<b>PolyU</b>";
            break;
	case 4: echo "<b>Electronics</b>";
            break;
	case 5: echo "<b>Academic</b>";
            break;
	
}

echo "</th>";

////////////////////////////////////////////MARCO create post//////////////////////////
if ((isset($_SESSION['username']))&&($_SESSION['Activated']=="Yes"))
{echo "<tr><th><span class='glyphicon glyphicon-file'></span><a href='#' style='text-decoration: none' onclick='ajaxcreate_post(".$_SESSION['topic_id'].")'>Create Post</a></th></td>";
}
////////////////////////////////////////////MARCO create post//////////////////////////




if(($_SESSION['seek_start'])<0)
      	$_SESSION['seek_start']=0;

for ($i=$_SESSION['seek_start'];$i<($_SESSION['seek_start']+5);$i++)
{
	echo "<tr><td>";
	if ((($_SESSION['topic_sort']==10000)&&($_SESSION['seek_start']==0))&&(isset($_SESSION['Topic_Name'][$i])))
		echo "<span class='glyphicon glyphicon-fire'></span>";
	if ((($_SESSION['topic_sort']==20000)&&($_SESSION['seek_start']==0))&&(isset($_SESSION['Topic_Name'][$i])))
		echo "<span class='	glyphicon glyphicon-flash'></sapn>";
	echo "<a href='#' style='text-decoration: none' onclick='ajaxcontent(".$_SESSION['topic_id'][$i].",1)'>".$_SESSION['Topic_Name'][$i]."</a></td></tr>";
}
$_SESSION['seek_start']=$_SESSION['seek_start']+5;


echo "</table>";

}

echo '
	<div class="custom-row">	
		<div class="btn-group btn-group-md custom-btn-group">
			<button type="button" class="btn custom-btn-topic-list" onclick="nextTopic(-2)" >Previous</button>
			<button type="button" class="btn custom-btn-topic-list" onclick="gettable(0)" >Refresh</button>
			<button type="button" class="btn custom-btn-topic-list" onclick="nextTopic(-1)">Next</button>
		</div>
	</div>
';


////////////// every 2 indicate 1 post !!!!so 8 post should be (0-6)*2 => (0-14)!!!!!so next start from postion 15
	
?>
