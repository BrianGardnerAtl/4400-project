<?php
//check if session is not registered, redirect back to main page.
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

$sql_requests = "SELECT u.Last_Name, u.Email, u.First_Name, ru.Hometown, f.Relationship
FROM $user u JOIN $friendship f ON u.Email=f.User_Email JOIN $reg_user ru ON ru.Email=f.User_Email
WHERE f.Friend_Email='$email' AND f.Date_Connected IS NULL
ORDER BY Last_Name";
$requests = mysql_query($sql_requests);


//SQL QUERY for the user's requests to other people // 
$sql_myRequests = "SELECT u.Last_Name, u.First_Name, u.Email, ru.Hometown, f.Relationship
FROM $user u JOIN $friendship f ON u.Email=f.Friend_Email JOIN $reg_user ru ON ru.Email=f.Friend_Email
WHERE f.User_Email='$email' AND f.Date_Connected IS NULL
ORDER BY Last_Name";
$myRequests = mysql_query($sql_myRequests);

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
				document.getElementById("tableOutput").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","fRequestsAction.php?q="+str,true);
		xmlhttp.send();
	}

	function reformatMyFriendRequests(str)
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
				document.getElementById("tableOutput2").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","myfRequestsAction.php?p="+str,true);
		xmlhttp.send();
	}

</script>

<title>Pending Friend Requests for </title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
</head>
<body>
<h3>The following people have requested to be friends with you:</h3>
<div id="tableOutput">

	<table border='0'; width=80%>
		<tr>
			<th><a href='#' name='Last_Name' onClick='reformatFriends(this.name)'>name</a></th>
			<th><a href='#' name='Hometown' onClick='reformatFriends(this.name)'>Hometown</a></th>
			<th><a href='#' name='Relationship' onClick='reformatFriends(this.name)'>Relationship</a></th>
			
		</tr>
		<?php      $acc = "accept_";
			    $rej = "reject_";
			    $int = 0;
			    while($row = mysql_fetch_array($requests))
  			    {	
				$formAcc = $acc . $int;
				$formRej = $rej . $int;
				?> 
  				<tr>
  					<td id="main"> 
						<?php echo $row['First_Name']; echo " "; echo $row['Last_Name']; ?>
					</td>
  					<td id="main"> 
						<?php echo $row['Hometown']; ?>
					</td>
  					<td id="main">
						<?php echo $row['Relationship']; ?>
					</td>
					<td>
						<form name="<?php echo $formAcc;?>" method="post" action="acceptRequest.php">
							<input type="hidden" name="friendEmail" value="<?php echo $row['Email'];?>" />
							<INPUT TYPE='submit' value='Accept'>
						</form>
					</td>
					<td>
						<form name="<?php echo $formRej;?>" method="post" action="rejectRequest.php">
							<input type="hidden" name="friendEmail" value="<?php echo $row['Email'];?>" />
							<INPUT TYPE='submit' value='Reject'>
						</form>
					</td>
				</tr>
  			    <?php $int = $int + 1;
				   } ?>
	</table>
</div>

<h3>You have requested to be friends with these people:</h3>
<div id="tableOutput2">

	<table border='0'; width=80%>
		<tr>
			<th><a href='#' name='Last_Name' onClick='reformatMyFriendRequests(this.name)'>name</a></th>
			<th><a href='#' name='Hometown' onClick='reformatMyFriendRequests(this.name)'>Hometown</a></th>
			<th><a href='#' name='Relationship' onClick='reformatMyFriendRequests(this.name)'>Relationship</a></th>
		</tr>

		<?php 	$var = "form_";
			$int = 0;
			while($row = mysql_fetch_array($myRequests))
  			    { 
				$tempName = $var . $int;	
			?>
  				<tr>
  					<td id="main">
						<?php echo $row['First_Name']; echo " "; echo $row['Last_Name']; ?>
					</td>
					<td id="main">
						<?php echo $row['Hometown']; ?>
					</td>
					<td id="main">
						<?php echo $row['Relationship'];	?>
					</td>
					<td>
						<form name="<?php echo $tempName;?>" method="post" action="cancelMyRequest.php">
							<input type="hidden" name="friendEmail" value="<?php echo $row['Email'];?>" />
							<INPUT TYPE='submit' value='Cancel'>
						</form>
					</td>
				</tr>
		   <?php	$int = $int + 1;   
			}	?>
	</table>
</div>

<p align="center"><a href="regularUser.php<?php echo '?currentProfile='; echo $email;?>">Back To Profile</a></p>

</body>

</html>
