<!--forum-->
<html>
<!--AJax-->

<head>
<!--open database-->
<?php
session_start();
//////////////////////////////////////Front Page////////////////////////////////////////////////
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

if (($_GET['reset']==(-1)) && (!(isset($_POST['comment']))) )  
{
	
	
	
	echo "<h4>";
	echo "Verification";
	echo "<div id=\"forum_content\">"; 
	
	echo "<table><tr><th>";
	echo "Please enter your username";
	echo "</th><th  >";
	echo "<input type='text' style='color:black' id='username'/>";
	echo "</th></tr>";
	echo "</table>";
	echo "<br>";
	
    echo "<table><tr><th>";
	echo "Please enter your code";
	echo "</th><th  >";
	echo "<input type='text' style='color:black' id='code'/>";
	echo "</th></tr>";
	echo "</table>";
	
	echo "<br>";
	echo "</div>";
	echo "<br>";
	echo '<button type="button" class="btn btn-primary" onclick="verification(username.value,code.value)">CheckIn</button>';

	echo "</h4>";
	
	
	
	
}

//////////////////////////////////////verification Page/////////////////////////////////////////////
else if (($_GET['ID']==0) && (!(isset($_POST['comment']))) ) 
{
	
//////////////////////5 hot topic for each Category//////////////////////////////////


///////////////////////no Catergory/////////////////////
	$UI_Q = "select Topic_name,Count,TopicID from Topic order by Count desc limit 5";
	$UI_R = $conn->query($UI_Q);
	if(!$UI_R) die("No information");
	$UI_R->data_seek(0);
	echo "<div class='container-fluid'><div class='row'><div class='col-xs-8 col-sm-8 col-md-8 col-lg-4'><table class='table'><tbody><tr>Overall</tr><tr><th>#</th><th>Topic</th><th>Hit</th></tr>";
	$top_five = 0;
	while ($row=$UI_R->fetch_assoc()){
		echo "<tr><td>".($top_five+1)."</td><td><a onclick=\"ajax_hotpost(".$row["TopicID"].")\">".$row["Topic_name"]. "</a><td>".$row["Count"]."</td></tr></td>";
		$top_five = $top_five + 1;
	}	
	echo "</tbody></table></div>";
	$_SESSION["$titleid"]=0;

///////////////////////no Catergory/////////////////////
///////////////////////Blowwater Catergory/////////////////////
	$UI_A = "select Topic_name,Count,TopicID from Topic where CategoryID = 1 order by Count desc limit 5";
	$UI_B = $conn->query($UI_A);
	if(!$UI_B) die("No information");
	$UI_B->data_seek(0);
	echo "<div class='col-xs-8 col-sm-8 col-md-8 col-lg-4'><table class='table'><tbody><tr>Chit-chat</tr><tr><th>#</th><th>Topic</th><th>Hit</th></tr>";
	$top_five = 0;
	while ($row=$UI_B->fetch_assoc()){
		echo "<tr><td>".($top_five+1)."</td><td><a onclick=\"ajax_hotpost(".$row["TopicID"].")\">".$row["Topic_name"]. "</a><td>".$row["Count"]."</td></tr></td>";
		$top_five = $top_five + 1;
	}	
	echo "</tbody></table></div>";
	
///////////////////////Blowwater Catergory/////////////////////
///////////////////////AV台 Catergory/////////////////////
	$UI_C = "select Topic_name,Count,TopicID from Topic where CategoryID = 2 order by Count desc limit 5";
	$UI_D = $conn->query($UI_C);
	if(!$UI_D) die("No information");
	$UI_D->data_seek(0);
	echo "<div class='col-xs-8 col-sm-8 col-md-8 col-lg-4'><table class='table'><tbody><tr>Audio/Video</tr><tr><th>#</th><th>Topic</th><th>Hit</th></tr>";
	$top_five = 0;
	while ($row=$UI_D->fetch_assoc()){
		echo "<tr><td>".($top_five+1)."</td><td><a onclick=\"ajax_hotpost(".$row["TopicID"].")\">".$row["Topic_name"]. "</a><td>".$row["Count"]."</td></tr></td>";
		$top_five = $top_five + 1;
	}
	while ($top_five<5) {
			echo "<tr><td>".($top_five+1)."</td><td>No related Topic<td>N/A</td></tr></td>";
			$top_five = $top_five + 1;
		}	
	echo "</tbody></table></div></div></div>";
	
///////////////////////理工台 Catergory/////////////////////
	$UI_E = "select Topic_name,Count,TopicID from Topic where CategoryID = 3 order by Count desc limit 5";
	$UI_F = $conn->query($UI_E);
	if(!$UI_F) die("No information");
	$UI_F->data_seek(0);
	echo "<div class='container-fluid'><div class='row'><div class='col-xs-8 col-sm-8 col-md-8 col-lg-4'><table class='table'><tbody><tr>PolyU</tr><tr><th>#</th><th>Topic</th><th>Hit</th></tr>";
	$top_five = 0;
	while ($row=$UI_F->fetch_assoc()){
		echo "<tr><td>".($top_five+1)."</td><td><a onclick=\"ajax_hotpost(".$row["TopicID"].")\">".$row["Topic_name"]. "</a><td>".$row["Count"]."</td></tr></td>";
		$top_five = $top_five + 1;
	}
	while ($top_five<5) {
			echo "<tr><td>".($top_five+1)."</td><td>No related Topic<td>N/A</td></tr></td>";
			$top_five = $top_five + 1;
		}	
	echo "</tbody></table></div>";
	
///////////////////////電子台 Catergory/////////////////////////
	$UI_G = "select Topic_name,Count,TopicID from Topic where CategoryID = 4 order by Count desc limit 5";
	$UI_H = $conn->query($UI_G);
	if(!$UI_H) die("No information");
	$UI_H->data_seek(0);
	echo "<div class='col-xs-8 col-sm-8 col-md-8 col-lg-4'><table class='table'><tbody><tr>Electronics</tr><tr><th>#</th><th>Topic</th><th>Hit</th></tr>";
	$top_five = 0;
	while ($row=$UI_H->fetch_assoc()){
		echo "<tr><td>".($top_five+1)."</td><td><a onclick=\"ajax_hotpost(".$row["TopicID"].")\">".$row["Topic_name"]. "</a><td>".$row["Count"]."</td></tr></td>";
		$top_five = $top_five + 1;
	}
	while ($top_five<5) {
			echo "<tr><td>".($top_five+1)."</td><td>No related Topic<td>N/A</td></tr></td>";
			$top_five = $top_five + 1;
		}	
	echo "</tbody></table></div>";

///////////////////////CKLeung台 Catergory/////////////////////
	$UI_I = "select Topic_name,Count,TopicID from Topic where CategoryID = 5 order by Count desc limit 5";
	$UI_J = $conn->query($UI_I);
	if(!$UI_H) die("No information");
	$UI_J->data_seek(0);
	echo "<div class='col-xs-8 col-sm-8 col-md-8 col-lg-4'><table class='table'><tbody><tr>Academic</tr><tr><th>#</th><th>Topic</th><th>Hit</th></tr>";
	$top_five = 0;
	while ($row=$UI_J->fetch_assoc()){
		echo "<tr><td>".($top_five+1)."</td><td><a onclick=\"ajax_hotpost(".$row["TopicID"].")\">".$row["Topic_name"]. "</a><td>".$row["Count"]."</td></tr></td>";
		$top_five = $top_five + 1;
	}
	while ($top_five<5) {
			echo "<tr><td>".($top_five+1)."</td><td>No related Topic<td>N/A</td></tr></td>";
			$top_five = $top_five + 1;
		}	
	echo "</tbody></table></div>";

//////////////////////5 hot topic//////////////////////////////////
}
/////////////////////////////////////Front Page/////////////////////////////////////////////////


