<html>
<head>
<title>New User Registration</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
</head>
<body>
<?php

session_start();
include_once "config.php";
?>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="registration" method="post" action="registerUser.php">
<td id="main">
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td id="main" colspan="2"><strong>New User Registration</strong></td>
</tr>
<tr>
<?php if(isset($_GET['error']) && $_GET['error']==3){
?>
<td id="main"colspan="2"><span style="color:red"><?php echo $_SESSION['regError']; ?></span></td>
<?php
}
?>
</tr>
<tr>
<td width="50%" style="text-align:right">First Name :</td>
<td><input name="firstName" type="text" id="firstName"></td>
</tr>
<tr>
<td width="50%" style="text-align: right">Last Name :</td>
<td><input name="lastName" type="text" id="lastName"></td>
</tr>
<tr>
<?php if(isset($_GET['error']) && $_GET['error']==2){
?>
<td colspan="2" id="main"><span style="color:red"><?php echo $_SESSION['regError']; ?></span></td>
<?php
}
?>
</tr>
<tr>
<td width="50%" style="text-align: right">Email :</td>
<td><input name="myemail" type="text" id="myemail"></td>
</tr>
<tr>
<?php if(isset($_GET['error']) && $_GET['error']==1){
?>
<td colspan="2" id="main"><span style="color:red"><?php echo $_SESSION['regError']; ?></span></td>
<?php
}
?>
</tr>
<tr>
<td width="50%" style="text-align: right">Password :</td>
<td><input name="mypassword" type="password" id="mypassword"></td>
</tr>
<tr>
<td width="50%" style="text-align:right">Confirm Password :</td>
<td><input name="mypassword2" type="password" id="mypassword2"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Register"><input type="button" onCLick="location.href='main_login.php'" value="Cancel"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
</body>
</html>

