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

// checks for how to sort friends
$sortBy = $_GET['sortBy'];
$sortBy = stripslashes($sortBy);
$sortBy = mysql_real_escape_string($sortBy); 

//SQL QUERIES  //
$sql_userName = "SELECT First_Name, Last_Name From $user WHERE Email='$email'";
$userName = mysql_query($sql_userName);
$name = mysql_fetch_assoc($userName);


// sql to get all of the friends
$sql_Friends = "SELECT U.First_Name, U.Last_Name, F.Relationship, F.Date_Connected, U.Email
		  FROM USER U, FRIENDSHIP F WHERE F.User_Email='$email' AND F.Friend_Email=U.Email
		  AND F.Date_Connected IS NOT NULL ";
if($sortBy == 'rel')
{
	$sql_Friends = $sql_Friends . "ORDER BY F.Relationship";
}
else if($sortBy == 'date')
{
	$sql_Friends = $sql_Friends . "ORDER BY F.Date_Connected";
}
else if($sortBy == 'name')
{
	$sql_Friends = $sql_Friends . "ORDER BY U.First_Name, U.Last_Name";
}
$friends = mysql_query($sql_Friends);

?>


<html>
	<head>
	<title>GTOnline Friends List</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
	</head>
	<body>
	<h3>Friends of <?php echo $name['First_Name']; echo " "; echo $name['Last_Name']; ?></h3>
	<div id="myFriends";>
		<table width=80%;>
			<tr>
				<td><b><a href='currentFriends.php?sortBy=name&amp;currentProfile=<?php echo $email?>' name='Last_Name'>Name</a></b></td>
				<td><b><a href='currentFriends.php?sortBy=rel&amp;currentProfile=<?php echo $email?>' name='Relationship'>Relationship</a></b></td>
				<td><b><a href='currentFriends.php?sortBy=date&amp;currentProfile=<?php echo $email?>' name='Date_Connected'>Connected Since</a></b></td>
			</tr>
		<?php	
			while($row = mysql_fetch_assoc($friends)){
		?>
			<tr>
				<td><a href="regularUser.php?currentProfile=<?php echo $row['Email']?>"><?php echo $row['First_Name']; echo " "; echo $row['Last_Name'];?></a></td>
				<td><?php echo $row['Relationship'];?></td>
				<td><?php echo date(" F jS\, Y", strtotime($row['Date_Connected']));?></td>
			</tr>
		<?php 
			}
		?>
		</table>
	</div>
	</br>
	<p align="center"><a href="regularUser.php<?php echo '?currentProfile='; echo $email;?>">Back To Profile</a></p>
	<?php if($email != $_SESSION['email']) { ?> 
	<p align="center"><a href="regularUser.php">Back to Home</a></p>
	<?php } ?>
	</body>

</html>
