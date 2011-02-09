<?php

session_start();
include_once "config.php";
//check if the user is logged in, if not redirect to the log in page
if(!isset($_SESSION['email'])){
	header("Location: main_login.php");
	exit();
}

//SQL TABLE NAMES	//
$school = "SCHOOL";

//get all of the current schools in the database
$sql = "SELECT * FROM $school";
$result = mysql_query($sql);


//get all of the different school types
$qry = "SELECT * FROM SCHOOL_TYPE";
$sType = mysql_query($qry);

?>

<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
<title>GTOnline Administrator - Manage Schools</title>
</head>
<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#2F2F4F">
<h3 align="center">School List</h3>
	<?php 
		while($res = mysql_fetch_assoc($result)){
	?>
	<tr>
		<td><span style="color:white"><?php echo $res['Name']; ?></span></td>
		<td><span style="color:white"><?php echo $res['Type']; ?></span></td>
	</tr>
	<?php
		}
	?>
<tr>
<form name="school" method="post" action="schoolAction.php">
<td><input name="schoolName" type="text" id="schoolName"></td>
<td>
<?php

echo "<select name='schoolType'>";
while($temp = mysql_fetch_array($sType)){
	echo "<option value='$temp[Name]'>$temp[Name]</option>";
}
echo "</select>";
?>
</td>
</tr>
<tr>
<td>
<input type="submit" name="Submit" value="Submit"> 
</td>
</form>
<?php
	if($_SESSION['schoolExists'] == 'yes')
	{
		echo "<script>alert('School Name Already Exists!');</script>";
		$_SESSION['schoolExists'] = 'no';
	}
?>
</tr>
</table>
<p align="center"><a href="adminUser.php">Back to Menu</a></p>
</body>
</html>
