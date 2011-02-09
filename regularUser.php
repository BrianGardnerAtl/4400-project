<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}


//Session Email  //
$email = $_SESSION['email'];

//SQL Tables	//
$regular_user_table = "REGULAR_USER";
$regular_user_interests = "REGULAR_USER_INTEREST";
$regular_user_school = "REGULAR_USER_SCHOOL";
$user = "USER";
$userJobs = "REGULAR_USER_JOB";

// checks for the profile we are currently viewing
$currentProfile = $_GET['currentProfile'];
$currentProfile = stripslashes($currentProfile);
$currentProfile = mysql_real_escape_string($currentProfile); 
$isRegUser = "SELECT Email FROM $regular_user_table WHERE Email = '$currentProfile'";
$regUser = mysql_query($isRegUser);
if(mysql_num_rows($regUser) == 1)
{
	$userName = mysql_fetch_assoc($regUser);
	$email = $userName['Email'];
}

//SQL QUERIES	//
$sql = "SELECT Sex, Birth_Date, Current_City, Hometown FROM $regular_user_table WHERE Email ='$email'";
$userInfo = mysql_query($sql);
$tuple = mysql_fetch_assoc($userInfo);

$sql_userName = "SELECT First_Name, Last_Name From $user WHERE Email='$email'";
$userName = mysql_query($sql_userName);
$name = mysql_fetch_assoc($userName);

$sql_Interests = "SELECT Interest FROM $regular_user_interests WHERE Email ='$email'";
$userInterests = mysql_query($sql_Interests);

$sql_Education = "SELECT School_Name, Year_Graduated FROM $regular_user_school WHERE Email ='$email'";
$userEducation = mysql_query($sql_Education);

$sql_Professional = "SELECT Employer_Name, Job_Title FROM $userJobs WHERE Email ='$email'";
$userProfessional = mysql_query($sql_Professional);

?>

<html>
<head>
<title>View GTOnline Profile for <?php echo $name['First_Name']; echo " "; echo $name['Last_Name']; ?> </title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
</head>
<body>
	<h3><?php echo $name['First_Name']; echo " "; echo $name['Last_Name']; ?>'s Profile</h3>
		<table>
			<tr>
				<td><b>Sex</b></td>
				<td><?php if($tuple['Sex'] == m) { 
						echo 'Male';
					   }else{
						echo 'Female'; 
					   }
				    ?>
				</td>
			</tr>
			<tr>
				<td><b>Birthdate</b></td>
				<td><?php echo date(" F jS\, Y", strtotime($tuple['Birth_Date'])); 	?></td>
			</tr>
			<tr>
				<td><b>Current City</b></td>
				<td><?php echo $tuple['Current_City']; 	?></td>
			</tr>
			<tr>
				<td><b>Hometown</b></td>
				<td> <?php echo $tuple['Hometown']; 	?></td>
			</tr>
			<tr>
				<td><b>Interests</b></td>
			<?php 
				while($row = mysql_fetch_assoc($userInterests)){
			?>
			
				<td><?php echo $row['Interest']; ?></td>
			</tr>
			<tr>
				<td></td>
			<?php
				}
			?>
			</tr>
		</table>
	<hr style="width:600px">
		<h3>Education</h3>
		<table>
			<?php
				while($row = mysql_fetch_assoc($userEducation)){
			?>
					<tr>
						<td>School: <?php echo $row['School_Name']; ?></td>
					</tr>
					<?php if($row['Year_Graduated'] != date('0000-00-00') ){
					?>
						<tr>
							<td>Year Graduated: <?php echo date("Y", strtotime($row['Year_Graduated'])); ?> <td>
							<br>
						</tr>
						<tr></tr><tr></tr>
				<?php	} 	else{ ?>
						<tr>
							<td>Currently Attending</td>
						<tr>
						<tr></tr><tr></tr>
				<?php		}
				}
			?>
		</table>
	<hr style="width:600px">
		<h3>Professional</h3>
		<table width=300px>
		<?php
			while($row = mysql_fetch_assoc($userProfessional)){
		?>
			<tr>
				<td><b>Employer</b></td>
				<td><?php echo $row['Employer_Name']; ?></td>
			</tr>
			<tr>
				<td><b>Job Title</b></td>
				<td><?php echo $row['Job_Title']; ?></td>
			</tr>
			<tr></tr>
			<tr></tr>
		<?php
			}
		?>
		</table>
	<div id="sidebar">
	<div id="content">
		<p align="center"><a href="statusUpdates.php<?php echo '?currentProfile='; echo $email;?>&more=0">View Status Updates</a></p>
		<p align="center"><a href="currentFriends.php<?php echo '?currentProfile='; echo $email;?>">View Friends</a></p>
		<?php if ( $email == $_SESSION['email']){
		?>
			<p align="center"><a href="pendingFriends.php">View Pending Requests</a></p>
			<p align="center"><a href="editProfile.php">Edit Profile</a></p>
			<p align="center"><a href="searchForFriends.php">Search For Friends</a></p>
		<?php } ?>
		<p align="center"><a href="logout.php">Logout</a></p>
	</div>
	</div>
<?php if($email != $_SESSION['email']) { ?>
	<p align="center"><a href="regularUser.php">Back To Home</a></p>
<?php } ?>

<?php if($email==$_SESSION['email']) { ?>
	</br>
	</br>
	</br>
<?php } ?>
	
	</body>
</html>
