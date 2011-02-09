<?php

session_start();
include_once "config.php";

$user_table = "USER";
$reg_user = "REGULAR_USER";
$failedLogin=false;
$errorMessage='';

//username and password sent from form
$myemail=$_POST["myemail"];
$mypassword=$_POST["mypassword"];

//To protect against mysql injection
$myemail=stripslashes($myemail);
$mypassword=stripslashes($mypassword);
$myemail=mysql_real_escape_string($myemail);
$mypassword=mysql_real_escape_string($mypassword);

//prepare the sql querry
$sql = "SELECT * FROM $user_table WHERE Email='$myemail' AND Password='$mypassword'";
$result=mysql_query($sql);

//mysql_num_row is counting the number of rows
$count=mysql_num_rows($result);

//If result matched $myemail and $mypassword, table row must be 1 row
if($count==1){
	
	//register $myemail
	$_SESSION['email']=$myemail;

	//removed the password from being stored in the session

	//check if user is a regular user
	$qry="SELECT * FROM $reg_user WHERE Email='$myemail'";
	$result=mysql_query($qry);

	$count=mysql_num_rows($result);
	//if count is 1 then the user is a regular user
	if($count==1){
		session_write_close();
		header("Location: regularUser.php");
		exit();
	}
	else{
		$_SESSION['adminDate']='yes';
		session_write_close();
		header("Location: adminUser.php");
		exit();
	}
}
else{
	header("Location: main_login.php?login=1");
	exit();
}

?>
