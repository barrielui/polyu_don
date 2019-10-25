<!DOCTYPE html>
<html>
<?php

	session_start();
	
	$_SESSION["TopicID"]=1;
	$_SESSION["UserID"]=1;
	$_SESSION['topic_sort']=10000;
	
	$verify=0;
	$verify=$_GET['v'];
   

    if ($_SESSION['table']=="") $_SESSION['table']=1;
	if(isset($_GET["page_num"])){$_SESSION["S_page_num"]=$_GET["page_num"];}			//to transfer the page number to innerHTMl
    
	//////////////////////////////////////auto Login by Cookie/////////////////////////////////////////////
    if( (isset($_COOKIE['password'])) && (isset($_COOKIE['username'])) && (isset($_COOKIE['email'])) && (isset($_COOKIE['Activated'])))
		{
		$_SESSION['username']=$_COOKIE['username'];
		$_SESSION['email']=$_COOKIE['email'];
		$_SESSION['password']=$_COOKIE['password'];
		$_SESSION['Activated']=$_COOKIE['Activated'];
		}
    //////////////////////////////////////auto Login by Cookie END/////////////////////////////////////////////
	
    /////////////////////////////////////Find Blocked User////////////////////////////////////////////////
    //Database checking
    $servername = "*";
    $un = "*";
    $pw = "*";
    $dbname = "b3_20806446_Member";
    $block_num=1;
    // Create connection
    $conn = new mysqli($servername, $un, $pw, $dbname);
    // Check connection
    if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    } 
    $sql = "select UserName,BlockedUser from  Block";
    $result = $conn->query($sql);
    $block_list="";
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if($row['UserName']==$_SESSION['username'])
		{
			$block_list=$block_list.$row['BlockedUser'].',';
		}
		else $_SESSION['blockeruser']="";
    }
    } 
    $_SESSION['blockeruser']=$block_list;
    ////////////////////////////////Find Block User END//////////////////////////////////////////////////
	
	
	/////////GET User ID  

///////////////////////////////////////////////////////////////////////////////////////////////////////
	$query1 = "select id from member where UserName = '".$_SESSION['username']."'";
	$result1 = $conn->query($query1);
	$result1->data_seek(0);
	while ($row1 = $result1->fetch_assoc()){
		$userID = $row1['id'];
		
	}
	$result1->free();
	

	
	//$userID = "1";

	
?>
<head>
	<meta charset="utf-8">
	<title>PolyU DON</title>
	<link rel="stylesheet" type="text/css" href="./libs/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="./libs/css/sidebar.css">
	<link rel="stylesheet" type="text/css" href="./libs/css/custom.css">
	<link rel="stylesheet" type="text/css" href="./libs/css/forum.css">
	<link rel="stylesheet" type="text/css" id="theme" href="./libs/css/theme-blue.css">
	<script src="./libs/jquery/3.2.1/jquery-3.2.1.js"></script>
	<script src="./libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="./libs/javascript/ming.js"></script>
	<script src="./libs/javascript/marco.js"></script>
	<link rel="icon" type="image/png" href="polyu.jpg" sizes="16x16">
</head>

<script>
function changeTheme(t){
  if (t == 1) {
    document.getElementById("theme").href = "./libs/css/theme-blue.css";
    document.cookie = "theme=1;"
  } 
  else if (t == 2) {
    document.getElementById("theme").href = "./libs/css/theme-green.css";
    document.cookie = "theme=2;"
  }
  else if (t == 3) {
    document.getElementById("theme").href = "./libs/css/theme-red.css";
    document.cookie = "theme=3;"
  }
}

<?php 
    //////////////////////////////////////     Theme     ///////////////////////////////
    if (isset($_COOKIE['theme'])) {
      //echo "<script type='text/javascript'>changeTheme(".$_COOKIE['theme'].");</script>";
      echo "changeTheme(".$_COOKIE['theme'].");";
    } else {
      setcookie("theme",1,time()+86400);
    }
