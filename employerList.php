<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

//Session Email  //
$email = $_SESSION['email'];

//SQL TABLES //
$employer = "EMPLOYER";

//SQL QUERIES //
$sql_Employers = "SELECT Name FROM $employer";
$employers = mysql_query($sql_Employers);


?>


<html>

<head>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
<title>GTOnline Administrator - Manage Employers</title>
</head>
<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#2F2F4F">
<h3 align="center">Employer List</h3>
	
	<?php 
		while($row = mysql_fetch_assoc($employers)){
	?>
	<tr>
		<td><span style="color:white"><?php echo $row['Name']; ?></span></td>
	</tr>
	<?php
		}
	?>

<p></p>
<form name="employer" method="post" action="employerAction.php">
<td><input type="text" name="newEmployer"></td>
<td><input type="submit" name="submit" value="Add"></td>
</form>
<?php
	if($_SESSION['employerExists'] == 'yes')
	{
		echo "<script>alert('Employer Already Exists!');</script>";
		$_SESSION['employerExists'] = 'no';
	}
?>
</table>
<p align="center"><a href="adminUser.php">Back To Menu</a></p>

</body>



</html>
