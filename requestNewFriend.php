<?php 
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

$relation = 0;
if(isset($_GET['error']) && $_GET['error']==1){
$relation = 1;
}
$relationError = "Please enter a relation before submitting a request";

//Session Email  //
$email = $_SESSION['email'];

//table
$user = "USER";

$sql_userName = "SELECT First_Name, Last_Name From $user WHERE Email='$email'";
$userName = mysql_query($sql_userName);
$name = mysql_fetch_assoc($userName);

$fName = $_GET["fname"];
$lName = $_GET["lname"];
$hometown = $_GET["home"];
$userEmail = $_GET["friEmail"];

?>

<html>
<head>
<title>Request new friend for <?php echo $name['First_Name']; echo " "; echo $name['Last_Name']; ?> </title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
</head>
<body>

<h3>Request new friend for <?php echo $name['First_Name']; echo " "; echo $name['Last_Name']; ?> </h3>

<form name="requestFriend" method="post" action="sendFriendRequestAction.php" >

	<div id="addNewFriend">
		<table>
			<tr>
				<td>
					<b>Name</b>
				</td>
				<td>
					<?php echo $fName; echo " "; echo $lName; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Hometown</b>
				</td>
				<td>
					<?php echo $hometown; ?>
				</td>
			</tr>
		<?php if($relation==1){ ?>
			<tr>
				<td></td>
				<td><span style="color:red"><?php echo $relationError; ?></span></td>
			</tr>
		<?php } ?>
			<tr>
				<td>
					<b>Relationship</b>
				</td>
				<td>
					<input name="userRelationship" type="text" size="25" value="" id="userRelationship";>
				</td>
			</tr>
		</table>
	</div>
	<input type="hidden" size="45" name="friEmail" id="friEmail" value="<?php echo $userEmail;?>">
	<input type="hidden" size="45" name="home" id="home" value="<?php echo $hometown;?>">
	<input type="hidden" size="45" name="fName" value="<?php echo $fName;?>">
	<input type="hidden" size="45" name="lName" value="<?php echo $lName;?>">

<p align="center">
	<input type="button" value="Cancel" onClick="parent.location ='searchForFriends.php'">
	<input type="submit" value="Save">
</p>
</form>
</body>
</html>
