<?php
 require_once("file://localhost/Users/DomFibich/Sites/eatsnation/mobile/resources/php/inc/connect.inc.php");
 	
 $logOk= false;
 $errorMsg="";
 $phoneNumber = mysql_real_escape_string($_POST['input0']);  
 $password = mysql_real_escape_string($_POST['input2']); 
 //$phoneNumber = "2832535";
 //$password = "schnvadda";
 //connect to the database here
 $username = mysql_real_escape_string($username);
 $query = "SELECT password, salt FROM tbl_customers WHERE customer_phone_number	= '$phoneNumber';";
 $result = mysql_query($query,$con);
 if(mysql_num_rows($result) > 1) //no such user exists
 {
     $errorMsg= $errorMsg." User does not exist! ";
     //header('Location: loginfail.php');
     $logOk = false;
 }
 else {
 	$logOk = true;
 }
 $userData = Null;
 $userData = mysql_fetch_array($result, MYSQL_ASSOC);
 $hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
 //echo "hash: ".$hash." <br />";
 echo $userData['pasword'];
 if($hash != $userData['password']) //incorrect password
 {
     
     $errorMsg = "passwords dont match".$userData['password'];
     //header('Location: loginfail.php');
     $logOk = false;
 }
 if($logOk == true)
 {
      $_SESSION['uid']= uniqid ($phoneNumber, true);
       echo("true_".$_SESSION['uid']);
 }   
 else 
 {
 	  echo("false");
 }
 
 


?>	