?>
///////////////////////////////////////////Login & Registration///////////////////////////////////////////////////////////////////////////////////
function Check_Username() {
    var str = R_username.value;
    if (str.length == 0) { 
       error_username.innerHTML = "";      
    } 
      else {
                   var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK" 
                                                                                                       //When readyState is 4 and status is 200, the response is ready:
                           error_username.innerHTML =this.responseText;           //this.responseText if refer to the echo "(result)" from check.php
                           var state1=this.responseText;
                   }
                   }
          xmlhttp.open("GET", "check_name.php?username="+str , true); //open the php file for AJAX
          xmlhttp.send(); //send the request
           }
}
function Check_Email() {	  		  
    var str = R_email.value;
    if (str.length == 0) { 
       error_email.innerHTML = "";       
    } 
      else {
                   var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK" 
                                                                                                       //When readyState is 4 and status is 200, the response is ready:
                           error_email.innerHTML =this.responseText;           //this.responseText if refer to the echo "(result)" from check.php
						   var state2= this.responseText;						   
                   }
                   }
          xmlhttp.open("GET", "check_email.php?email="+str , true); //open the php file for AJAX
          xmlhttp.send(); //send the request
           }          
}
function Check_Repassword(){
    var str = R_repassword.value;
    var compare=R_password.value;
    if (str.length == 0) { 
       error_repassword.innerHTML = "";  
    } 
      else {
                   var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK" 
                                                                                                       //When readyState is 4 and status is 200, the response is ready:
                           error_repassword.innerHTML =this.responseText;           //this.responseText if refer to the echo "(result)" from check.php									   
                   }
                   }
         xmlhttp.open("GET", "check_repassword.php?repassword="+str+"&password="+compare , true);
            			 //open the php file for AJAX
          xmlhttp.send(); //send the request
           }
}
function Check_Button() {
   
       var state1=error_username.innerHTML;
	   var state2=error_email.innerHTML;
	   var state3=error_repassword.innerHTML;
        if (( state1=="✓") && ( state2=="✓") && ( state3=="✓"))
		{
			 Send_Email();			
		}
      
}
function Send_Email(){
	
                   var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK" 
                           						   //When readyState is 4 and status is 200, the response is ready:
                        send_email.innerHTML =this.responseText;  							
                   }
                   }
          xmlhttp.open("GET", "send_email.php" , true); //open the php file for AJAX
          xmlhttp.send(); //send the request	  
          alert("Registration Sucess!");
		   location.reload();
}
function Check_Login(){ 
    var str = userEmail.value;
	var str1 = userPassword.value;
	var str2 = Remember_tag.value;
	var result="";
	
    if ( (str.length == 0) &&  (str1.length == 0) ) { 
              alert("Please Input your email and password");
    } 
      else {
                   var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK" 
                                                                                                       //When readyState is 4 and status is 200, the response is ready:                      
					   alert(this.responseText);
					   if(this.responseText.length==15)
						    location.reload();		  
                   }
                   }
          xmlhttp.open("GET", "check_login.php?email="+str+"&password="+str1+"&remember_tag="+str2, true); //open the php file for AJAX
          xmlhttp.send(); //send the request
           }	
}
function Logout(){
                   var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                          
						alert("Logout Sucess!");
	                    window.location.assign("http://polyudon.byethost3.com/lok/index.php");
                   }
                   }
          xmlhttp.open("GET", "logout.php", true); //open the php file for AJAX
          xmlhttp.send(); //send the request  
}
///////////////////////////////////////////Login & Registration///////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////Forum ///////////////////////////////////////////////////////////////////////////////////////////////
function stateChange1() {
if ( (xmlHttp.readyState == 4) &&(xmlHttp.status == 200) ) {

document.getElementById("forum-content").innerHTML = xmlHttp.responseText;

}
}

 /////////////////////////////////////check new post title content empty/////////////////		
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
 
function ajaxcontent(TopicID,Reset) {




if(Reset!=1)
gettable(<?php if($_SESSION['table']!="") echo $_SESSION['table']; ?>);

xmlHttp=null;
if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
} else if (window.ActiveXObject) {
xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}
if (xmlHttp != null) {
xmlHttp.onreadystatechange = stateChange1;

xmlHttp.open("GET", "forum.php?ID="+TopicID+"&reset="+Reset, true);
xmlHttp.send();
} else {
alert("Your browser does not support XMLHTTP.");

}
}

