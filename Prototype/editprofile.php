<?php
session_start();
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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_once "db_open.php"; ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
	<title>Edit Profile</title>
    
    <style>
		
		
	</style>
   
</head>

<body>


	<div id="topPage">
    	<div id="cornerLogo">
    		<a href="homepage.php"><img src="Images/logo2.png" width="217px" />
        </div>
	
    	<div id="profileTab"><a href="profile.php" style="text-decoration:none"><h3>MY PROFILE</h3></a></div>
    	<div id="exploreTab"><a href="explore.php" style="text-decoration:none"><h3>EXPLORE</h3></a></div>
        <div id="requestsTab"><a href="requests.php" style="text-decoration:none"><h3>REQUESTS</h3></a></div>
    
        <div id="logoutName">
        	<?php
			
				$userID = $_SESSION['userID'];
		
				$sql = "SELECT Username FROM User WHERE UserID = $userID ";
					$result = mysql_query($sql);
					
					while($row = mysql_fetch_assoc($result)){
						
						$user = $row["Username"];
						
					}
					
					echo "<p>" . "Logged in as: "  . "</p>";
					?>
                    <div id="toprightname">
                    <?php
					echo "<h2>" . $user . "</h2>";
					?>
                    </div>
                    <?php
			?>
           
        </div>
        
        <div id="logoutButton">
       		 <a href="index.php?logout=true" style="text-decoration:none"><h1>Log Out</h1></a>
      </div>
    </div>
 
    <div id="settings">
    		<img src="Images/seticon.png" width="30px;" />
        </div>
        
    
    <div id = "sidebar">
    
    	<div id="profile">
        
            <div id = "picture">
                <img src="Images/profilepicture.png" width="68%" />
            </div>
            
            <div id="profileInfo">
               <?php
				 
				$userID = $_SESSION['userID'];
				
				
				 	$sql = "SELECT Username, Level FROM User WHERE UserID =  $userID ";
					$result = mysql_query($sql);
					
					while($row = mysql_fetch_assoc($result)){
						
						$user = $row["Username"];
						$lvl = $row["Level"];
						
						
					 	echo "<h3>" . $user ." </h3>";
                	
                 		echo "<h1>" . "Level: " . $lvl . "</h1>";
						
					}
				 
				 	$sql = "SELECT FriendID FROM Friends WHERE UserID =  $userID";
					$result = mysql_query($sql);
					$num = mysql_num_rows($result);
				 
				 	echo "<h1>" . "Friends: " . $num . "</h1>";
				 
				 ?>
            </div>
        
        </div>
    
    	<div id="Messages">
       		 <a href="messages.php" style="text-decoration:none"> <h2>Messages</h2> </a>
        </div>
        
        <div id="Circle">
       		 <a href="circle.php" style="text-decoration:none"><h2>Circle</h2> </a>
        </div>
        
        <div id="CompletedQuests" >
       		 <a href="CompletedQuests.php" style="text-decoration:none"> <h2>Completed Quests</h2></a>
        </div>
    
    </div>
    
    <div id = "wrapper">
        <div id="heading">
        	<h1>Wall of Fame</h1>
        </div>
         
        <!------------------------------------->
        <div id = "postsREQUESTS">
        	<div id="questsheading">
            	<h3>PROFILE SETTINGS</h3>
            </div>
             
            <div id="profilesettings">
            	<?php	
				
					//This form is needed twice so I made it a variable to make code more readable
					$birthdayform = 
					"No birthday set!</h4><p>You have to set a birthday to get special quests! You can only set it once.</p>
               		<div id='postbox2'>
                	<form action='editprofile.php' method='POST'>
                    	<select name='day'>
                        	<option value='Day'>Day</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option>
                        </select>
                        <select name='month'>
                        	<option value='Month'>Month</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option>
                        </select>
                        <select name='year'>
                        	<option value='Year'>Year</option><option value='2014'>2014</option><option value='2013'>2013</option><option value='2012'>2012</option><option value='2011'>2011</option><option value='2010'>2010</option><option value='2009'>2009</option><option value='2008'>2008</option><option value='2007'>2007</option><option value='2006'>2006</option><option value='2005'>2005</option><option value='2004'>2004</option><option value='2003'>2003</option><option value='2002'>2002</option><option value='2001'>2001</option><option value='2000'>2000</option><option value='1999'>1999</option><option value='1998'>1998</option><option value='1997'>1997</option><option value='1996'>1996</option><option value='1995'>1995</option><option value='1994'>1994</option><option value='1993'>1993</option><option value='1992'>1992</option><option value='1991'>1991</option><option value='1990'>1990</option><option value='1989'>1989</option><option value='1988'>1988</option><option value='1987'>1987</option><option value='1986'>1986</option><option value='1985'>1985</option><option value='1984'>1984</option><option value='1983'>1983</option><option value='1982'>1982</option><option value='1981'>1981</option><option value='1980'>1980</option><option value='1979'>1979</option><option value='1978'>1978</option><option value='1977'>1977</option><option value='1976'>1976</option><option value='1975'>1975</option><option value='1974'>1974</option><option value='1973'>1973</option><option value='1972'>1972</option><option value='1971'>1971</option><option value='1970'>1970</option><option value='1969'>1969</option><option value='1968'>1968</option><option value='1967'>1967</option><option value='1966'>1966</option><option value='1965'>1965</option><option value='1964'>1964</option><option value='1963'>1963</option><option value='1962'>1962</option><option value='1961'>1961</option><option value='1960'>1960</option><option value='1959'>1959</option><option value='1958'>1958</option><option value='1957'>1957</option><option value='1956'>1956</option><option value='1955'>1955</option><option value='1954'>1954</option><option value='1953'>1953</option><option value='1952'>1952</option><option value='1951'>1951</option><option value='1950'>1950</option><option value='1949'>1949</option><option value='1948'>1948</option><option value='1947'>1947</option><option value='1946'>1946</option><option value='1945'>1945</option><option value='1944'>1944</option><option value='1943'>1943</option><option value='1942'>1942</option><option value='1941'>1941</option><option value='1940'>1940</option><option value='1939'>1939</option><option value='1938'>1938</option><option value='1937'>1937</option><option value='1936'>1936</option><option value='1935'>1935</option><option value='1934'>1934</option><option value='1933'>1933</option><option value='1932'>1932</option><option value='1931'>1931</option><option value='1930'>1930</option><option value='1929'>1929</option><option value='1928'>1928</option><option value='1927'>1927</option><option value='1926'>1926</option><option value='1925'>1925</option><option value='1924'>1924</option><option value='1923'>1923</option><option value='1922'>1922</option><option value='1921'>1921</option><option value='1920'>1920</option><option value='1919'>1919</option><option value='1918'>1918</option><option value='1917'>1917</option><option value='1916'>1916</option><option value='1915'>1915</option><option value='1914'>1914</option><option value='1913'>1913</option><option value='1912'>1912</option><option value='1911'>1911</option><option value='1910'>1910</option><option value='1909'>1909</option><option value='1908'>1908</option><option value='1907'>1907</option><option value='1986'>1906</option><option value='1905'>1905</option><option value='1904'>1904</option>
                        </select>
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
                	<form action='editprofile.php' method='POST'>
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
                	<form action='editprofile.php' method='POST'>
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
                	<form action='editprofile.php' method='POST'>
                    	<textarea id="small" name="email" value=""></textarea>
                    	<input type='submit' value='Change Email' name="emailsubmit">
                    </form>
                </div>	
                <hr />
                
                <h4>Password</h4>
                <div id="postbox2">
                	<form action='editprofile.php' method='POST'>
                    	<h3>Old Password:  <input type="password" id="small" name="passold" value=""></textarea></h3>
                   		<h3>New Password:  <input type="password" id="small" name="passnew" value=""></textarea></h3>
                    	<input type='submit' value='Change Password' name="passwordsubmit">
                    </form>
                </div>
                <hr />
                
                <h4>Profile Picture</h4>
                <div id="postbox2">
                	<form action='editprofile.php' method='POST' enctype="multipart/form-data">
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
						 $checkpass = $_POST['passold'];
						 
						 if (!strcmp($checkpass, $password))
						 {
							 $text = $_POST['passnew'];
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
    </div>
    
</body>
<?php include_once "db_close.php"; ?>
</html>