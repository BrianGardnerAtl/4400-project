<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
	header("Location: main_login.php");
}

//check if the user is coming from the registration page
$newUser = 0;
if(isset($_GET['newUser']) && $_GET['newUser']==1){
	$newUser = 1;
}

$bDayFail = 0;
if(isset($_GET['fail']) && $_GET['fail']==1){
	$bDayFail = 1;
}


//Session Email  //
$email = $_SESSION['email'];

//SQL TABLE NAMES //
$user = "USER";
$regularUser = "REGULAR_USER";
$userJobs = "REGULAR_USER_JOB";
$regular_user_interests = "REGULAR_USER_INTEREST";
$regular_user_school = "REGULAR_USER_SCHOOL";
$school = "SCHOOL";
$employer = "EMPLOYER";

//if user is coming from registration page there will be no information 
//about them in the database
if(!$newUser){
	//SQL QUERIES //
	$sql_userName = "SELECT First_Name, Last_Name From $user WHERE Email='$email'";
	$userName = mysql_query($sql_userName);
	$name = mysql_fetch_assoc($userName);

	$sql_regularUser = "SELECT Sex, Birth_Date, Current_City, Hometown FROM $regularUser WHERE Email='$email'";
	$userInfo = mysql_query($sql_regularUser);
	$info = mysql_fetch_assoc($userInfo);


	$sql_Interests = "SELECT Interest FROM $regular_user_interests WHERE Email ='$email'";
	$userInterests = mysql_query($sql_Interests);


	$sql_Education = "SELECT School_Name, Year_Graduated, Type FROM $regular_user_school JOIN $school ON School_Name=Name WHERE Email ='$email'";
	$userEducation = mysql_query($sql_Education);

	//The users professional Experience
	$sql_Professional = "SELECT Employer_Name, Job_Title FROM $userJobs WHERE Email ='$email'";
	$userProfessional = mysql_query($sql_Professional);
}

//all the schools the surrent user is not in
$sql_otherSchools = "SELECT * FROM $school"; 
$otherSchools = mysql_query($sql_otherSchools);

//list of all employers
$sql_employers = "Select Name From $employer";
$employers = mysql_query($sql_employers);

//check if the name has been set
if(!isset($name['First_Name'])){
	$name['First_Name'] = $_SESSION['regFirst'];
	$name['Last_Name'] = $_SESSION['regLast'];
}

?>


<html>
<head>
	<SCRIPT LANGUAGE="JavaScript" SRC="CalendarPopup.js"></SCRIPT>
	<script type="text/javascript">
		//functions

		function clearTextField($id){
			var text = document.getElementById($id).value;
			if(text == "..."){
				return "";
			}
			else{
				return text;
			}
		}

		function SetCursorToTextEnd(textControlID)
	       {
       	     var text = document.getElementById(textControlID);
	            if (text != null && text.value.length > 0)
	            {
			     if (text.createTextRange)
		            {
		                    var FieldRange = text.createTextRange();
		                    FieldRange.moveStart('character', text.value.length);
		                    FieldRange.collapse();
		                    FieldRange.select();
              	     }
            	     }
        	}

		function reset($id){
			var text = document.getElementById($id).value;
			if(text != ""){
				document.getElementById($id).value = "";
			}
		}

		function resetDropDown($id){
			var selected = document.getElementById($id);
			selected.selectedIndex = 0;
		}


		function removeNewJob(){
			document.getElementById("newJob").innerHTML = "";
		}

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
	    
    	    	
		var cal = new CalendarPopup();
		cal.showYearNavigation(); 
		cal.showYearNavigationInput();

		function checkInterest(newUser) {
			check = newUser;
			if(check == 1) {
				hideDiv('interests');
			}
		}	
	
		function clearInt(id){
			var text = document.getElementById(id).value;
			if(text == "..."){
				document.getElementById(id).value = "";
			}

		}



	</script>

<title>Edit GTOnline Profile for <?php echo $name['First_Name']; echo " "; echo $name['Last_Name']; ?></title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
</head>
<body>

<h3><?php echo $name['First_Name']; echo " "; echo $name['Last_Name'];?></h3>