function ajaxcreate_post(CategoryID){
xmlHttp=null;
if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
} else if (window.ActiveXObject) {
xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}
if (xmlHttp != null) {
xmlHttp.onreadystatechange = stateChange1;


xmlHttp.open("GET", "new_post.php?CategoryID="+CategoryID, true);

xmlHttp.send();
} else {
alert("Your browser does not support XMLHTTP.");

}
	
}
function stateChange() {
if ( (xmlHttp.readyState == 4) &&(xmlHttp.status == 200) ) {

document.getElementById("forum-content").innerHTML = xmlHttp.responseText;

}
}
function ajaxcontent_content(i,TopicID) {
	
xmlHttp=null;
if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
} else if (window.ActiveXObject) {
xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}
if (xmlHttp != null) {
xmlHttp.onreadystatechange = stateChange;
xmlHttp.open("GET", "forum.php?page_num="+i+"&ID="+TopicID+"#Top", true);
xmlHttp.send();

} else {
alert("Your browser does not support XMLHTTP.");
}
window.scrollTo(0, 0);
}
function ajaxcontent_delete(i,TopicID) {
xmlHttp=null;
if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
} else if (window.ActiveXObject) {
xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}
if (xmlHttp != null) {
xmlHttp.onreadystatechange = stateChange;
xmlHttp.open("GET", "forum.php?Delete="+i+"&ID="+TopicID+"#Top", true);
xmlHttp.send();

} else {
alert("Your browser does not support XMLHTTP.");
}
window.scrollTo(0, 0);
}


function ajaxcontent_like(i,TopicID) {
xmlHttp=null;
if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
} else if (window.ActiveXObject) {
xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}
if (xmlHttp != null) {
xmlHttp.onreadystatechange = stateChange;
xmlHttp.open("GET", "forum.php?Like="+i+"&ID="+TopicID, true);
xmlHttp.send();

} else {
alert("Your browser does not support XMLHTTP.");
}}

function ajaxcontent_refer(i,TopicID) {
xmlHttp=null;
if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
} else if (window.ActiveXObject) {
xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}
if (xmlHttp != null) {
xmlHttp.onreadystatechange = stateChange;
xmlHttp.open("GET", "forum.php?refer="+i+"&ID="+TopicID, true);
xmlHttp.send();

} else {
alert("Your browser does not support XMLHTTP.");
}
window.scrollTo(0,document.body.scrollHeight);
}


function ajax_hotpost(TopicID){
	xmlHttp=null;
	if (window.XMLHttpRequest) {
		xmlHttp = new XMLHttpRequest();
	} 
	else if (window.ActiveXObject) {
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if (xmlHttp != null) {
		xmlHttp.onreadystatechange = stateChange;
		xmlHttp.open("GET", "forum.php?ID="+TopicID, true);
		xmlHttp.send();

	} else {
		alert("Your browser does not support XMLHTTP.");
	}
	window.scrollTo(0, 0);
}

/////////////////////////////////////////////Forum END////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////The function which is used in Comment///////////////////////////////////////////////
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
		alert("寫D野啦仆街");
	}
	else return true;
}
////////////////////////The function which is used in Comment END///////////////////////////////////////////////


