<?php

session_start();
include_once "config.php";


$newEmployer=mysql_real_escape_string($_POST["newEmployer"]);

if($newEmployer == '')
{
	header("Location: employerList.php");
	exit();
}
else
{
	$qry = "INSERT INTO EMPLOYER VALUES('$newEmployer')";
	$eType = mysql_query($qry);
	if(!$eType)
	{
		$_SESSION['employerExists']= 'yes';
		header("Location: employerList.php");
		exit();
	}
	header("Location: employerList.php");
	exit();
}
?>
