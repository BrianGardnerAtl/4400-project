<?php
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}


//Session Email  //
$email = $_SESSION['email'];

$newStatus=$_POST["newStatusUpdate"];
$newStatus = mysql_real_escape_string($newStatus);


	if($newStatus == 'Enter new Status Update Here' || $newStatus == ''){
		header("Location: statusUpdates.php");
		exit();

	}
	else{
		//change this
		$query = "INSERT INTO STATUS_UPDATE VALUES('$email',NOW(),'$newStatus')";
		$qry = mysql_query($query);
		header("Location: statusUpdates.php");
		exit();
	}

?>
