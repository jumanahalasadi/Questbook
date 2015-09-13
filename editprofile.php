<?php
//session_start();
include_once "checkSession.php";
	
	if (checkCookie() == true){
		$userID = $_SESSION['userID'];

	}
	else 
		header("Location: index.php"); 


	if (!isset($_SESSION["userID"])){
		header("Location: index.php"); 
	}


?>

<?php include_once "db_open.php"; ?>

        <div id="heading">
        	<h1>Wall of Fame</h1>
        </div>
         
        <!------------------------------------->
        <div id = "postsSETTINGS">
        	<div id="questssettings">
            	<h3>PROFILE SETTINGS</h3>
            </div>
             
            <div id="profilesettings">
            	<?php	
				
					//This form is needed twice so I made it a variable to make code more readable
					$birthdayform = 
					"No birthday set!</h4><p>You have to set a birthday to get special quests! You can only set it once.</p>
               		<div id='postbox2'>
                	<form action='profile.php?show=settings' method='POST'>
                    	<select name='day'>
                        	<option value='Day'>Day</option>";
							
					for ($i = 1; $i < 32; $i++)
					{
						$birthdayform .= "<option value='".$i."'>".$i."</option>";
					}
					
					$birthdayform .= "</select>
                        <select name='month'>
                        	<option value='Month'>Month</option>";
					
					for ($i = 1; $i < 13; $i++)
					{
						$birthdayform .= "<option value='".$i."'>".$i."</option>";
					}
						
					$birthdayform .= "</select>
                        <select name='year'>
                        	<option value='Year'>Year</option>";
							
					for ($i = 2014; $i > 1903; $i--)
					{
						$birthdayform .= "<option value='".$i."'>".$i."</option>";
					}	
					
					$birthdayform .= "</select>
                    	<input type='submit' value='Set Birthday' name='birthdaysubmit'>
                    </form>";	
					
					//Get logged-in user's ID
					$userID = $_SESSION['userID'];
					//Get required fields from User table
					$sql = "SELECT User.FirstName, User.LastName, User.Password, User.Email, User.Birthday FROM User WHERE User.UserID = $userID";
					
					$result = mysql_query($sql);
					
					//Put all the SQL results into variables
					$row = mysql_fetch_assoc($result);
					
					$lastname = $row["LastName"];
					$firstname = $row["FirstName"];
						
					//Change birthday format (but keep old format stored in birthdate to check it later)
					$birthdate = date($row["Birthday"]);
					$birthday = strtotime($birthdate);
					$birthday = date('F j, Y', $birthday);
						
					$email = $row["Email"];
					$password = $row["Password"];
					
					
                ?>
                
                <br />
                <h4>First Name: 
				<?php 
				if(isset($_POST['firstnamesubmit']) && ($_POST['firstname'] != ""))
					$firstname = $_POST['firstname'];
				echo $firstname; 
				?>
                </h4>
                
                <div id="postbox2">
                	<form action='profile.php?show=settings' method='POST'>
                    	<textarea id="small" name="firstname" value=""></textarea>
                    	<input type='submit' value='Change First Name' name="firstnamesubmit">
                    </form>
                </div>
				<hr />
                
                <h4>Last Name: 
				<?php 
				if(isset($_POST['lastnamesubmit']) && ($_POST['lastname'] != ""))
					$lastname = $_POST['lastname'];
				echo $lastname; 
				?>
                </h4>
                
                <div id="postbox2">
                	<form action='profile.php?show=settings' method='POST'>
                    	<textarea id="small" name="lastname" value=""></textarea>
                    	<input type='submit' value='Change Last Name' name="lastnamesubmit">
                    </form>
                </div>
                <hr />
                
                <h4>Email: 
				<?php 
				if(isset($_POST['emailsubmit']) && ($_POST['email'] != ""))
				{
					$text = $_POST['email'];
					if(filter_var($text, FILTER_VALIDATE_EMAIL))
						$email = $_POST['email'];
				}
				echo $email; 
				?>
                </h4>
                
                <div id="postbox2">
                	<form action='profile.php?show=settings' method='POST'>
                    	<textarea id="small" name="email" value=""></textarea>
                    	<input type='submit' value='Change Email' name="emailsubmit">
                    </form>
                </div>	
                <hr />
                
                <h4>Password</h4>
                <div id="postbox2">
                	<form action='profile.php?show=settings' method='POST'>
                    	<h3>Old Password:  <input type="password" id="small" name="passold" value=""></textarea></h3>
                   		<h3>New Password:  <input type="password" id="small" name="passnew" value=""></textarea></h3>
                    	<input type='submit' value='Change Password' name="passwordsubmit">
                    </form>
                </div>
                <hr />
                
                <h4>Profile Picture</h4>
                <div id="postbox2">
                	<form action='profile.php?show=settings' method='POST' enctype="multipart/form-data">
                		<input type='hidden' name='MAX_FILE_SIZE' value='800000'/>
                   	 	<input type='file' value='UPLOAD' name='imageFile'><br>
                    	<input type='submit' value='Upload New Image' name="picsubmit">
                    </form> 
                </div>
                <hr />

                <h4>Birthday: 
				<?php 
				//Birthday can only be set once, since it does not change (and people could abuse it to get special quests all the time).
				//Already submitted a form
				if(isset($_POST['birthdaysubmit']))
				{
					//If all 3 fields filled out, the form is not displayed, only the new birthdatedate
					if($_POST['day'] != "Day" && $_POST['year'] != "Year" && $_POST['month'] != "Month")
					{ 
						$day = $_POST['day'];
						if ($day < 10)
							$day = "0$day";
						$month = $_POST['month'];
						if ($month < 10)
							$month = "0$month";
						$year = $_POST['year'];
						
						$setbirthday = date("$year-$month-$day");
						//Birthdate is reset if this is true
						$birthdate = $setbirthday;
	
						$birthday = strtotime($birthdate);
						$birthday = date('F j, Y', $birthday);
						
						echo $birthday;
					}
					
		 			//If all 3 fields are not filled out, birthdate is still 0000-00-00, so the form is displayed again
					else if($birthdate == "0000-00-00")
						echo $birthdayform;
						
				
				}
				//First time on page
				else
				{
					//No set birthday
					if($birthdate == "0000-00-00")
						echo $birthdayform;
						
					//Set Birthday
					else
						echo $birthday."</h4>";
				}
				?>
           		</div>	
				<?php
				
				//Change profile pic
                if(isset($_FILES['imageFile']['name']))
				{
					$uploaddir = getcwd()."/Profile/";
					$uploadfile = basename($_FILES['imageFile']['name']);
					$uploadpath = $uploaddir . $uploadfile;
					if((strcasecmp(substr($uploadfile, -3, 3), "jpg") == 0) || (strcasecmp(substr($uploadfile, -3, 3), "png") == 0))
					{
						if(!is_file($uploadpath))
						{
							if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $uploadpath))
							{
								$imgData = getimagesize($uploadpath); $type = $imgData['mime'];
								if((strcasecmp($type, "image/jpeg") == 0) || (strcasecmp($type, "image/png") == 0))
								{
									echo "File ($uploadfile) of valid type ($type), and was stored as $uploadfile<br/>\n";
												
									$sqlImg = "UPDATE User SET ProfileType='$type', ProfilePic='$uploadfile' ";
									$sqlImg .= "WHERE User.UserID = $userID";
									$resultImg = mysql_query($sqlImg);
								}
								else 
								{
									echo "Failed mime-checking <br/>"; 
									unlink($uploadpath);
								}
							}
							else
								echo "Upload Error, please try again!<br/>\n";
						}
						else
							echo "File already exists<br/>\n";
					}
					else
						echo "Only JPEG or PNG images are acceptable ($uploadfile) <br/>\n";
				}
				
				//Change First Name
				if(isset($_POST['firstnamesubmit']))
				{
					 if($_POST['firstname'] != "")
					 {
						 $text = $_POST['firstname'];
						 $sqlImg = "UPDATE User SET FirstName='$text' ";
						 $sqlImg .= "WHERE User.UserID = $userID";
						 $resultImg = mysql_query($sqlImg);
						 
						 echo "Your first name has been changed<br/>\n";
					 }
					 else
					 	echo "Please enter a new first name!<br/>\n";
				}
				
				//Change Last Name
				if(isset($_POST['lastnamesubmit']))
				{
					 if($_POST['lastname'] != "")
					 {
						 $text = $_POST['lastname'];
						 $sqlImg = "UPDATE User SET LastName='$text' ";
						 $sqlImg .= "WHERE User.UserID = $userID";
						 $resultImg = mysql_query($sqlImg);
						 
						 echo "Your last name has been changed<br/>\n";
					 }
					 else
					 	echo "Please enter a new last name!<br/>\n";
				}
				
				//Change Email
				if(isset($_POST['emailsubmit']))
				{
					 if($_POST['email'] != "")
					 {
						 $text = $_POST['email'];
						 
						 //http://stackoverflow.com/questions/1725907/check-if-a-string-is-an-email-address-in-php
						 if(filter_var($text, FILTER_VALIDATE_EMAIL)) {
        					 // valid address
							 $sqlImg = "UPDATE User SET Email='$text' ";
							 $sqlImg .= "WHERE User.UserID = $userID";
							 $resultImg = mysql_query($sqlImg);
						 
							 echo "Your email address has been changed<br/>\n";
   						 }
   						 else {
     					     // invalid address
							 echo "Please enter a valid email address!<br/>\n";
    					 }
						 
					 }
					 else
					 	echo "Please enter a new email address!<br/>\n";
				}
				
				//Change Password
				if(isset($_POST['passwordsubmit']))
				{
					 if($_POST['passold'] != "" && $_POST['passnew'] != "")
					 {
						 $checkpass =  md5($_POST['passold']);
						 
						 if (!strcmp($checkpass, $password))
						 {
							 $text = md5($_POST['passnew']);
							 $sqlImg = "UPDATE User SET Password='$text' ";
						 	 $sqlImg .= "WHERE User.UserID = $userID";
							 $resultImg = mysql_query($sqlImg);
						 
						 	 echo "Your password has been changed<br/>\n";
						 }
						 else
						 	 echo "Your old password was wrong!<br/>\n";
					 }
					 else
					 	echo "Please enter your old password and a new password!<br/>\n";
				}
				
				//Set Birthday 
				if(isset($_POST['birthdaysubmit']))
				{
					 if($_POST['day'] != "Day" && $_POST['year'] != "Year" && $_POST['month'] != "Month")
					 { 
					 	
						$day = $_POST['day'];
						if ($day < 10)
							$day = "0$day";
						$month = $_POST['month'];
						if ($month < 10)
							$month = "0$month";
						$year = $_POST['year'];
						
						$setbirthday = date("$year-$month-$day");
						$birthdate = $setbirthday;
						
						$sqlImg = "UPDATE User SET Birthday='$setbirthday' ";
						$sqlImg .= "WHERE User.UserID = $userID";
						$resultImg = mysql_query($sqlImg);
					 
						echo "Your birthday has been set<br/>\n";
					 }
					 else
					 	echo "Please select data from all 3 fields!<br/>\n";
				}
				?>			
            </div>

        </div>
        
        
        <!------------------------------------->

<?php include_once "db_close.php"; ?>