<form name="infoUpdate" method="post" action="<?php if($newUser==1){echo 'infoUpdate.php?edit=1';} else{echo 'infoUpdate.php';}?>">
<table width=80%;>
	<tr>
		<td><b>Sex</b></td>
		<td>
			<select name="sexOfUser" id="userSex">
				<?php if($info == null || $info['Sex'] == 'm'){
				?>
					<option value="m"; SELECTED>Male</option>
					<option value="f";>Female</option>
				<?php }else { ?>
					<option value="m";>Male</option>
					<option value="f"; SELECTED>Female</option>
				<?php } ?>
			</select>
		</td>
	</tr>
<?php if($bDayFail==1){echo "<tr><td></td><td>Please make sure you enter your birthdate</td></tr>";} ?>
	<tr>
		<td><b>Birthdate</b></td>
		<td>
			<input type="text" style="background: #ccc;" size="25" name="birthDate" readonly="readonly" id="birthDate" value=<?php echo $info['Birth_Date'];?>>
			<input name="Date" id="Date" type="button" value="Select a Date" onClick="cal.select(document.getElementById('birthDate'),'Date','yyyy-MM-dd'); return false;">
		</td>
	</tr>
	<tr>
		<td><b>Current City</b></td>
		<td>
			<input type="text" size="25" name="currCity" value='<?php if($info!=null){echo $info['Current_City'];}?>'>
		</td>
	</tr>
	<tr>
		<td><b>Hometown</b></td>
		<td>
			<input type="text" size="25" name="hometown" value='<?php if($info!=null){echo $info['Hometown'];}?>'>
		</td>
	</tr>

	<tr>
		<td><b>Interests</b></td>
		<?php 
		if($userInterests!=null)
		{
			while($row = mysql_fetch_assoc($userInterests)){
		?>	
			<td><?php echo $row['Interest']; ?></td>
		</tr>
		<tr>
			<td></td>
		<?php
			}
		}
		?>
	</tr>
	<tr>
		<td></td>	
		<?php if($newUser==1){echo "<td style=\"display: none;\">";} else{echo "<td>";} ?>
			<input name="userInterest" type="text" size="25" value="..." id="t"; onFocus="SetCursorToTextEnd(this.id); clearInt(this.id);">
			<!--<input name="submit" type="Submit" value="Add">-->
			
		</td>	
		
	</tr>
	</div>
</table>
<hr style="width:600px">
<h3>Education</h3>

<table>
	<?php
	if($userEducation!=null)
	{
		$count=0;
		$tempName = "name";
		$tempYear = "year";
		$deleteEdu = "delE";
		while($row = mysql_fetch_assoc($userEducation)){
			$currName = $tempName . $count;
			$currYear = $tempYear . $count;
			$date = "date" . $count;
			$formDel = $deleteEdu . $count;
	?>
			<tr>
				<td>
					<b>School: </b>
				</td>
				<td>
					<select name="<?php echo $currName; ?>">
						<option value="<?php echo $row['School_Name']; ?>">
							<?php echo $row['School_Name']; echo " ("; echo $row['Type']; echo")"; ?>
						</option>
						<?php while($row2 = mysql_fetch_assoc($otherSchools)){
								if($row2['Name'] != $row['School_Name']){
						?>
								<option value="<?php echo $row2['Name']; ?>">
									<?php echo $row2['Name']; echo " "; echo "("; echo $row2['Type']; echo")";?>	
								</option>
						<?php  	}
							} ?>
					</select>
					<?php mysql_data_seek($otherSchools,0);	?>
				</td>
				<td rowspan="2">
					<label>DELETE <input type="checkbox" name="deleteE[]" value="<?php echo $count; ?>"> </label>
				</td>
			</tr>
			<?php if($row['Year_Graduated'] != null){
			?>
			<tr>
				<td>
					<b>Year Grad: </b>
				</td>
				<td>	
					<input type="text" style="background: #ccc;" size="25" name="<?php echo $currYear; ?>" readonly="readonly" id="<?php echo $currYear;?>" value="<?php echo $row['Year_Graduated'];?>">
					<input name="<?php echo $date; ?>" id="<?php echo $date; ?>" type="button" value="Select a Date" onClick="cal.select(document.getElementById('<?php echo $currYear; ?>'),'Date','yyyy-MM-dd'); return false;">
				 <td>
				<br>
			</tr>
			<tr></tr><tr></tr>
			<?php	} 	else{ ?>
			<tr>
				<td>
					<b>Year Grad: </b>
				</td>
				<td>
					<input type="text" size="25" name="<?php echo $currYear; ?>" value="0000-00-00">
				</td>
			<tr>
				<tr></tr><tr></tr>
			<?php		}
				$count = $count + 1;
				}
				
			} ?>