/////////////////////////////////////Others//////////////////////////////////////////////////////////////////////
function gettable(categoryid){
	      
		  table.innerHTML='<div align="center"id="loading" ><div class="loader" style="display:block"></div></div></div>';
                var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                            
						table.innerHTML =this.responseText; 
						page_button.innerHTML='<ul class="pagination"><li class="page-item"><a class="page-link"  href="#" onclick="nextTopic(-2)" >Previous</a></li><li class="page-item"><a class="page-link"  href="#" onclick="gettable(0)" >Refresh</a></li> <li class="page-item"><a class="page-link" href="#" onclick="nextTopic(-1)">Next</a></li> </ul>';
                   }
                   }
				  
          xmlhttp.open("GET", "table.php?id="+categoryid, true); //open the php file for AJAX
          xmlhttp.send(); //send the request
		 
}
function searchtable(action,topic_name){
	      
		  table.innerHTML='<div align="center"id="loading" ><div class="loader" style="display:block"></div></div></div>';
                var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                            
						table.innerHTML =this.responseText; 
						if(action==0)
						page_button.innerHTML ="";
					else 
						page_button.innerHTML='<ul class="pagination"><li class="page-item"><a class="page-link"  href="#" onclick="searchtable(2)" >Previous</a></li><li class="page-item"><a class="page-link" href="#" onclick="searchtable(3)">Next</a></li> </ul>';
					
                   }
                   }
				  
          xmlhttp.open("GET", "search.php?action="+action+"&topic_name="+topic_name, true); //open the php file for AJAX
          xmlhttp.send(); //send the request
		 
}
function showPM(pmid,userid)
{
	pmread.innerHTML='<div align="center"id="loading" ><div class="loader" style="display:block"></div></div></div>';
	var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                            
						var res = this.responseText.split("@@@");
						pmread.innerHTML=res[0];
						
						pmrecipient.value=res[1];
                   }
                   }
				  
          xmlhttp.open("GET", "pm-read.php?pmID="+pmid+"&userID="+userid, true); //open the php file for AJAX
          xmlhttp.send(); //send the request	
}
function block(blockuser){
	
	  var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK" 
                             
					alert(this.responseText);
                   }
                   }
				  
          xmlhttp.open("GET", "block.php?blockuser="+blockuser, true); //open the php file for AJAX
          xmlhttp.send(); //send the request
}
function verification(username,code){
	  var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK" 
                                           
					   alert(this.responseText);
					  if (this.responseText=="User Activated") 
					    
					    Logout();
                   }
                   }
				  
          xmlhttp.open("GET", "code_verified.php?username="+username+"&code="+code, true); //open the php file for AJAX
          xmlhttp.send(); //send the request
}
function nextTopic(next){
  var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                            
						table.innerHTML =this.responseText; 
                   }
                   }
				  
          xmlhttp.open("GET", "table.php?id="+next, true); //open the php file for AJAX
          xmlhttp.send(); //send the request
		   
}
function PM(receiver,sender,topic,content){
	
	
	if((topic=="")||(content==""))
		alert("Topic or Content cannot be empty");
	else
	{	
   var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                            
						alert(this.responseText);
						if(this.responseText!="No such user")
						{
						location.reload();
						}
                   }
                   }
				  
          xmlhttp.open("GET", "pm-sent.php?pmrecipient="+receiver+"&pmsender="+sender+"&pmtopic="+topic+"&pmcontent="+content, true); //open the php file for AJAX
          xmlhttp.send(); //send the request
	}
}
function showPM(pmid,userid)
{
	
	pmread.innerHTML='<div align="center"id="loading" ><div class="loader" style="display:block"></div></div></div>';
	var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                            
						var res = this.responseText.split("@@@");
						pmread.innerHTML=res[0];
						
						pmrecipient.value=res[1];
						
						CheckPM.innerHTML=res[2];
                   }
                   }
				  
          xmlhttp.open("GET", "pm-read.php?pmID="+pmid+"&userID="+userid, true); //open the php file for AJAX
          xmlhttp.send(); //send the request	
}
function PM_clear()
{
	pmrecipient.value="";
}
function delPM(pmid,userid){
	CheckPM.innerHTML='<div align="center"id="loading" ><div class="loader" style="display:block"></div></div></div>';
  var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                            
                     
                   var res = this.responseText.split("@@@");
				   
				   CheckPM.innerHTML=res[1];
                  					
                   }
                   }
          xmlhttp.open("GET", "pm-del.php?pmID="+pmid+"&userID="+userid, true); //open the php file for AJAX
          xmlhttp.send(); //send the request  
}
function forgetPW(F_Email)
{
	var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                            
                     
                   alert(this.responseText);
                  					
                   }
                   }
          xmlhttp.open("GET", "forgetPW.php?F_Email="+F_Email, true); //open the php file for AJAX
          xmlhttp.send(); //send the request  

	
}
/////////////////////////////////////Others//////////////////////////////////////////////////////////////////////
</script>