////////////////////////////////////verification Page/////////////////////////////////////////////




else
{

////////////////////////////////////Topic Page////////////////////////////////////////////////
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
?>
<!--read user name and id-->
<?php
session_start();
$once=0;
if(isset($_SESSION['username'])){$Username = $_SESSION['username'];}
//if (isset($_SESSION["Username"])){$Username=$_SESSION["Username"];}
//session_destroy();

$UI_Q = "select id from member where UserName = '".$Username."'";
$UI_R = $conn->query($UI_Q);
if(!$UI_R) die("No information");
$UI_R->data_seek(0);
while ($row=$UI_R->fetch_assoc()){
$UI=$row["id"];
}
$_SESSION["UserID"] =$UI;
$UserID=$UI;

//$UserID=$_SESSION["UserID"];

?>
<!--read user titleid and page number-->
<?php
//$Title="";
$Page=1;
if(isset($_GET['ID'])){$_SESSION["$titleid"]= $_GET['ID'];}
$titleid=$_SESSION["$titleid"];
$_SESSION["$titleid"]=$titleid;
$T_Q = "select Topic_name,Content,UserID ,Date from Topic where TopicID ='".$titleid."'";
$T_R = $conn->query($T_Q);
if(!$T_R) die("No information");
$T_R->data_seek(0);
while ($row=$T_R->fetch_assoc()){
$Title=$Title.$row["Topic_name"];
$Title_content=$row["Content"];
$User__ID=$row["UserID"];
$Date=$row["Date"];

if(isset($_SESSION["S_page_num"])){$Page=$_SESSION["S_page_num"];} //if session have then get 
if($_GET['reset']==1)
{
	$Page=1;
	$_SESSION["S_page_num"]=1;
}
if(isset($_GET["page_num"])){$Page=$_GET["page_num"];$_SESSION["S_page_num"]=$Page;}   //is button is clicked, change2
//if(isset($_SESSION["page_num"])){
//$Page=$_SESSION["page_num"];
//}else{$Page="1";}
//if(isset($_GET["page_num"])){
//$Page=$_GET["page_num"];
//$_SESSION["page_num"]=$_GET["page_num"];
}
?>


<!--variable-->
<?php




?>
<!--insert information -->
<?php
//hole page
//$_SESSION["number"];

if(!isset($_SESSION["resubmit"]))
{
	$_SESSION["resubmit"]=0;
}
if(isset($_POST["comment"]))
{
	if($_POST["comment"]!=""){
	if(isset($_SESSION["refer"])){
	$RCMD=$_SESSION["refer"]."<hr>".$_POST["comment"];
	$sql = "insert into Comment(TopicID,UserID,Content) values ('".$titleid."','".$UserID."','". $RCMD."')";
	unset($_SESSION["refer"]);}
	else{
	$sql = "insert into Comment(TopicID,UserID,Content) values ('".$titleid."','".$UserID."','". $_POST["comment"]."')";
	}
	//$sql = "/insert into comment(ID,Content) values ('3','i am third')";
	//echo "\"insert into comment(ID,Content) values (\'\" . $_SESSION[\"number\"].\"\',\'\".$_POST[\"comment\"].\"\')\"";
	$conn->query($sql);
	

	$_SESSION["resubmit"]=0;
	
	header('Location: index.php#bottom');

	}
}

unset($_SESSION["refer"]);


	
//like
if((isset($Username)) && ($_SESSION['Activated']=="Yes")){

		if(isset($_GET["Like"]))
		{

			$update_sql = "UPDATE `Comment` SET `Like` = `Like`+1 WHERE`CommentID` ='".$_GET["Like"]."'";
			$conn->query($update_sql);
		}

}




//delete
if(isset($Username)){
	if($Username=="Admin")
	{
		if(isset($_GET["Delete"]))
		{
			$del_sql = "delete from Comment where CommentID = '".$_GET["Delete"]."'";
			$conn->query($del_sql);
		}
	}
}
?>


<!--POST title-->
<?php
echo "<h1>".$Title."</h1>";
?>


<a name="TopOfPage"></a>


<!---------------------------------------------------forum content--------------------------------------------->
<?php

if ($Page<=1 && $once==0){
	  
	    
$q1 = "select UserName ,id from member ";
$result = $conn->query($q1);
$Post_User=$User__ID;
$result->data_seek(0);
while ($row=$result->fetch_assoc()){
	if ($row['id'] == $User__ID)
      $Post_User=$row["UserName"];
}
		echo "<h4>";
		
		echo '<a  href="#" style="text-decoration: none" data-toggle="modal" data-target="#0"><user_red>'.$Post_User.' </user_red></a>';
		echo "<id> #0</id>";
		
			if (isset($_SESSION['username']))
	{
echo '
     <div class="modal fade" id=0 tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">User Information</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
              	<form class="form-horizontal">

				  <div class="form-group">
				    <div class="col-sm-3"><B><black>Username</black></B></div>
				    <div class="col-sm-3"><black>
				      '.$Post_User.'
				    </black></div>
					<div class="col-sm-6">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-3"><B><black>Post Holder Information</black></B></div>
				    <div class="col-sm-3"><black>
				      We may keep it secret !!!!!! 
				    </black></div>
					<div class="col-sm-6">
					<img src="post.png" height="50px" width="50px"></img><img src="post.png" height="50px" width="50px"></img><img src="post.png" height="50px" width="50px"></img><img src="post.png" height="50px" width="50px"></img><img src="post.png" height="50px" width="50px"></img>
				    </div>
				  </div>
				  
				  
				  
				</form>
		      </div>
              <div class="modal-footer custom-modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>	
		
';
	}
	else 
echo '
  <div class="modal fade" id=0 tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">Are U PolyU student?</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
              	<form class="form-horizontal">

				   <div class="form-group">
				    <img src="nonmember.png"  width="600" height="400">
				  </div>
				    
				  
				</form>
		      </div>
              <div class="modal-footer custom-modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>	


';


/////////////////////////////////Show Time//////////////////////////////////////////////////////////	
	$timestamp = strtotime($Date);
	if($timestamp <0)
		$timestamp=strtotime(Date("Y-m-d h:i:sa"));
	$now = strtotime(Date("Y-m-d h:i:sa"));
	$time = (($now-$timestamp)/60)/60;
	if($time>24)
		echo "<date>The post published ".round($time/24,0)." day before</date>";
	else if($time>1)
	  echo "<date>The post published ".round($time,0)." hours before</date>";
    else if ($time>0.5)
		echo "<date>The post published half hour before</date>";
	else if (($time*60)<3)
		echo "<date>The post just published!</date>";
	else echo "<date>The post published ".round(($time*60),0,PHP_ROUND_HALF_DOWN)." minutes before</date>";
	

////////////////////////////////Show Time END//////////////////////////////////////////////////////////////
	
	   
		echo "<div id='topic_content'>";
		
		echo $Title_content;
		
		echo "</div></h4>";
		
		
		$once=1;
	
	$Count=$row["Count"]+1;
	$update_sql = "UPDATE `Topic` SET `Count` = `Count`+1 WHERE  TopicID = '".$titleid."'";
    $conn->query($update_sql);
	
}
$passage="";
$query1 = "select * from Comment where TopicID = '".$titleid."' ORDER BY CommentID";
$result = $conn->query($query1);
if(!$result) die("No imformation");

$result->data_seek(0);
$count_num=1;
while ($row=$result->fetch_assoc()){
	

	
	$Content=$row["Content"];
	$CommentID=$row["CommentID"];
	$Date=$row["Date"];
	$Like=$row["Like"];
    $Content=str_replace("<polyu>","<img src=\"polyu.jpg\" name=\"source\" id=\"source\">",$Content);
	$Content=str_replace("<ILoveBonnie>","<img src=\"bonnie.jpg\" name=\"source\" id=\"source_bonnie\">",$Content);
	$Content=preg_replace("/\n/", "<br />", $Content);
	if(isset($Username)){}else{
	$Content=preg_replace('/<member>(.*?)<\/member>/',"<small align=\"center\">Login to view it=)</small>",$Content);
	}
	$UN_Q = "select Username,reg_date from member where id = '".$row["UserID"]."'";

	$UN_R = $conn->query($UN_Q);
	if(!$UN_R) die("No information");
	$UN_R->data_seek(0);
	while ($row=$UN_R->fetch_assoc()){
	$UN=$row["Username"];
	$reg_date=$row['reg_date'];
	
	}
	if(($count_num<($Page)*20)AND(($Page-1)*20<=$count_num)){
	echo "<h4>";


///////////////////////////////////////Check Block/////////////////////////////////////////////////////
$block_flag=0;
$block_user=explode(",",$_SESSION['blockeruser']); //[0] indicate first data

for ($i=0; $i<=sizeOf($block_user);$i++)
{
if($block_user[$i]==$UN)
	$block_flag=1;

}
///////////////////////////////////////Check Block/////////////////////////////////////////////////////	
//////////////////////////////////////Member Infor////////////////////////////////////////////////////	

   


   
	echo '<a  href="#" style="text-decoration: none" data-toggle="modal" data-target="#'.$count_num.'"><user_red>'.$UN.'</user_red></a>';
	if (isset($_SESSION['username']))
	{
echo '
     <div class="modal fade" id='.$count_num.' tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">User Information</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
              	<form class="form-horizontal">

				  <div class="form-group">
				    <div class="col-sm-3"><B><black>Username</black></B></div>
				    <div class="col-sm-3"><black>
				      '.$UN.'
				    </black></div>
					<div class="col-sm-6">
				    </div>
				  </div>';
				  if((isset($Username))&&($_SESSION['Activated']=="Yes"))
				{
					echo'
				  <div class="form-group">
				    <div class="col-sm-3 "><B><Black>Blocked?</Black></B></div>
				    <div class="col-sm-3">
					';
					if ($block_flag==0)
						echo '<Black>Not Blocked</Black>';
					else
						echo '<Black>Blocked</Black>';
					echo ' 
					 
				    </div>
					<div class="col-sm-6">
				    </div>
				  </div>
				  ';
				}
				echo '
				  <div class="form-group">
				    <div class="col-sm-3 "><B ><black>Member History</black></B></div>
				    <div class="col-sm-3">';
					
					
     $timestamp = strtotime($reg_date);
	if($timestamp <0)
		$timestamp=strtotime(Date("Y-m-d h:i:sa"));
	$now = strtotime(Date("Y-m-d h:i:sa"));
	$time = (($now-$timestamp)/60)/60;
	if($time>24)
		echo "<black>".round($time/24,0)."day member</black>";
	else 
		echo "<black>New member</black>";
	
			 
					 
				echo '</div>
					<div class="col-sm-6">
				    </div>
				  </div>
				  
				 
				  
				</form>
		      </div>
		
              <div class="modal-footer custom-modal-footer">';
			  
			    if((isset($Username))&&($_SESSION['Activated']=="Yes")&&($block_flag==0))
					echo '
			    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="block(\''.$UN.'\')" >Block</button>  
				<button type="button" class="btn btn-primary" data-dismiss="modal"  data-toggle="modal" data-target="#PM'.$count_num.'" >PM?</button>
				';
				echo '
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<!------------------------------- PM ------------------------------>
		<div class="modal fade" id="PM'.$count_num.'" tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">PM an User?</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
              	<form class="form-horizontal">
				  <form method="get">
	               <table>
		           <tr><td><label for="pmrecipient"><black>Recipient:</black> </label></td><td style="color:black;">'.$UN.'</td></tr>
		           <tr><td><label for="pmtopic"><black>Title:</black> </label></td><td><input type="text" maxlength="30" name="pmtopic" placeholder="Write the topic" style="width:370px;color:black;"></td></tr>
		           <tr><td><label for="pmcontent"><black>Content:</black> </label></td><td><textarea name="pmcontent" id="pmcontent" rows="10" cols="50" maxlength="300" placeholder="What you want to tell..." style="color:black;"></textarea></td></tr>
		           <tr><td></td><td><input type="button" name="submit" value="Send" style="color:black;" onclick="PM(\''.$UN.'\',\''.$Username.'\',pmtopic.value,pmcontent.value)"></a></td></tr>
	               </table>
                  </form>
				</form>
		      </div>
              <div class="modal-footer custom-modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				
		      </div>
		    </div>
		  </div>
		</div>
		<!------------------------------- PM end------------------------------>
		
		
		
';
	}
	else 
echo '
 <div class="modal fade" id='.$count_num.' tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">Are U PolyU student?</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
              	<form class="form-horizontal">

				   <div class="form-group">
				    <img src="nonmember.png"  width="600" height="400">
				  </div>
				    
				  
				</form>
		      </div>
              <div class="modal-footer custom-modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>	


';
//////////////////////////////////////Member Infor////////////////////////////////////////////////////
	
	echo "<id>"."#".$count_num."</id>"." ";
	
/////////////////////////////////Show Time//////////////////////////////////////////////////////////	
	$timestamp = strtotime($Date);
	if($timestamp <0)
		$timestamp=strtotime(Date("Y-m-d h:i:sa"));
	$now = strtotime(Date("Y-m-d h:i:sa"));
	$time = (($now-$timestamp)/60)/60;
	if($time>24)
		echo "<date>The post published ".round($time/24,0)." day before</date>";
	else if($time>1)
	  echo "<date>The post published ".round($time,0)." hours before</date>";
    else if ($time>0.5)
		echo "<date>The post published half hour before</date>";
	else if (($time*60)<3)
		echo "<date>The post just published!</date>";
	else echo "<date>The post published ".round(($time*60),0,PHP_ROUND_HALF_DOWN)." minutes before</date>";
	

////////////////////////////////Show Time END//////////////////////////////////////////////////////////////
	


	if(isset($Username)){
		if($Username=="Admin")
		{	
			echo "<button value=\"".$CommentID."\" id=\"x\" style=\"float: right;\" name=\"Delete\" onclick=\"ajaxcontent_delete(".$CommentID.",".$titleid.")\">X</button>";
		   	
		}
	}

if ($block_flag==0) //check Block
{
/////////////////////////////////Comment Content///////////////////////////////////////////////
	echo "<div id=\"forum_content\">"; 
	echo $Content;
	echo "<br>";
	echo "</div>";
	
///////////////////////////////refer ///////////////////////

	if((isset($Username)) && ($_SESSION['Activated']=="Yes")){

			echo "<a style=\"float: right;\" name=\"update\" onclick=\"ajaxcontent_refer(".$CommentID.",".$titleid.")\"><img src=\"refer.png\" width=\"20\" height=\"20\"></img></a>";

	}
///////////////////////////////Like////////////////////////////
///////////////////////////////Like///////////////////////

	if((isset($Username)) && ($_SESSION['Activated']=="Yes")){

			echo "<button value=\"update\" style=\"float: right;\" id=\"like\" name=\"update\" onclick=\"ajaxcontent_like(".$CommentID.",".$titleid.")\">Like</button>";
			
			echo "<div id=\"right\">"."<img src=\"thumb.png\" width=\"20\" height=\"20\"></img>:".$Like."<div>";
		   	

	}
///////////////////////////////Like////////////////////////////
	echo "</h4>";
	
}else
{
	echo "<div id=\"forum_content\">"; 
	echo "(Show Blocked User)";
	echo "<br>";
	echo "</div>";
	echo "</h4>";
}

	}
	//echo $count_num;
	$count_num++;
	
////////////////////////////////Comment Content//////////////////////////////////////////////////	
	
	

}
$_SESSION["CTS"]=	$CommentID;									//for next value to count page

?>


<!--Page Button-->
<?php
$P_Q = "select Count(CommentID) from Comment where TopicID = '".$titleid."'";
$P_R = $conn->query($P_Q);
if(!$P_R) die("No information");
$P_R->data_seek(0);
while ($row=$P_R->fetch_assoc()){
$P=$row["Count(CommentID)"];
}

echo "<form align=\"center\">";//useless
for($i=1;$i<= (floor(($P)/20)+1);$i++){
echo "<input style='color:black'  type=\"button\" name=\"page_num\" value=\"".$i."\" onclick=\"ajaxcontent_content(".$i.",".$titleid.")\">";
}
echo "</form>";

?>


</head>
<body>
<!--main-->
<?php
//echo $passage; 

?>


<!--own show when user name is defined-->

<?php
if(isset($Username)){

		if(isset($_GET["refer"]))
		{

			$R_Q = "select Content,UserID from Comment where CommentID = '".$_GET["refer"]."'";

			$R_R = $conn->query($R_Q);
			if(!$R_R) die("No information");
			$R_R->data_seek(0);
			while ($row=$R_R->fetch_assoc()){
			$Content1=$row["Content"];
			$CommentID1=$row["CommentID"];
			$Content1=str_replace("<polyu>","<img src=\"polyu.jpg\" name=\"source\" id=\"source\">",$Content1);
			$Content1=str_replace("<ILoveBonnie>","<img src=\"bonnie.jpg\" name=\"source\" id=\"source_bonnie\">",$Content1);
			$Content1=str_replace("<hr>","",$Content1);
			$Content1=preg_replace("/\n/", "<br />", $Content1);
			if(isset($Username)){}else{
			$Content1=preg_replace('/<member>(.*?)<\/member>/',"<small align=\"center\">Login to view it=)</small>",$Content1);
			}
			$UN_Q = "select Username from member where id = '".$row["UserID"]."'";
			$UN_R = $conn->query($UN_Q);
			if(!$UN_R) die("No information");
			$UN_R->data_seek(0);
			while ($row=$UN_R->fetch_assoc()){
			$UN1=$row["Username"];}
			}
			$ALL=$UN1."<div id=\"forum_content\">".$Content1."</div>";
			echo "<h4>".$ALL."</h4>";
			$_SESSION["refer"]="<h4 id=\"sub\">".$ALL."</h4>";
			

		}	






	
}
?>

<?php
if (isset($Username) && ($_SESSION['Activated']=="Yes"))
{	
?>
<!--java function of image 記得要係 index_Page 加番!!!!!!!-->
 <script type="text/javascript">
function memberimg(){
	document.getElementById('comment').value = document.getElementById('comment').value+"<member></member>";
}
function ccimg(){
	document.getElementById('comment').value = document.getElementById('comment').value+"<polyu>";
}

function bonnieimg(){
	document.getElementById('comment').value = document.getElementById('comment').value+"<ILoveBonnie>";
}
function check(){
	if(form_comment.comment.value=="")
	{
		return false;
	}
	else return true;
}

</script>

<form  method="post" align="center"  id="form_comment" action='forum.php#bottomOfPage' onsubmit="return check()">
<p id="forum_comment"></p>
<textarea name="comment" style="overflow:hidden;color:black" cols="100" rows="5%" id="comment"></textarea>
<br>
<a   onclick="memberimg()" name="member" id="member" value="Member Tag">MemberTaG</a>
<a    onclick="ccimg()" ><img src="polyu.jpg" name="polyu" id="polyu"></img></a>
<a   onclick="bonnieimg()" ><img src="bonnie.jpg" name="bonnie" id="bonnie"></img></a>

<a name="bottomOfPage"></a>
<br>
<div style="text-align:right">
<input type="submit" class="forum-submit-btn" name="submit" value="submit" id="submit2">
</div>
<br><br>
</form>





<?php
}
?>

<!-- write to database?-->




<?php
//prevent resubmit

$_SESSION["resubmit"]=1;


}
?>



</html>