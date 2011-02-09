<?php
//check if session is not registered, redirect back to main login page
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

//Session email
$user_email = $_SESSION['email'];

//SQL table names
$regular_user_interests = "REGULAR_USER_INTEREST";
$newInterest = trim($_POST['userInterest']);
$ewInterest = mysql_real_escape_string($newInterest);


//check if the new interest field was set and is not an empty string
if(isset($newInterest) && $newInterest!="" && $newInterest!="..."){
	//check if the interest is already in the database	
	$sql = "SELECT * FROM $regular_user_interests WHERE Email='$user_email' AND Interest='$newInterest'";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	if($count==0){
		//add the new interest into the insert table and redirect back to the edit user page
		$sql = "INSERT INTO $regular_user_interests (`Email`,`Interest`) VALUES ('$user_email','$newInterest')";
		$result = mysql_query($sql);
	}
}

//redirect the user back to the edit user page
header("Location: editProfile.php");		

?>
