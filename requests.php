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
        <div id="cornerLogo"> <a href="homepage.php"> <img src="Images/logo2.png" width="217px" 
                onmouseover="this.src='Images/logo2_hover.png'  "
                onmouseout="this.src='Images/logo2.png'  "
                onmousedown="this.src='Images/logo2_hover.png'  "/></a> 
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
                <?php
				
					$sqlImage = "SELECT ProfilePic, ProfileType FROM User ";
                    $sqlImage .= "WHERE UserID=$userID";
                    $resultImage = mysql_query($sqlImage);
                    if($resultImage)
                    {
                        if(mysql_num_rows($resultImage) == 1)
                        {
                            $rowData2 = mysql_fetch_assoc($resultImage);
                            
                            $imgtype = $rowData2['ProfileType'];
                            $imgfile = "Profile/{$rowData2['ProfilePic']}";
							
							$imgname = $rowData2['ProfilePic'];
    						
							if ($imgtype == NULL)
							{
								$imgtype = 'image/jpeg';
                          		$imgfile = "Profile2/thumbnails_profilePic.jpg";
								
								$imgname = "profilePic.jpg";
								
								$imgbinary = fread(fopen($imgfile, "r"), filesize($imgfile));
								echo "<img src='data:image/$imgtype;base64," . base64_encode($imgbinary) . "' '/>";
							}
							else
							{
								 //http://stackoverflow.com/questions/9650572/resize-image-php
								$new_images = "thumbnails_".$imgname;
								//copy($rowData2,"Photos/".$rowData2['MediaTitle']);
								
								$height=105; //*** Fix Width & Heigh (Autu caculate) ***//
								$size=GetimageSize($imgfile);
								$width=round($height*$size[0]/$size[1]);
								$images_orig = ImageCreateFromJPEG($imgfile);
								$photoX = ImagesX($images_orig);
								$photoY = ImagesY($images_orig);
								$images_fin = ImageCreateTrueColor($width, $height);
								ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
								ImageJPEG($images_fin,"Profile2/".$new_images);
								
								
								$imgfile = "Profile2/".$new_images;
								$imgbinary = fread(fopen($imgfile, "r"), filesize($imgfile));
								echo "<img src='data:image/$imgtype;base64," . base64_encode($imgbinary) . "' '/>";
							}
						
                           
                            
                            ImageDestroy($images_orig);
                            ImageDestroy($images_fin);
                        }
                    }
				
				?>
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
       		<a href="profile.php?show=messages" style="text-decoration:none"><h2>Messages</h2> </a>
        </div>
        
        <div id="Circle">
       		 <a href="profile.php?show=circle" style="text-decoration:none"><h2>Circle</h2> </a>
        </div>
        
        <div id="CompletedQuests" >
       		 <a href="profile.php?show=completed" style="text-decoration:none"> <h2>Completed Quests</h2></a>
        </div>
    
    </div>
    <div id = "wrapper2">
    <div id = "wrapper3">
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
						
						$currentDate = date('Y-m-d H:i:s');
						
						$birthdaySql = "SELECT User.Birthday AS UserBirthday FROM User WHERE User.UserID = $userID"; // getting user birthday
						$birthdayResult = mysql_query($birthdaySql);
												
						while($bday = mysql_fetch_assoc($birthdayResult))
						{
							$birthday = strtotime($bday['UserBirthday']);
							$birthday = date('m-d',$birthday);
								
							list($bdayMonth,$bdayDay)=explode('-',$birthday);
							list($todayMonth,$todayDay)=explode('-',date('m-d',strtotime($currentDate)));
								
							if($bdayMonth == $todayMonth && $bdayDay == $todayDay)
							{
								$bdayQuestCheck = "SELECT Requests.QuestID FROM Requests WHERE Requests.RecieverID = $userID AND Requests.QuestID = 5";
								$bdayQuestCheckResult = mysql_query($bdayQuestCheck);
									
								$count = 0;	
								while ($row = mysql_fetch_assoc($bdayQuestCheckResult))
								{
									$count = $row['QuestID'];
								}

								if($count == 0)
								{
									$bdayQuestInsert = "INSERT INTO Requests VALUES (DEFAULT, 80, $userID, 5, 0)";
									$bdayResult = mysql_query($bdayQuestInsert);
								}
								else
								{
									
								}
							}
						}
						
						$sql = "SELECT Quests.Name, Quests.Description, Quests.QuestID, Requests.RecieverID FROM Quests INNER JOIN Requests ON Quests.QuestID=Requests.QuestID WHERE Requests.RecieverID = $userID AND Requests.Completed = '0'";
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
                            	<input type='hidden' name='MAX_FILE_SIZE' value='15000000'/>
								<textarea name="text" value=""></textarea>
								<input type='file' value='UPLOAD' name='imageFile'><br>
                            	<input type='submit' value='Post' name="<?php echo $i; ?>"> 
                            </form>
							</div>
							
							<hr>
                            
                            <?php
							//http://stackoverflow.com/questions/14890509/create-unique-form-input-ids-and-input-names-in-while-loop
							
							if(isset($_POST['text']))
								$text = $_POST['text'];
							else 
								$text = "";
								
							$array[$i] = array("formid"=>$i, "quest"=>$row["QuestID"], "text"=>$text, "user"=>$userID, "date"=>$currentDate);
							//print_r($array[$i]);
							$i++;
						}
						
						?>
                        <div style="margin-top:70px; margin-bottom:20px;">
                        <?php
						
							echo "You have no requests :(";
						?>
                        </div>
						<?php	
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
								//echo $uploadfile;
								if((strcasecmp(substr($uploadfile, -3, 3), "jpg") == 0) || (strcasecmp(substr($uploadfile, -3, 3), "png") == 0) || (strcasecmp(substr($uploadfile, -3, 3), "mp3") == 0))
								{
									if(!is_file($uploadpath))
									{
										if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $uploadpath))
										{
											if ((strcasecmp(substr($uploadfile, -3, 3), "jpg") == 0) || (strcasecmp(substr($uploadfile, -3, 3), "png") == 0))
											{
												$imgData = getimagesize($uploadpath); 
												$type = $imgData['mime'];
											}
											else 
											{
												$type = "audio/mp3";
											}
											
											//echo $imgData;
											echo $type;
											if((strcasecmp($type, "image/jpeg") == 0) || (strcasecmp($type, "image/png") == 0) || (strcasecmp($type, "audio/mp3") == 0))
											{
												echo "File ($uploadfile) of valid type ($type), and was stored as $uploadfile<br/>\n";
												
												if (strcasecmp($type, "audio/mp3") == 0)
												{
													$width = $height = 0;
												}
												else 
													$width = $imgData[0]; $height = $imgData[1];
													
												$sqlImg = "INSERT INTO Post (MediaType, MediaTitle, Height, Width, Date, CreatorID, Text, QuestID) ";
												$sqlImg .= "VALUES ( '$type', '$uploadfile', '$height', '$width', '$datetime', '$usersid', '$textentered', '$questid')";
												$resultImg = mysql_query($sqlImg);
												
												if($resultImg)
												{
													if(mysql_affected_rows() == 1)
														echo "Image data inserted into Database, with ID = ", mysql_insert_id();
													
													
													$pointsQuery = "SELECT User.Points AS UserPoints FROM User WHERE User.UserID = $userID";
													$pointsResult = mysql_query($pointsQuery);
													
													while($rows = mysql_fetch_assoc($pointsResult))
													{
														$pointsQuery2 = "SELECT Quests.Points AS QuestPoints FROM Quests WHERE Quests.QuestID = $questid";
														$pointsResult2 = mysql_query($pointsQuery2);
														
														while($rows2 = mysql_fetch_assoc($pointsResult2))
														{
															$questPoints = $rows2["QuestPoints"];
														}
														
														$userPoints = $rows["UserPoints"];
														
														$totalPoints = $userPoints + $questPoints;			

														$sqlpoints = "UPDATE User SET Points = $totalPoints WHERE UserID = $userID";
														$resultpoints = mysql_query($sqlpoints);
														
														$levelQuery = "SELECT User.Level AS UserLevel FROM User WHERE User.UserID = $userID";
														$levelResult = mysql_query($levelQuery);
													
														while($rows3 = mysql_fetch_assoc($levelResult))
														{
															$userLevel = $rows3["UserLevel"]; //getting user level
															
															if($userPoints < 1000) //checking number of points
															{
																$sqlLevel = "UPDATE User SET Level = $userLevel WHERE UserID = $userID";
																$levelup = mysql_query($sqlLevel);
															}
															else if($userPoints >= 1000) //if points are over 1000, "level up" user and reset points
															{
																$userLevel = $userLevel + 1;
																$sqlLevel = "UPDATE User SET Level = $userLevel WHERE UserID = $userID";
																$levelup = mysql_query($sqlLevel);
																
																$totalPoints = $userPoints - 1000;
																$sqlpoints = "UPDATE User SET Points = $totalPoints WHERE UserID = $userID";
																$pointsreset = mysql_query($sqlpoints);
															}
														}
													}													
												}
												
												$sqlMakeComplete = "UPDATE Requests SET Completed='1' ";
												$sqlMakeComplete .= "WHERE QuestID=$questid";
												$resultMakeComplete = mysql_query($sqlMakeComplete);
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
    </div>
    
</body>
<?php include_once "db_close.php"; ?>
</html>