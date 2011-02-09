<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

//Session Email  //
$email = $_SESSION['email'];

$searchName=mysql_real_escape_string($_POST["searchName"]);
$searchEmail=mysql_real_escape_string($_POST["searchEmail"]);
$searchHometown=mysql_real_escape_string($_POST["searchHometown"]);

if($searchName == '' && $searchEmail == '' && $searchHometown == '')
{
	header("Location: searchForFriends.php");
	exit();
}
else
{
	$qry = "SELECT DISTINCT u.Email, u.Last_Name, u.First_Name, ru.Hometown
		FROM FRIENDSHIP f, USER u
		JOIN REGULAR_USER ru ON ru.Email = u.Email
		WHERE (f.User_Email != '$email' AND u.Email != '$email' AND u.Email NOT IN 
			(SELECT Friend_Email FROM FRIENDSHIP WHERE User_Email ='$email') 
			AND (";
		if($searchName != '')
		{
			$qry = $qry . "u.First_Name LIKE '%$searchName%' OR u.Last_Name LIKE '%$searchName%' ";
		}
		if($searchEmail != '')
		{
			if($searchName != '')
			{
				$qry = $qry . "OR ";
			}
			$qry = $qry . "u.Email LIKE '%$searchEmail%' ";
		}
		if($searchHometown != '')
		{
			if(($searchName != '') || ($searchEmail != ''))
			{
				$qry = $qry . "OR ";
			}
			$qry = $qry . "ru.Hometown LIKE '%$searchHometown%'";
		}
		//$qry = $qry . "))ORDER BY u.First_Name";

	$_SESSION['searchResults']=$qry;
	$_SESSION['hasSearched']=true;

	header("Location: searchForFriends.php");
	exit();
}
?>
