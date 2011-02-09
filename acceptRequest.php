<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}


//Session Email  //
$email = $_SESSION['email'];
$femail = $_POST['friendEmail'];

//echo "my email " . $email . "<br>";
//echo "friend email " . $femail . "<br>";

$sql = "UPDATE FRIENDSHIP SET Date_Connected = NOW() WHERE User_Email='$femail' AND Friend_Email='$email'";
$sql_query = mysql_query($sql);
	header("Location: pendingFriends.php");
	exit();
?>