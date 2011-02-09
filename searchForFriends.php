<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

//Session Email  //
$email = $_SESSION['email'];

?>

<html>
<head>
	<script type="text/javascript">
		//functions

		function showDiv(divName) {  
			thisDiv = document.getElementById(divName);
			if (thisDiv)   {    
				if (thisDiv.style.display == "none") {      
					thisDiv.style.display = "block";    
				}  
			}  else {    
				alert("Error: Could not locate div with id: " + divName);  
			}
		}

		function hideDiv(divName) {  
			thisDiv = document.getElementById(divName);  
			if (thisDiv)   {    
				if (thisDiv.style.display == "block") {      
					thisDiv.style.display = "none";    
				}  
			}  else {    
				alert("Error: Could not locate div with id: " + divName);  
			}
		}


	</script>
<title> Search For Friends</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
</head>
<body>

<h3> Search For Friends </h3>
<br>
<table>
<form name="friendSearch" method="post" action="searchForFriendsAction.php">
	<tr>
		<td style="padding-left:30px";><b>Name</b></td>
		<td><input type="text" size="45" name="searchName" id="searchName"></td>
	</tr>
	<tr>
		<td style="padding-left:30px";><b>Email</b></td>
		<td><input type="text" size="45" name="searchEmail" id="searchEmail"></td>
	</tr>
	<tr>
		<td style="padding-left:30px";><b>Hometown</b></td>
		<td><input type="text" size="45" name="searchHometown" id="searchHometown"></td>
		<td><input type="submit" name="Search" value="Search"></td>
	</tr>
</form>
</table>

<hr style="width:600px">

<div id="searchResults">

<?php 
	if($_GET['sortBy'] == 'hometown')
	{
		$_SESSION['hasSearched']=true;
		$tempResults = $_SESSION['searchResults'];
		$tempResults = $tempResults . "))ORDER BY ru.Hometown";
	}
	else
	{
		if($_GET['sortBy'] == 'name')
			$_SESSION['hasSearched']=true;
		$tempResults = $_SESSION['searchResults'];
		$tempResults = $tempResults . "))ORDER BY u.First_Name, u.Last_Name";
	}
	if($_SESSION['hasSearched']==true) 
	{
?>
		<h3> Search Results </h3>
	<br>
	<table width=50%;>
	<?php
		//$search = mysql_query($_SESSION['searchResults']);
		$search = mysql_query($tempResults);
		if(mysql_num_rows($search) == 0)
	{?>
		<tr>
			<td style='padding-left:30px';>
				<b>NO USERS FOUND MATCHING SEARCH CRITERIA</b>
			</td>
		</tr>
	<?php } 
		else
		{ ?>
		<tr>
			<td style='padding-left:30px';>
				<a href="searchForFriends.php?sortBy=name"><b>Name</b></a>
			</td>
			<td>
				<a href="searchForFriends.php?sortBy=hometown"><b>Hometown</b></a>
			</td>
		</tr>
	<?php
			while($results = mysql_fetch_assoc($search))
	{?>
				<tr>
					<td style='padding-left:30px';>
						<a href='requestNewFriend.php?lname=<?php echo $results['Last_Name'];?>&fname=<?php echo $results['First_Name'];?>&friEmail=<?php echo $results['Email'];?>&home=<?php echo $results['Hometown'];?>'> <?php echo $results['First_Name'];  echo " "; echo $results['Last_Name']; ?> </a>
					</td>
					<td>
						<?php echo $results['Hometown']; ?>
					<td>
				</tr>
		<?php } ?>
		</table>  
	<?php }
		$_SESSION['hasSearched']=false;
	}?>
</div>

<p align="center"><a href="regularUser.php">Back To Profile</a></p>
</body>


</html>