<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
 
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<?php if (!(isset($_SESSION["$titleid"]))) $_SESSION["$titleid"]=0;?>

<body onload="ajaxcontent(<?php echo $_SESSION["$titleid"]?>,<?php if ($verify==-1) echo -1; else echo 0;?>)">

<nav class="navbar custom-navbar-inverse custom-navbar-fixed-top navbar-expand-lg " style="margin-bottom: 0px; border-radius:0;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
      </button>
      <a class="navbar-brand menu-toggle" href="#menu-toggle" onclick="Sidebar()"><span class="glyphicon glyphicon-cog"> </span></a>
      <a class="navbar-brand" href="#" onclick="ajaxcontent(0,0)"><span class="glyphicon glyphicon-home"></span> PolyU DON</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="http://www.eie.polyu.edu.hk"><span class="glyphicon glyphicon-info-sign"></span> About Us </a></li>
      </ul>


      <ul class="nav navbar-nav navbar-right">
		<?php
		if( ( (isset($_SESSION['password'])) && (isset($_SESSION['username'])) && (isset($_SESSION['email'])))  )
		{
		if($_SESSION['Activated']=="Yes")
		echo  '<li><a href="#"  data-toggle="modal" data-target="#Check_PM"><span class="glyphicon glyphicon-user"></span>'.$_SESSION['username'].'</a></li>';
		else echo '<li><a href="https://login.microsoftonline.com/common/oauth2/authorize?client_id=00000002-0000-0ff1-ce00-000000000000&redirect_uri=https%3a%2f%2foutlook.office.com%2fowa%2f&resource=00000002-0000-0ff1-ce00-000000000000&response_mode=form_post&response_type=code+id_token&scope=openid&msafed=0&client-request-id=d3f71ca2-1676-4ff5-87c8-7085e620e7e8&protectedtoken=true&domain_hint=connect.polyu.hk&nonce=636475228028405682.0d9a4341-ed44-4a29-8bfc-9c0f366167b8&state=DYtLDoMgFACxvYs7PuITcGG8Q2_wQAykKMZA2t6-LGZWMx0h5Nl4NDrRRLQaFehJSiOkATEpI5nYZoQRBuo3AAooZ2rs7ujsxD4qNShtTdfelecP8vX2mI7F5fP0rrArp19l4d1fWMLCD4yJx9Pmb4-1hJff4t2ypdzV_wE"><B>you have to activate yout account</B></a></li>';
		echo  '<li><a data-toggle="modal" data-target="#logout">Logout</a></li>';
	    
		}
	    else
		{
        echo '<li><a href="#" data-toggle="modal" data-target="#register"><span class="glyphicon glyphicon-pencil"></span> Register </a></li>';
        echo '<li><a href="#" data-toggle="modal" data-target="#login"><span class="glyphicon glyphicon-user"></span> Login </a></li>';
		}
		?>
		<!------------------------------- Registration ------------------------------>
		<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">Register an Account</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
              	<form class="form-horizontal">
				  <div class="form-group">
				    <label for="R_username" class="col-sm-2 col-lg-3 control-label">Username</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" id="R_username" placeholder="Enter your username within 15 characters" maxlength="15" onkeyup="Check_Username()">
                      <span class="error" id="error_username"></span>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="R_password" class="col-sm-2 col-lg-3 control-label">Password</label>
				    <div class="col-sm-6">
				      <input type="password" class="form-control" id="R_password" placeholder="Enter your password within 20 characters" maxlength="20">
				    </div>
				  </div>
                  <div class="form-group">
				    <label for="R_repassword" class="col-sm-2 col-lg-3 control-label">Confirm your password</label>
				    <div class="col-sm-6">
				      <input type="password" class="form-control" id="R_repassword" placeholder="Enter your password again" maxlength="20" onkeyup="Check_Repassword()">
                      <span class = "error" id = "error_repassword"></span>
				    </div>
				  </div>
                  <div class="form-group">
				    <label for="R_email" class="col-sm-2 col-lg-3 control-label">Email</label>
				    <div class="col-sm-6">
				      <input type="email" class="form-control" id="R_email" placeholder="Polyu Email Account" onkeyup="Check_Email()">
                      <span class = "error" id="error_email"></span>
				    </div>
				  </div>
				</form>
		      </div>
              <div class="modal-footer custom-modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary custom-btn-modal"  onclick="Check_Button()" >Register</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!------------------------------- Registration end------------------------------>
		
		<!------------------------------- Check PM ------------------------------>

