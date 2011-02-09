<?php
//check if session is registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

//session user email //
$email = $_SESSION['email'];

//get the admin users name to display
$sql_adminInfo = "SELECT First_Name, Last_Name FROM USER WHERE Email='$email'";
$adminInfo = mysql_query($sql_adminInfo);
$aInfo = mysql_fetch_assoc($adminInfo);

//get the previous login date of this admin
$sql_prevLogin = "SELECT Last_Login FROM ADMIN WHERE Email='$email'";
$prevLogin = mysql_query($sql_prevLogin);
$prevLoginDate = mysql_fetch_assoc($prevLogin);

//update the most recent admin log in time
if($_SESSION['adminDate'] == 'yes') {
$sql = "UPDATE ADMIN SET Last_Login=NOW() where Email='$email'";
$result = mysql_query($sql);
$_SESSION['adminDate'] = 'no';
}
?>

<html>
<head>
<title>GTOnline Administrator - Menu</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
</head>
	<body>
		<h3 align="center">GTOnline Administrator Menu -- <?php echo $aInfo['First_Name']; echo " "; echo $aInfo['Last_Name']; ?></h3>
		<table width="600" align="center" border="0" cellspacing="1" cellpadding="0" bgcolor="#2F2F4F">
		<tr><td id="main"><a href="schoolList.php">Manage List of Schools</a></td></tr>
		<tr><td id="main"><a href="employerList.php">Manage List of Employers</a></td></tr>
		<tr><td id="main"><a href="ageReport.php">Run Report-Number of Users by Age Range</a></td></tr>
		<tr><td id="main"><a href="friendReport.php">Run Report-Average Number of Friends by Hometown</a></td></tr>
		</table>
		<p align="center">Last login: <?php echo date(" F jS\, Y \a\\t h:i:s A", strtotime($prevLoginDate['Last_Login'])); ?></p>
		<p align="center"><a href="logout.php">Logout</a></p>
	</body>
</html>
