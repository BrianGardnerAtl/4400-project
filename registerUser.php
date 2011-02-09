<?php

session_start();
include_once "config.php";

$user_table = "USER";
$reg_user = "REGULAR_USER";

if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['myemail']) && isset($_POST['mypassword']) && isset($_POST['mypassword2']) && $_POST['firstName']!="" && $_POST['lastName']!="" && $_POST['myemail']!="" && $_POST['mypassword']!=""){

$firstName = mysql_real_escape_string($_POST['firstName']);
$lastName = mysql_real_escape_string($_POST['lastName']);
$myemail = $_POST['myemail'];
$mypassword = $_POST['mypassword'];
$passConfirm = $_POST['mypassword2'];

$_SESSION['regError'] = "";
//check if the passwords do not match
if(strcmp($mypassword, $passConfirm) != 0){
	$_SESSION['regError'] = "Passwords do not match";
	header("Location: registration.php?error=1");
	exit();
}

$myemail = stripslashes($myemail);
$mypassword = stripslashes($mypassword);
$myemail = mysql_real_escape_string($myemail);
$mypassword = mysql_real_escape_string($mypassword);

//check if the email address is already being used
$sql = "Select * FROM $user_table WHERE Email='$myemail'";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

if($count==0){
	//no email in database so register the user
	$query = "INSERT INTO USER VALUES('$myemail','$firstName','$lastName','$mypassword')";
	//$_SESSION['println'] = $query;
	//$result = mysql_query($query);
	$_SESSION['email'] = $myemail;
	$_SESSION['regPassword'] = $mypassword;
	$_SESSION['regFirst'] = $firstName;
	$_SESSION['regLast'] = $lastName;
	header("Location: editProfile.php?newUser=1");
}
else{
	//email already exists in database
	$_SESSION['regError'] = "This email is already being used. Please select another email";
	header("Location: registration.php?error=2");
	exit();
}
}
else{
	//not all of the forms have been filled
	$_SESSION['regError'] = "Please fill out all forms before continuing";
	header("Location: registration.php?error=3");
	exit();
}
?>
