<!DOCTYPE html>
<html>
<?php

	session_start();
	$_SESSION["TopicID"]=1;
	$_SESSION["UserID"]=1;
	if(isset($_GET["page_num"])){$_SESSION["S_page_num"]=$_GET["page_num"];}			//to transfer the page number to innerHTMl
    
	//////////////////////////////////////auto Login by Cookie/////////////////////////////////////////////
    if( (isset($_COOKIE['password'])) && (isset($_COOKIE['username'])) && (isset($_COOKIE['email'])))
		{
		$_SESSION['username']=$_COOKIE['username'];
		$_SESSION['email']=$_COOKIE['email'];
		$_SESSION['password']=$_COOKIE['password'];
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
	<script src="./libs/javascript/lok.js"></script>
	<link rel="icon" type="image/png" href="polyu.jpg" sizes="16x16">
</head>

<script>
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
	                     location.reload();
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

 
function ajaxcontent(TopicID,Reset) {
	

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
	      
                var xmlhttp = new XMLHttpRequest();                   //All modern browsers have a built-in XMLHttpRequest object to request data from a server.
                   xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {         //readyState: 4: request finished and response is ready ; status: 200: "OK"                                            
						table.innerHTML =this.responseText; 
                   }
                   }
				  
          xmlhttp.open("GET", "table.php?id="+categoryid, true); //open the php file for AJAX
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
					    window.location.assign("http://polyudon.byethost3.com/lok/index.php");
                   }
                   }
				  
          xmlhttp.open("GET", "code_verified.php?username="+username+"&code="+code, true); //open the php file for AJAX
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

<body onload=" ajaxcontent_content(<?php echo $_SESSION["$titleid"]?>,-1)">

<nav class="navbar custom-navbar-inverse custom-navbar-fixed-top navbar-expand-lg " style="margin-bottom: 0px; border-radius:0;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
      </button>
      <a class="navbar-brand menu-toggle" href="#menu-toggle" onclick="Sidebar()"><span class="glyphicon glyphicon-cog"> </span></a>
      <a class="navbar-brand" href="#" onclick="ajaxcontent(0,0)">PolyU DON</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span> Home <span class="sr-only">(current)</span></a></li>
        <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> About Us </a></li>
      </ul>


      <ul class="nav navbar-nav navbar-right">
		<?php
		if( ( (isset($_SESSION['password'])) && (isset($_SESSION['username'])) && (isset($_SESSION['email'])))  )
		{
		if($_SESSION['Activated']=="Yes")
		echo  '<li><a href="#"  data-toggle="modal" data-target="#user_info"><span class="glyphicon glyphicon-user"></span>'.$_SESSION['username'].'</a></li>';
		else echo '<li><a href="#"  data-toggle="modal" data-target="#user_info">you have to activate yout account</a></li>';
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
		        <button type="button" class="btn btn-default">Forgot Password?</button>
		      </div>
		    </div>
		  </div>
		</div> 
		<!------------------------------- Login end------------------------------>
		<!------------------------------- Logout ---------------------------->
		<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="registerLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header custom-modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title custom-modal-title" id="registerLabel">Logout</h4>
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
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(1)"><span class="glyphicon glyphicon-cutlery"></span> 吹水台</a>
                </li>
				<li>
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(2)"><span class="glyphicon glyphicon-cutlery"></span> AV台</a>
                </li>
				<li>
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(3)"><span class="glyphicon glyphicon-briefcase"></span> 理工台</a>
                </li>
				<li>
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(4)"><span class="glyphicon glyphicon-cutlery"></span> 電子台</a>
                </li>
				<li>
                	<a href="#" class="sidebar-brand menu-toggle" onclick="gettable(5)"><span class="glyphicon glyphicon-cutlery"></span> CKLeung台</a>
                </li>
                <hr />
				<li class="sidebar-brand">
                	<a href="#">Mode</a>
                </li>
                <li>
					<button type="button" class="btn custom-btn-sidebar" style="width:60%;" onclick="changeTheme(1)">Blue</button><br/>
                </li>  
                <li>
					<button type="button" class="btn custom-btn-sidebar" style="width:60%;" onclick="changeTheme(2)">Green</button><br/>
                </li>  
                <li>
					<button type="button" class="btn custom-btn-sidebar" style="width:60%;" onclick="changeTheme(3)">Red</button>
                </li>
                <hr />
                <li class="sidebar-brand">
                    <a href="#">Font Size</a>
                </li>
                <li>
					<div class="btn-group">
					<button type="button" class="btn custom-btn-sidebar" onclick="">S</button>
					<button type="button" class="btn custom-btn-sidebar" onclick="">M</button>
					<button type="button" class="btn custom-btn-sidebar" onclick="">L</button>
					</div>
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
						<table>
						<tr>
						<th>You are now in <b>吹水台</b></th>
						<?php
						$topic_count=0;
                        $flag=0;
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

                        $sql = "SELECT Topic_name,TopicID,CategoryID FROM Topic";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
		                if(($row["CategoryID"]==1)&&($topic_count<7))
		                {
			             echo "<tr><td><a href='#' onclick='ajaxcontent(".$row['TopicID'].",1)'>".$row["Topic_name"]."</a></td></th>";
			             $flag=1;
						 $topic_count++;
		                }
			            }
                        } 
                        $conn->close();
                        if ($flag==0)		
                        echo "<tr><td>No topic</td></th>";
                        ?>
						</table>
						</div>
        				<div class="forum-left-footer">
	        				<select>
	        					<option value="1">1</option>
	        					<option value="2">2</option>
	        				</select>
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


