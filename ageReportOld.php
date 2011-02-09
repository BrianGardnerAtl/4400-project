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

$SECONDS_PER_YEAR = 60*60*24*365;

//today's date
$today = date('Y-m-d');

function calculateAge($birthdate)
{
	$dateDiff = date('Y-m-d') - $birthdate;
	//$years = floor($dateDiff/($SECONDS_PER_YEAR));
	return $dateDiff;
}



//get all of the regular users
$sql = "SELECT * FROM $regularUser";
$result = mysql_query($sql);
$totalUsers = mysql_num_rows($result);

$under18 = 0;
$from18to24 = 0;
$from25to34 = 0;
$from35to55 = 0;
$over55 = 0;

	while($row = mysql_fetch_assoc($result))
	{
		$userAge = calculateAge($row['Birth_Date']);

		if($userAge<18)
		{
			$under18 +=1;
		}
		else if($userAge>=18 && $userAge<25)
		{
			$from18to24 +=1; 
		}	
		else if($userAge>=25 && $userAge<35)
		{
			$from25to34 += 1;
		}
		else if($userAge>=35 && $user<=55)
		{
			$from35to55 += 1;
		}
		else
		{
			$over55 += 1;
		}
	}
	
?>

<html>
<head>
<title>User Age Report</title>
</head>
<body>
<h3 align="center">Number of Users by Age Range</h3>
<br/>
<a href="adminUser.php">Back to Menu</a>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td width="300"><b>Age Range</b></td>
<td><b>Number of Users</b></td>
</tr>
<tr>
<td>Under 18</td>
<td><?php echo $under18; ?></td>
</tr>
<tr>
<td>18-24</td>
<td><?php echo $from18to24; ?></td>
</tr>
<tr>
<td>25-34</td>
<td><?php echo $from25to34; ?></td>
</tr>
<tr>
<td>35-55</td>
<td><?php echo $from35to55; ?></td>
</tr>
<tr>
<td>Over 55</td>
<td><?php echo $over55; ?></td>
</tr>
<tr>
<td colspan=2><hr></td>
</tr>
<tr>
<td>Total Users</td>
<td><?php echo $totalUsers; ?></td>
</table>

</body>
</html>
