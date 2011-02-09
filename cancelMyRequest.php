<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}


//Session Email  //
$email = $_SESSION['email'];
$friendEmail = $_POST['friendEmail'];



//echo "my email: " . $email . "<br>" ;
//echo "friend email: " . $friendEmail . "<br>" ;

$sql = "DELETE FROM FRIENDSHIP WHERE User_Email='$email' AND Friend_Email='$friendEmail'";
$sql_query = mysql_query($sql);
	header("Location: pendingFriends.php");
	exit();



?>