<style type="text/css">
		.pm {
			border: 2px solid;
		}
		.pm tr,th,td {
			border: 2px solid;
		}
</style>

		<div class="modal fade" id="Check_PM" tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">Check PM</h5>
		      </div>
		      
				 <table class="pm" width="500" height="200" align="center" id="CheckPM">
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
				echo "<tr><td><a data-dismiss='modal'  data-toggle='modal' data-target='#showPM' onclick='showPM(\"".$row["pmID"]."\", \"".$userID."\")'>".$row['Topic']."</a></td><td>".$row['UserName']."</td><td>".$row['Date']."</td><td>".$Viewed."</td></tr>";
			}
			$result->free();
		}
	?>
</table>
<?php 
	$conn->close();
?>
 
              <div class="modal-footer custom-modal-footer">
			    <button type="button" class="btn btn-info" data-dismiss='modal'  data-toggle='modal' data-target='#PM' onclick="PM_clear()">Draft Message</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
		      </div>
		    </div>
		  </div>
		</div>
		<!------------------------------- Check PM end------------------------------>
				<!------------------------------- Show PM ------------------------------>
<div class="modal fade" id="showPM" tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">PM Message</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
              	<form class="form-horizontal">
				 <div id="pmread"></div>
				</form>
		      </div>
              <div class="modal-footer custom-modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!------------------------------- Show PM end------------------------------>
 
       <!------------------------------- PM ------------------------------>
		<div class="modal fade" id="PM" tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">PM an User?</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
              	<form class="form-horizontal" id="PM_user">
				  <form method="get">
	               <table>
		           <tr><td><label for="pmrecipient">Recipient: </label></td><td><input type="text" maxlength="30" id="pmrecipient" name="pmrecipient" placeholder="username" style="width:370px;"></td></tr>
		           <tr><td><label for="pmtopic">Title: </label></td><td><input type="text" maxlength="30" name="pmtopic" placeholder="Write the topic" style="width:370px;color:black;"></td></tr>
		           <tr><td><label for="pmcontent">Content: </label></td><td><textarea name="pmcontent" id="pmcontent" rows="10" cols="30" maxlength="300" placeholder="What you want to tell..." style="color:black;"></textarea></td></tr>
		           <tr><td></td><td><input type="button" name="submit" value="Send" style="color:black;" onclick="PM( pmrecipient.value,'<?php echo $_SESSION['username']?>',pmtopic.value,pmcontent.value)"></a></td></tr>
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
		<!------------------------------- Login ------------------------------>
		<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registerLabel" >
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="loginLabel">Login</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
				<form class="form-horizontal">
				  <div class="form-group">
				    <label for="userEmail" class="col-sm-2 control-label">Email</label>
				    <div class="col-sm-6">
				      <input type="email" class="form-control" id="userEmail" placeholder="Email">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="userPassword" class="col-sm-2 control-label">Password</label>
				    <div class="col-sm-6">
				      <input type="password" class="form-control" id="userPassword" placeholder="Password">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <div class="checkbox">
				        <label>
				          <input type="checkbox" id="Remember_tag" value="Yes"> Remember me
				        </label>
				      </div>
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="button" class="btn btn-primary custom-btn-modal"  onclick="Check_Login()" >Sign in</button>
				    </div>
				  </div>
				</form>
		      </div>
		      <div class="modal-footer custom-modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-default"data-dismiss='modal'  data-toggle='modal' data-target='#forget_PW' >Forgot Password?</button>
		      </div>
		    </div>
		  </div>
		</div> 
		<!------------------------------- Login end------------------------------>
		
