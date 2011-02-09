<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

//Session Email  //
$email = $_SESSION['email'];

//SQL TABLES	//
$user = "USER";

$q=$_GET["q"];

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

// sql to get all of the friends
$sql_Friends = "SELECT U.First_Name, U.Last_Name, F.Relationship, F.Date_Connected, U.Email
		  FROM USER U, FRIENDSHIP F WHERE F.User_Email='$email' AND F.Friend_Email=U.Email
		  AND F.Date_Connected IS NOT NULL ORDER BY $q";
$friends = mysql_query($sql_Friends);


echo "<table border='1'; width=80%>
	<tr>
		<td><b><a href='#' name='Last_Name' onClick='reformatFriends(this.name)'>Name</a></b></td>
		<td><b><a href='#' name='Relationship' onClick='reformatFriends(this.name)'>Relationship</a></b></td>
		<td><b><a href='#' name='Date_Connected' onClick='reformatFriends(this.name)'>Connected Since</a></b></td>
	</tr>";
	while($row = mysql_fetch_array($friends)){
		echo "<tr>";
			echo "<td>" . "<a href=regularUser.php?currentProfile=" . $row['Email'] . ">" . $row['First_Name'] . " " . $row['Last_Name'] . "</a></td>";
			echo "<td>" . $row['Relationship'] . "</td>";
			echo "<td>" . $row['Date_Connected'] . "</td>";
		echo "</tr>";
	}
echo "</table>";


?>