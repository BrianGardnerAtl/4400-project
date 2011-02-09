<?php
//check if user session is registered, redirect back to login page
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

//Session email
$email = $_SESSION['email'];


//Gets the average users per hometown over the network
$sql = "SELECT AVG(Num_Of_Friends) AS AVG
FROM(
    SELECT ru.Email, ru.Hometown, COUNT(*) AS Num_Of_Friends
    FROM  REGULAR_USER ru, FRIENDSHIP fr
    Where ru.Email = fr.User_Email AND fr.Date_Connected IS NOT NULL
    GROUP BY ru.Email
    )
AS t1";
$result = mysql_query($sql);
$totalUsers = mysql_fetch_assoc($result);

//Gets the average number of users per hometown
$qry = "SELECT Hometown, AVG(Num_Of_Friends) AS 'Avg_Num_Of_Friends', COUNT( Num_Of_Friends) AS 'Users per town'
FROM(
    SELECT ru.Email, ru.Hometown, COUNT(*) AS 'Num_Of_Friends'
    FROM  REGULAR_USER ru, FRIENDSHIP fr
    Where ru.Email = fr.User_Email AND fr.Date_Connected IS NOT NULL
    GROUP BY ru.Email
    )
AS t1 GROUP BY Hometown";
$qryResult = mysql_query($qry);

?>

<html>
<head>
<title>GTOnline Administrator - Hometown Average Report</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
</head>
<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#2F2F4F">
<h3 align="center">Report: Average Number of Friends by Hometown</h3>
<tr>
<td width="300"><span style="color:white"><b>Hometown</b></span></td>
<td align="center"><span style="color:white"><b>Average Number of Friends</b></span></td>
</tr>
	<?php	
		while($usersPerHometown = mysql_fetch_assoc($qryResult)){
	?>
		<tr>
			<td><span style="color:white"><?php echo $usersPerHometown['Hometown'];?></span></td>
			<td align="center"><span style="color:white"><?php echo round($usersPerHometown['Avg_Num_Of_Friends']);?></span></td>
		</tr>
	<?php 
		}
	?><tr>
<td colspan=2><hr></td>
</tr>
<tr>
<td><span style="color:white">Average For Entire Network</span></td>
<td align="center"><span style="color:white"><?php echo round($totalUsers['AVG']); ?></span></td>
</table>
<p align="center"><a href="adminUser.php">Back to Menu</a></p>
</body>
</html>
