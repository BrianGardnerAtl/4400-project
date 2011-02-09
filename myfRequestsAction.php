<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}


//Session Email  //
$email = $_SESSION['email'];

$q=$_GET["p"];

//SQL TABLE NAMES //
$user = "USER";
$friendship = "FRIENDSHIP";
$reg_user = "REGULAR_USER";

//SQL QUERY for the user's requests to other people // 
$sql_myRequests = "SELECT u.Last_Name, u.First_Name, u.Email, ru.Hometown, f.Relationship
FROM $user u JOIN $friendship f ON u.Email=f.Friend_Email JOIN $reg_user ru ON ru.Email=f.Friend_Email
WHERE f.User_Email='$email' AND f.Date_Connected IS NULL
ORDER BY $q";
$myRequests = mysql_query($sql_myRequests);





echo "<table width=80%>
<tr>
	<th><a href='#' name='Last_Name' onClick='reformatMyFriendRequests(this.name)'>name</a></th>
	<th><a href='#' name='Hometown' onClick='reformatMyFriendRequests(this.name)'>Hometown</a></th>
	<th><a href='#' name='Relationship' onClick='reformatMyFriendRequests(this.name)'>Relationship</a></th>
</tr>";

$var = "form_";
$int = 0;
while($row = mysql_fetch_array($myRequests))
  {
	$tempName = $var . $int;
  echo "<tr>";
	  echo "<td>" . $row['First_Name'] . " " . $row['Last_Name'] . "</td>";
	  echo "<td>" . $row['Hometown'] . "</td>";
	  echo "<td>" . $row['Relationship'] . "</td>";
	  echo "<td>";
		echo "<form name='" . $tempName . "' method='post' action='cancelMyRequest.php'>";
			echo "<input type='hidden' name='friendEmail' value='" . $row['Email'] . "' />";
			echo "<INPUT TYPE='submit' value='Cancel'>";
		echo "</form>";	
	  echo "</td>";
	  
  echo "</tr>";
  $int = $int + 1;
  }
echo "</table>";

?>