<!------------------------------- Foreget Password ------------------------------>
		<div class="modal fade" id="forget_PW" tabindex="-1" role="dialog" aria-labelledby="registerLabel" >
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="loginLabel">Forget Password</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
				<form class="form-horizontal">
				  <div class="form-group">
				    <label for="userEmail" class="col-sm-2 control-label">Email</label>
				    <div class="col-sm-6">
				      <input type="email" class="form-control" id="F_Email" placeholder="The password will automatically send to you">
				    </div>
				
				</form>
		      </div>
		      <div class="modal-footer custom-modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="forgetPW(F_Email.value)">Send Me the Password</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div> 
		</div>
		<!------------------------------- Foreget Password end------------------------------>
		
				
		<!------------------------------- Logout ---------------------------->
		<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h5 class="modal-title custom-modal-title" id="registerLabel">Logout</h5>
		      </div>
		      <div class="modal-body custom-modal-body">
                <form class="form-horizontal">				 
				   <div class="form-group">
				    <label for="R_email" class="col-sm-6 control-label">Are you sure you want to logout?</label>
				  </div>   
				</form>
		      </div>
               <div class="modal-footer">
			   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			   <button  typr="button"  class="btn btn-primary" id="Logout"  onclick="Logout()">Yes</button>
		       </div>
		    </div>
		  </div>
		</div> 
		<!------------------------ Logout end ---------------------------->       
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
    <!-- /#sidebar-wrapper -->
</nav>

<section>
    <div id="wrapper" class="toggled">

        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="custom-sidebar-wrapper">
            <ul class="sidebar-nav custom-sidebar-nav">
				<li class="sidebar-brand">
                	<a href="#">Channel</a>
                </li>
				<li>
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(1)"><span class="glyphicon glyphicon-cutlery"></span> Chit-chat</a>
                </li>
				<li>
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(2)"><span class="glyphicon glyphicon-cutlery"></span> Audio/Video</a>
                </li>
				<li>
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(3)"><span class="glyphicon glyphicon-briefcase"></span> PolyU</a>
                </li>
				<li>
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(4)"><span class="glyphicon glyphicon-cutlery"></span> Electronics</a>
                </li>
				<li>
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(5)"><span class="glyphicon glyphicon-cutlery"></span> Academic</a>
                </li>
                <hr />
				<li class="sidebar-brand">
                    <a href="#" onclick="searchtable(0)" class="sidebar-brand menu-toggle" >Search Post</a>
                </li>
                <li>
					
                </li>  
				<hr/>
				<li class="sidebar-brand">
                	<a href="#">Mode</a>
                </li>
                <li>
					<button type="button" class="btn custom-btn-sidebar" style="width:60%;height=50%;background-color:Blue" onclick="changeTheme(1)">Blue</button><br/>
                </li>  
                <li>
					<button type="button" class="btn custom-btn-sidebar" style="width:60%;height=50%;background-color:Green" onclick="changeTheme(2)">Green</button><br/>
                </li>  
                <li>
					<button type="button" class="btn custom-btn-sidebar" style="width:60%;height=50%;background-color:Red" onclick="changeTheme(3)">Red</button>
                </li>
                
                     	
            </ul>
        </div>


        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div class="forum-container">
        	<div id="page-content" class="row">
        		<div class="col-xs-3 col-sm-3 col-lg-3 forum-left">
        			<div class="forum-left-content">
        				<div id="table"> <!-- get the content page of a specific category -->
                        <div align="center"id="loading" ><div class="loader" style="display:block"></div></div>
						</div>       				
						
        			</div>
        		</div>
        		<div class="col-xs-9 col-sm-9 col-lg-9 forum-right">
        			<div class="forum-right-content" id="forum-content">
					<div align="center"id="loading" ><div class="loader" style="display:block"></div></div>
        			</div>
        		</div>
        	</div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
</section>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>
    $(".menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>
</html>