</table>


<div id="newSchool" style="display: none;">
	<table>
		<tr>
			<td>
				<b>School: </b>
			</td>
			<td>
				<select name="newUserSchool" id="schoolSelect">
					<option value=""></option>
					<?php while($row2 = mysql_fetch_assoc($otherSchools)){
							if($row2['Name'] != $row['School_Name']){
					?>
						<option value="<?php echo $row2['Name']; ?>">
							<?php echo $row2['Name']; echo " "; echo "("; echo $row2['Type']; echo")";?>	
						</option>
					<?php  	}
						} ?>
				</select>
				<?php mysql_data_seek($otherSchools,0);	?>
			</td>
		</tr>
		<tr>
			<td>
				<b>Year Grad: </b>
			</td>
			<td>
				<input type="text" size="25" name="newSchoolYear" value="" id="newSchoolYear" readonly="readonly" style="background: #ccc;">
				<input name="newSchoolYear" id="newSchoolYear" type="button" value="Select a Date" onClick="cal.select(document.getElementById('newSchoolYear'),'Date','yyyy-MM-dd'); return false;">
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="button" value="Cancel" onClick="resetDropDown('schoolSelect'); reset('newSchoolYear'); hideDiv('newSchool');" >
			</td>
		</tr>
	</table>
</div>
<p align="center"><input type="button" value="Add Another School" onClick="showDiv('newSchool')"></p>
<hr style="width:600px">
<h3>Professional</h3>

<table>
		<?php
		if($userProfessional!=null)
		{
			$int = 0;
			$currComp = "comp";
			$currTitle = "title";
			while($row = mysql_fetch_assoc($userProfessional)){
				$thisName = $currComp . $int;
				$thisTitle = $currTitle . $int;
		?>
			<tr>
				<td><b>Employer</b></td>
				<td>	
					<select name="<?php echo $thisName; ?>" id="<?php echo $thisName; ?>">
						<option value="<?php echo $row['Employer_Name']; ?>"; SELECTED><?php echo $row['Employer_Name']; ?></option>
						<?php while($row2 = mysql_fetch_assoc($employers)) { 	
								if($row2['Name'] != $row['Employer_Name']) { ?>
									<option value="<?php echo $row2['Name'];?>"><?php echo $row2['Name'];?></option>
						<?php 		}
							} ?>
					</select>
					<?php mysql_data_seek($employers,0);?>

				</td>
				<td rowspan="2">
					<label>DELETE <input type="checkbox" name="deleteJ[]" value="<?php echo $int; ?>"> </label>
				</td>
			</tr>
			<tr>
				<td><b>Job Title</b></td>
				<td><input type="text" size="25" name="<?php echo $thisTitle; ?>" id="<?php echo $thisTitle; ?>" value='<?php echo $row['Job_Title']; ?>'></td>
			</tr>
			<tr></tr>
			<tr></tr>
		<?php
				$int = $int + 1;
			}
		}
		?>
		</table>
		<div id="newJob" style="display: none;">
			<table>
				<tr>
					<td> 
						<b>Employer</b>
					</td>
					<td>
						<select name="newEmployer" id="newEmployer">
							<option value=""></option>
							<?php while($row2 = mysql_fetch_assoc($employers)) { ?>
								<option value="<?php echo $row2['Name']; ?>"><?php echo $row2['Name'];?></option>
							<?php } ?>
						</select>
						<?php mysql_data_seek($employers,0);?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Job Title</b>
					</td>
					<td>
						<input type="text" size="25" name="newTitle" value="" id="newTitle">
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type='button' value='Cancel' onClick="resetDropDown('newEmployer'); reset('newTitle'); hideDiv('newJob');">
					</td>
				</tr>
			</table>
		</div>
<p align="center"><INPUT TYPE="button" value="Add Another Job" onClick="showDiv('newJob');"></p>
<hr style="width:600px">

<p align="center"><input type='button' value='Cancel' onClick=<?php if(!$newUser){echo "parent.location='regularUser.php'";} else{echo "parent.location='main_login.php'";} ?>>
<input type="submit" value="Save"></p>
 
</form>

<table>

</table>




</body>

</html>
