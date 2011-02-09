<?php
//check if user session is registered, redirect back to login page
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

//Session email
$email = $_SESSION['email'];

//SQL table names
$regularUser = "REGULAR_USER";



//get all of the regular users
$sql = "SELECT COUNT(Email) AS TOTAL FROM REGULAR_USER";
$result = mysql_query($sql);
$totalUsers = mysql_fetch_assoc($result);

//under18 users
$sqlUnder18 = "SELECT COUNT(Email)AS NUM FROM REGULAR_USER WHERE DATEDIFF(NOW(), Birth_Date) < 6570";
$resultUnder18 = mysql_query($sqlUnder18);
$under18 = mysql_fetch_assoc($resultUnder18);

//18 to 24 users
$sql18to24 = "SELECT COUNT(Email)AS NUM FROM REGULAR_USER WHERE DATEDIFF(NOW(), Birth_Date) >= 6570 AND DATEDIFF(NOW(), Birth_Date) <=9124";
$result18to24 = mysql_query($sql18to24);
$from18to24 = mysql_fetch_assoc($result18to24);

//25 to 34 users
$sql25to34 = "SELECT COUNT(Email)AS NUM FROM REGULAR_USER WHERE DATEDIFF(NOW(), Birth_Date) >= 9125 AND DATEDIFF(NOW(), Birth_Date) <=12774";
$result25to34 = mysql_query($sql25to34);
$from25to34 = mysql_fetch_assoc($result25to34);

//35 to 55 users
$sql35to55 = "SELECT COUNT(Email)AS NUM FROM REGULAR_USER WHERE DATEDIFF(NOW(), Birth_Date) >= 12775 AND DATEDIFF(NOW(), Birth_Date) <=20439";
$result35to55 = mysql_query($sql35to55);
$from35to55 = mysql_fetch_assoc($result35to55);

//over 55 users
$sqlOver55 = "SELECT COUNT(Email)AS NUM FROM REGULAR_USER WHERE DATEDIFF(NOW(), Birth_Date) >= 20440";
$resultOver55 = mysql_query($sqlOver55);
$over55 = mysql_fetch_assoc($resultOver55);
	
?>

<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
<title>GTOnline Administrator - User Age Report</title>
</head>
<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#2F2F4F">
<h3 align="center">Report: Number of Users by Age Range</h3>
<tr>
<td width="300"><span style="color:white"><b>Age Range</b></span></td>
<td align="center"><span style="color:white"><b>Number of Users</b></span></td>
</tr>
<tr>
<td><span style="color:white">Under 18</span></td>
<td align="center"><span style="color:white"><?php echo $under18['NUM']; ?></span></td>
</tr>
<tr>
<td><span style="color:white">18-24</span></td>
<td align="center"><span style="color:white"><?php echo $from18to24['NUM']; ?></span></td>
</tr>
<tr>
<td><span style="color:white">25-34</span></td>
<td align="center"><span style="color:white"><?php echo $from25to34['NUM']; ?></span></td>
</tr>
<tr>
<td><span style="color:white">35-55</span></td>
<td align="center"><span style="color:white"><?php echo $from35to55['NUM']; ?></span></td>
</tr>
<tr>
<td><span style="color:white">Over 55</span></td>
<td align="center"><span style="color:white"><?php echo $over55['NUM']; ?></span></td>
</tr>
<tr>
<td colspan=2><hr></td>
</tr>
<tr>
<td><span style="color:white">Total Users</span></td>
<td align="center"><span style="color:white"><?php echo $totalUsers['TOTAL']; ?></span></td>
</table>
<p align="center"><a href="adminUser.php">Back to Menu</a></p>
</body>
</html>
