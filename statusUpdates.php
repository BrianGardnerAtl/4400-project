<?php
//check if session is not registered, redirect back to main page.
session_start();
include_once "config.php";
if(!isset($_SESSION['email'])){
header("Location: main_login.php");
}

if(!isset($_SESSION['status'])){
$_SESSION['status'] = 3;
}

if(isset($_GET['more']) && $_GET['more']==0){
$_SESSION['status'] = 3;
}

if(isset($_GET['more']) && $_GET['more']==1){
$_SESSION['status'] += 3;
}


//Session Email  //
$email = $_SESSION['email'];

//SQL TABLE NAMES ///
$user = "USER";
$status_update = "STATUS_UPDATE";

// checks for the profile we are currently viewing
$currentProfile = $_GET['currentProfile'];
$currentProfile = stripslashes($currentProfile);
$currentProfile = mysql_real_escape_string($currentProfile); 
$isRegUser = "SELECT Email FROM REGULAR_USER WHERE Email = '$currentProfile'";
$regUser = mysql_query($isRegUser);
if(mysql_num_rows($regUser) == 1)
{
	$userName = mysql_fetch_assoc($regUser);
	$email = $userName['Email'];
}

//SQL QUERIES	///
$sql_userName = "SELECT First_Name, Last_Name From $user WHERE Email='$email'";
$userName = mysql_query($sql_userName);
$name = mysql_fetch_assoc($userName);


$sql_userStatusUpdates = "SELECT * FROM $status_update WHERE Email='$email' ORDER BY Date_And_Time DESC";
$userStatusUpdates = mysql_query($sql_userStatusUpdates);

//sql to get the comments for each status update


$formToHide = "";

?>

<html>
<head>
	<style type="text/css">
		textarea {
		overflow:auto;
		}
	</style>

	<script type="text/javascript">
		//functions

		function clearTextField($id){
			var text = document.getElementById($id).value;
			if(text == "Enter new Status Update Here"){
				return "";
			}
			else{
				return text;
			}
		}

		function clearCommentField($id){
			var text = document.getElementById($id).value;
			if(text == "Add Comment Here"){
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
			if(text == ""){
				document.getElementById($id).value = "Enter new Status Update Here";
			 }
		}

		var prevDiv = "";
		function showDiv(divName){
			if(prevDiv == ""){
				prevDiv = divName;
			}
			else{
				var prevLoc = document.getElementById(prevDiv);
				prevLoc.style.display = "none";
				prevDiv = divName;
			}
			
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

		function limitText(element,limit) 
		{
			if (element.value.length > limit) 
			{
				element.value = element.value.substring(0, limit);
			}
		}
</script>

	</script>

<title>Status Updates for <?php echo $name['First_Name']; echo " "; echo $name['Last_Name']; ?> </title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"> 
</head>

<body>
<h3><?php echo $name['First_Name']; echo " "; echo $name['Last_Name']; ?>'s Status Updates</h3>
<?php if( $email == $_SESSION['email'] ){	?>
	<form name="newStatusForm" method="post" action="addNewStatusUpdate.php">
	<table>
		<td id="status"><textarea rows="5" cols="50" name="newStatusUpdate" id="newStatus"; onKeyUp="limitText(this,200);" onKeyDown="limitText(this,200);" onClick="this.value = clearTextField(this.id);"; onFocus="SetCursorToTextEnd(this.id);";>Enter new Status Update Here</textarea></td>
		<td id="status"><button type="submit" name="addStatus">Add Update</button><td>
	</table>
	</form>
<?php } ?>
<br>

<table>
	
	<?php 
		$int = 0;
		$numDisplayed = 0;
		$numStatuses = $_SESSION['status'];
		while($numDisplayed < $numStatuses && $row = mysql_fetch_assoc($userStatusUpdates)){
	?>
		<tr>
			<td id="status"><?php echo "On "; echo date(" F jS\, Y \a\\t h:i A", strtotime($row['Date_And_Time'])); echo "  ";?></td>
			<td id="status"><button type="button" onClick="showDiv('test<?php echo $int;?>');";>Add Comment</button></td>
		</tr>
		<tr>
			<td id="status"><?php echo $row['Text']; ?></td>
		</tr>
		
			<?php 
				$temp = $row['Date_And_Time'];
				$sql_Comment = "SELECT c.Comment_Date_And_Time, c.Comment_Email, c.Text FROM STATUS_COMMENT c, STATUS_UPDATE s WHERE c.Update_Email=s.Email AND c.Update_Date_And_Time=s.Date_And_Time AND c.Update_Email='$email' AND s.Date_And_Time='$temp' ORDER BY c.Comment_Date_And_Time";
				$sql_com = mysql_query($sql_Comment);
				while($row2 = mysql_fetch_assoc($sql_com)){
					$tempName = $row2['Comment_Email'];
					$sql_Commenter_Name = "SELECT First_Name, Last_Name FROM USER WHERE Email='$tempName'";
					$sql_exec_name = mysql_query($sql_Commenter_Name);
					$sql_actual_name = mysql_fetch_assoc($sql_exec_name);
					?>
				<tr>
					<td id="comment" colspan="2"><?php echo "On "; echo date(" F jS\, Y \a\\t h:i A", strtotime($row2['Comment_Date_And_Time'])); echo " "; echo $sql_actual_name['First_Name']; echo " "; echo $sql_actual_name['Last_Name']; echo " wrote <br> "; echo $row2['Text'];  ?>
					</td>
				</tr>
				<?php } ?>
		<tr>
			<td id="comment">
				<?php $idName = "test" . $int ?>
				<div id="<?php echo $idName;?>"; style="display: none; padding-left:50px;">
					<form name="<?php echo $idName?>" method="post" action="addANewComment.php<?php echo '?currentProfile='; echo $email;?>";>
						<textarea rows='3' cols='40' name='newComment'; onKeyUp="limitText(this,200);" onKeyDown="limitText(this,200);" id='newComment'; onClick="this.value = clearCommentField(this.id);";>Add Comment Here</textarea>
						</br>
						<input type="hidden" name="update_date" value="<?php echo $row['Date_And_Time'];?>">
						<button type='submit'>Add Comment</button> 
						<button type='button' onClick="hideDiv('test<?php echo $int;?>');";>Cancel</button>
					</form>
				</div>
			</td>
		</tr>
		<tr><td colspan="2"><hr></td></tr>	
	<?php  		$int = $int + 1;
				$numDisplayed = $numDisplayed + 1;
		}
	?>
	
		<tr>
		<form>
		<td colspan="2" id="main"><input type='button' name="moreStatuses" value="View More..." OnClick="window.location.href='statusUpdates.php?currentProfile=<?php echo $email; ?>&more=1'"></td>
		</tr>

</table>




<p align="center"><a href="regularUser.php<?php echo '?currentProfile='; echo $email;?>">Back To Profile</a></p>
<?php if($email!=$_SESSION['email']) { ?>
<p align="center"><a href="regularUser.php">Back to Home</a></p>
<?php } ?>
</body>


</html>
