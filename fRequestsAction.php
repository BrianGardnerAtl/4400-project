<?php 
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}


//Session Email  //
$email = $_SESSION['email'];

//SQL TABLE NAMES //
$user = "USER";
$friendship = "FRIENDSHIP";
$reg_user = "REGULAR_USER";

$q=$_GET["q"];

$sql_requests = "SELECT u.Last_Name, u.Email, u.First_Name, ru.Hometown, f.Relationship
FROM $user u JOIN $friendship f ON u.Email=f.User_Email JOIN $reg_user ru ON ru.Email=f.User_Email
WHERE f.Friend_Email='$email' AND f.Date_Connected IS NULL
ORDER BY $q";
$requests = mysql_query($sql_requests);


echo "<table width=80%>
<tr>
	<th><a href='#' name='Last_Name' onClick='reformatFriends(this.name)'>name</a></th>
	<th><a href='#' name='Hometown' onClick='reformatFriends(this.name)'>Hometown</a></th>
	<th><a href='#' name='Relationship' onClick='reformatFriends(this.name)'>Relationship</a></th>
</tr>";


	$acc = "accept_";
	$rej = "reject_";
	$int = 0;
while($row = mysql_fetch_array($requests))
  {
  $formAcc = $acc . $int;
  $formRej = $rej . $int;
  echo "<tr>";
  	echo "<td>" . $row['First_Name'] . " " . $row['Last_Name'] . "</td>";
	echo "<td>" . $row['Hometown'] . "</td>";
	echo "<td>" . $row['Relationship'] . "</td>";
  	echo "<td>";
		echo "<form name='" . $formAcc . "' method='post' action='acceptRequest.php'>";
			echo "<input type='hidden' name='friendEmail' value='" . $row['Email'] . "' />";
			echo "<INPUT TYPE='submit' value='Accept'>";
		echo "</form>";
	echo "</td>";
  	echo "<td>";
		echo "<form name='" . $formRej . "' method='post' action='rejectRequest.php'>";
			echo "<input type='hidden' name='friendEmail' value='" . $row['Email'] . "' />";
			echo "<INPUT TYPE='submit' value='Reject'>";
		echo "</form>";
	echo "</td>";
  echo "</tr>";
  $int = $int + 1; 
  }
echo "</table>";



?>
