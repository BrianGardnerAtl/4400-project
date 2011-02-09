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

//SQL QUERIES  //
$sql_userName = "SELECT First_Name, Last_Name From $user WHERE Email='$email'";
$userName = mysql_query($sql_userName);
$name = mysql_fetch_assoc($userName);


// sql to get all of the friends
$sql_Friends = "SELECT U.First_Name, U.Last_Name, F.Relationship, F.Date_Connected, U.Email
		  FROM USER U, FRIENDSHIP F WHERE F.User_Email='$email' AND F.Friend_Email=U.Email
		  AND F.Date_Connected IS NOT NULL ORDER BY U.Last_Name, U.First_Name";
$friends = mysql_query($sql_Friends);

?>


<html>
	<head>
		<script type="text/javascript">
			function reformatFriends(str)
			{
				if (window.XMLHttpRequest)
		  		{// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else
				{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function()
				{
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						document.getElementById("myFriends").innerHTML=xmlhttp.responseText;
					}
				}
				//var myVar = "test@";
				//var myVar2 = encodeURIComponent(myVar);
				//window.alert(<?php echo str_replace('@','%40',myVar);?>);
				xmlhttp.open("GET","formatMyFriendsAction.php?q="+str+"?currentProfile=" + "" ,true);
				xmlhttp.send();
			}
		</script>
	</head>
	<title>GTOnline Friends List</title>
	<body>
	<a href="regularUser.php">Home</a>
	<h2>Friends of <?php echo $name['First_Name']; echo " "; echo $name['Last_Name']; ?></h2>
	<div id="myFriends";>
		<table width=80%;>
			<tr>
				<td><b><a href='#' name='Last_Name' onClick='reformatFriends(this.name)'>Name</a></b></td>
				<td><b><a href='#' name='Relationship' onClick='reformatFriends(this.name)'>Relationship</a></b></td>
				<td><b><a href='#' name='Date_Connected' onClick='reformatFriends(this.name)'>Connected Since</a></b></td>
			</tr>
		<?php	
			while($row = mysql_fetch_assoc($friends)){
		?>
			<tr>
				<td><a href="regularUser.php?currentProfile=<?php echo $row['Email']?>"><?php echo $row['First_Name']; echo " "; echo $row['Last_Name'];?></a></td>
				<td><?php echo $row['Relationship'];?></td>
				<td><?php echo $row['Date_Connected'];?></td>
			</tr>
		<?php 
			}
		?>
		</table>
	</div>
	<br>
	<a href="regularUser.php<?php echo '?currentProfile='; echo $email;?>">Back To Profile</a>
	</body>

</html>