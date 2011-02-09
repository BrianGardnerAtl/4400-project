<?php

session_start();
include_once "config.php";

$schoolName=mysql_real_escape_string($_POST["schoolName"]);
$schoolType=mysql_real_escape_string($_POST["schoolType"]);

if($schoolName == '')
{
	header("Location: schoolList.php");
	exit();
}
else 
{
	$qry = "INSERT INTO SCHOOL VALUES('$schoolName', '$schoolType')";
	$sType = mysql_query($qry);
	if(!$sType)
	{
		$_SESSION['schoolExists']= 'yes';
		header("Location: schoolList.php");
		exit();
	}
	header("Location: schoolList.php");
	exit();
}
?>
