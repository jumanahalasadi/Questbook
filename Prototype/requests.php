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
	<title>Requests</title>
    
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
        <div id="requestsTabActive"><a href="requests.php" style="text-decoration:none"><h3>REQUESTS</h3></a></div>
    
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
            	<h3>REQUESTS</h3>
            </div>
             
            <div id="requests">
            		<?php	
					
						$userID = $_SESSION['userID'];
						$sql = "SELECT Quests.Name, Quests.Description, Quests.QuestID, Requests.RecieverID FROM Quests INNER JOIN Requests ON Quests.QuestID=Requests.QuestID WHERE Requests.RecieverID = $userID";
						$result = mysql_query($sql);
						
						$i = 0;
						global $array;
						
						while($row = mysql_fetch_assoc($result)){
							
							$q_name = $row["Name"];
							$q_d = $row["Description"];
													
							
           					echo "
							<br>
							<h4>".$q_name."</h4>
							<p>".$q_d."</p>
                       		";
							?>
							<div id ='postbox'>
							<br>
							<form action='requests.php'  method='POST' enctype="multipart/form-data">
                            	<input type='hidden' name='MAX_FILE_SIZE' value='3000000'/>
								<textarea name="text" value=""></textarea>
								<input type='file' value='UPLOAD' name='imageFile'><br>
                            	<input type='submit' value='Post' name="<?php echo $i; ?>"> 
                            </form>
							</div>
							
							<hr>
                            
                            <?php
							//http://stackoverflow.com/questions/14890509/create-unique-form-input-ids-and-input-names-in-while-loop
							
							$currentDate = date('Y-m-d H:i:s');
							
							if(isset($_POST['text']))
								$text = $_POST['text'];
							else 
								$text = "";
								
							$array[$i] = array("formid"=>$i, "quest"=>$row["QuestID"], "text"=>$text, "user"=>$userID, "date"=>$currentDate);
							//print_r($array[$i]);
							$i++;
							
							
						}
											
						$number = 0;
						
						
						while ($number < $i)
						{											
							if(isset($_POST[$number]) && isset($_FILES['imageFile']['name']))
							{
								
								
								$thearray = $array[$number];
								
								$questid = $thearray['quest'];
								$textentered = $thearray['text'];
								$usersid = $thearray['user'];
								$datetime = $thearray['date'];
								
								$uploaddir = getcwd()."/Uploads/";
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
												
												$sqlImg = "INSERT INTO Post (MediaType, MediaTitle, Date, CreatorID, Text, QuestID) ";
												$sqlImg .= "VALUES ( '$type', '$uploadfile', '$datetime', '$usersid', '$textentered', '$questid')";
												$resultImg = mysql_query($sqlImg);
												
												if($resultImg)
												{
													if(mysql_affected_rows() == 1)
														echo "Image data inserted into Database, with ID = ", mysql_insert_id();
												}
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
							
							$number++;
						}
					?>
            </div>
                    
        	<div id="specificsREQUESTS"> 	
            </div>
        </div>
        
        
        <!------------------------------------->
    </div>
    
</body>
<?php include_once "db_close.php"; ?>
</html>