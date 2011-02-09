<?php

//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

//Session Email  //
$email = $_SESSION['email'];

$femail = $_POST["friEmail"];
$hometown = $_POST["home"];
$fName = $_POST["fName"];
$lName = $_POST["lName"];
$userRelation = $_POST["userRelationship"];
$userRelation = rtrim($userRelation);
$userRelation = mysql_real_escape_string($userRelation);

	if($userRelation == ''){
		header("Location: requestNewFriend.php?error=1&lname=$lName&fname=$fName&friEmail=$femail&home=$hometown");
		exit();
	}else{
		$sql = "INSERT INTO FRIENDSHIP (User_Email, Friend_Email, Relationship) VALUES('$email', '$femail', '$userRelation')";
		$sql_query = mysql_query($sql);
		header("Location: pendingFriends.php");
		exit();
	}

?>
