<?php
//check if user session is registered, redirect back to login page
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
	header("Location: main_login.php");
}

$newUser = 0;
if(isset($_GET['edit']) && $_GET['edit']==1){
	$newUser = 1;
}

//Session email
$email = $_SESSION['email'];

//SQL table names
$user = "USER";
$regularUser = "REGULAR_USER";
$userJobs = "REGULAR_USER_JOB";
$regular_user_interests = "REGULAR_USER_INTEREST";
$regular_user_school = "REGULAR_USER_SCHOOL";
$school = "SCHOOL";
$employer = "EMPLOYER";

//Get all of the new information saved on the edit profile page
$userSex = mysql_real_escape_string($_POST['sexOfUser']);
$userBirthdate = mysql_real_escape_string($_POST['birthDate']);
$userCity = mysql_real_escape_string($_POST['currCity']);
$userHometown = mysql_real_escape_string($_POST['hometown']);
$newUserSchool = mysql_real_escape_string($_POST['newUserSchool']);
$newYear = mysql_real_escape_string($_POST['newSchoolYear']);
$newUserEmployer = mysql_real_escape_string($_POST['newEmployer']);
$newUserTitle = mysql_real_escape_string($_POST['newTitle']);
$newInterest = mysql_real_escape_string(trim($_POST['userInterest']));


//check if all the necessary fields were filled in
if(!isset($userBirthdate) || $userBirthdate=="")
{
	if($newUser==1){
		header("Location: editProfile.php?newUser=1&fail=1");
	}
	else{
		header("Location: editProfile.php?fail=1");
	}
}

//update all the old information if the user is not a new user, else insert all the new values for the user
if($newUser==0){
	//update regular user table
	$sql = "UPDATE $regularUser SET Sex='$userSex', Birth_Date='$userBirthdate', Current_City='$userCity', Hometown='$userHometown' WHERE Email='$email'";
	$result = mysql_query($sql);
}

//check if a new school needs to be added for the user
//need to check that the school is not already in the table for that user
if(isset($newUserSchool) && $newUserSchool!=""){
	$sql = "INSERT INTO $regular_user_school (`Email`, `School_Name`, `Year_Graduated`) VALUES ('$email', '$newUserSchool', '$newYear')";
	$result = mysql_query($sql);
}


//if the user is registering an account insert all of the information into the db
if($newUser==1){
	//fetch all of the information entered on the register user page
	$password = $_SESSION['regPassword'];
	$firstName = $_SESSION['regFirst'];
	$lastName = $_SESSION['regLast'];

	//sql for entering information into user table
	$sql = "INSERT INTO $user (`Email`, `First_Name`, `Last_Name`, `Password`) VALUES ('$email', '$firstName', '$lastName', '$password')";
	$result = mysql_query($sql);

	//sql for entering information into the regular users table
	$sql = "INSERT INTO $regularUser (`Email`, `Sex`, `Birth_Date`, `Current_City`, `Hometown`) VALUES ('$email', '$userSex', '$userBirthdate', '$userCity', '$userHometown')";
	$result = mysql_query($sql);
}


//get and check if any of the user's schools need to be updated
$sql = "DELETE FROM $regular_user_school WHERE Email='$email'";
$result = mysql_query($sql);

$count = 0;
$currName = "name" . $count;
$currYear = "year" . $count;
$date = "date" . $count;

$Add = True;
while($_POST[$currName] != ""){
	foreach($_POST['deleteE'] as $value) {
		if($count == (int)$value){
			$Add = False;
		}
	}
	if($Add){
		$oldSchool = mysql_real_escape_string($_POST[$currName]);
		$oldYear = mysql_real_escape_string($_POST[$currYear]);
		$sql = "INSERT INTO $regular_user_school (`Email`, `School_Name`, `Year_Graduated`) VALUES ('$email', '$oldSchool', '$oldYear')";
		$result = mysql_query($sql);
	}
	$count = $count + 1;
	$currName = "name" . $count;
	$currYear = "year" . $count;
	$Add = True;
}



//check if a new school needs to be added for the user
//need to check that the school is not already in the table for that user
if(isset($newUserSchool) && $newUserSchool!=""){
	$sql = "INSERT INTO $regular_user_school (`Email`, `School_Name`, `Year_Graduated`) VALUES ('$email', '$newUserSchool', '$newYear')";
	$result = mysql_query($sql);
}

//check if any of the user's jobs need to be updated
//get and check if any of the user's schools need to be updated
$sql = "DELETE FROM $userJobs WHERE Email='$email'";
$result = mysql_query($sql);


$cnt = 0;
$currName = "comp" . $cnt;
$currTitle = "title" . $cnt;
$Add = True;
while(isset($_POST[$currName]) && $_POST[$currName] != ""){
	foreach($_POST['deleteJ'] as $value) {
		if($cnt == (int)$value){
			$Add = False;
		}
	}
	if($Add){
		$name = $_POST[$currName];
		$title = $_POST[$currTitle];
		$name = mysql_real_escape_string($name);
		$title = mysql_real_escape_string($title);
		$sql = "INSERT INTO $userJobs (`Email`, `Employer_Name`, `Job_Title`) VALUES ('$email', '$name', '$title')";
		$result = mysql_query($sql);
	}
	$cnt = $cnt + 1;
	$currName = "comp" . $cnt;
	$currTitle = "title" . $cnt;
	$Add = True;
}

//add the new job if it is filled out.
if(isset($newUserEmployer) && $newUserEmployer != "" && $newUserTitle != ""){
	$sql = "INSERT INTO $userJobs (`Email`, `Employer_Name`, `Job_Title`) VALUES ('$email', '$newUserEmployer', '$newUserTitle')";
	$result = mysql_query($sql);
}

//check if the new interest field was set and is not an empty string 
if(isset($newInterest) && $newInterest!="" && $newInterest!="..."){
	//check if the interest is already in the database	
	$sql = "SELECT * FROM $regular_user_interests WHERE Email='$email' AND Interest='$newInterest'";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	if($count==0){
		//add the new interest into the insert table and redirect back to the edit user page
		$sql = "INSERT INTO $regular_user_interests (`Email`,`Interest`) VALUES ('$email','$newInterest')";
		$result = mysql_query($sql);
	}
}
  

header("Location: regularUser.php");  

?>
