<?php
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}


//Session Email  //
$comment_email = $_SESSION['email'];

// checks for the profile we are currently viewing
$currentProfile = $_GET['currentProfile'];
$currentProfile = stripslashes($currentProfile);
$currentProfile = mysql_real_escape_string($currentProfile); 
$isRegUser = "SELECT Email FROM REGULAR_USER WHERE Email = '$currentProfile'";
$regUser = mysql_query($isRegUser);
if(mysql_num_rows($regUser) == 1)
{
	$userName = mysql_fetch_assoc($regUser);
	$email = $userName['Email'];
}

$newComment=$_POST["newComment"];
$newComment=mysql_real_escape_string($newComment);
$update_date = $_POST["update_date"];

	if($newComment == 'Add Comment Here' || $newComment == ''){
		header("Location: statusUpdates.php?currentProfile=" . $email);
		exit();

	}
	else{
		//change this
		$query = "INSERT INTO STATUS_COMMENT VALUES('$email','$update_date', NOW(), '$newComment','$comment_email')";
		$qry = mysql_query($query);
		header("Location: statusUpdates.php?currentProfile=" . $email);
		exit();
	}

?>
