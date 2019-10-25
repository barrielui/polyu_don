<?php
session_start(); //must be started , than activate destroy


session_unset();
session_destroy();


setcookie(email,$_SESSION['email'],time()-87600);
setcookie(password,$_SESSION['password'],time()-87600);
setcookie(username,$_SESSION['username'],time()-87600);

session_start();
$_SESSION["table"]=1;




?>