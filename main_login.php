<?php
$message = "";
if(isset($_GET['login'])){
	if($_GET['login']==1){
		$message="Invalid Email/Password";
	}
}
?>

<html>
<head>
<title>GTOnline Login -- Welcome!</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
<link rel="shortcut icon" href="favicon2.ico"/>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
	<tr>
		<form name="form1" method="post" action="checklogin.php">
			<td>
				<table border="0" cellpadding="3" cellspacing="1" bgcolor="#2F2F4F">
					<tr>
						<td id="main"colspan="2"; align="center">
							<img src="GeorgiaTechLogo.jpg" width=100px;/>
						</td>
					</tr>
					<tr>
						<td id="main" colspan="2"><strong>GTOnline Login</strong></td>
					</tr>
					<tr>
						<td id="main" colspan="2"><span style="color:red"><?php echo $message; ?></span></td>
					</tr>
					<tr>
						<td style="text-align: right">Email : </td>
						<td><input name="myemail" type="text" id="myemail"></td>
					</tr>
					<tr>
						<td style="text-align: right">Password : </td>
						<td><input name="mypassword" type="password" id="mypassword"></td>
					</tr>
					<tr>	
						<td></td>
						<td colspan="2">
							<input type="submit" name="Submit" value="Login">
							<input type="button" onClick="location.href='registration.php'" value="Register">
						</td>
					</tr>
				</table>
			</td>
		</form>
	</tr>
</table>
</body>
</html>
